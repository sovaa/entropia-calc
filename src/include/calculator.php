<?php

class Calculator {
  const TO_SEC = 60;
  const SIB_RELOAD_NOT_ANYMORE_MOD = 1.25;
  const TO_EFF_DMG = 0.69375; // 0.75 * 0.925; # average damage is 75%, max hit rate is 92.5%

  public function calcWrapper(Weapon $weapon, $creature, $amp, $amp_fin, Search $search, array $scope_and_sights) {
    global $manager;

    $this->adjustAttacksForTeamSize($search, $weapon);
    $this->applyScopeAndSights($weapon, $scope_and_sights);
    $find_amps = $search->getFindAmplifiers();
    $find_fins = $search->getFindFinishers();
    $find_creatures = $search->getFindCreatures();

    $search->setFindAmplifiers(false);
    $search->setFindFinishers(false);
    $search->setFindCreatures(false);

    $results = $this->calc($weapon, $creature, $amp, $search);

    if ($results == null) {
      return null;
    }

    $search->setFindAmplifiers($find_amps);
    $search->setFindFinishers($find_fins);
    $search->setFindCreatures($find_creatures);

    $finishers = array();
    $amps = array();

    if ($search->getFindFinishers() && $creature != null) {
      $hp_left = $results['details']['lost_damage_in_overkill'];

      $finishers = $this->calculateFinishers($weapon, $creature, $hp_left, $amp_fin, $search);

      $results['details']['amp-laser-fin-id'] = $this->from_array($amp_fin, 'Laser', 'id');
      $results['details']['amp-blp-fin-id'] = $this->from_array($amp_fin, 'BLP', 'id');

      $this->aasort($finishers, 'cost');
      $tmp = array();

      $i = 0;
      foreach ($finishers as $finisher) {
        if ($i > 20) {
          break;
        }

        $tmp[] = $finisher;
        $i++;
      }

      $finishers = $tmp;
    }

    if ($search->getFindAmplifiers()) {
        $amps = $this->calculateOtherAmps($weapon, $creature, $amp, $search);
    }
    
    $other_creatures = array();
    if ($search->getFindCreatures()) {
        $all_creatures = $manager->getCreatures();
        $other_creatures = $this->calculateCreatures($weapon, $all_creatures, $amp, $search);
    }

    $results['details']['finishers'] = $finishers;
    $results['details']['amps'] = $amps;
    $results['details']['creatures'] = $other_creatures;

    return $results;
  }

  private function calc(Weapon $_weapon, array $_creature = null, array $_amplifiers, Search $_search) {
      $search = clone $_search;
      $weapon = clone $_weapon;
      $amplifiers = $this->cloneAmplifiers($_amplifiers);
      $creature = $_creature == null ? null : new Creature($_creature);

      return $this->calcWithClonedArguments($weapon, $amplifiers, $search, $creature);
  }

  private function calcWithClonedArguments(Weapon $weapon, array $amplifiers, Search $search, Creature $creature = null) {
    // only used to show the original weapon damage
    $weapon_damage = $weapon->getDamage();

    // TODO: check if modified $weapon in function needs to be returned?
    $enhancer = $this->tryToApplyEnhancers($search, $weapon);
    $search = $this->skillBased($search, $weapon);

    if ($this->shouldSkipUnknownSkill($search)) {
      return null;
    }

    $creature = $this->adjustCreatureHpRegen($search, $creature);
    $amp = $this->selectAmplifier($weapon, $amplifiers);

    if (!$this->shouldUseWeaponMarkup($search, $weapon)) {
      $weapon->setMarkup(100.0);
    }

    if ($amp->getDamage() != null && is_numeric($amp->getDamage())) {
      $weapon->setDamage(floatval($weapon->getDamage()) + floatval($amp->getDamage()));
    }

    // adjust amp decay if markup is used
    if ($this->shouldUseAmpMarkup($amp)) {
      $search->setUseAmpMarkup(true);
    }

    $weapon = Damage::calculateDamage($search, $weapon, $enhancer);
    $final = $this->finalCalculations($search, $weapon, $amp, $creature, $enhancer);

    // only for show
    if ($amp != null && is_numeric($amp->getBurn())) {
      $weapon->setBurn(floatval($weapon->getBurn()) + floatval($amp->getBurn()));
    }

    // creature cannot be killed with this weapon
    if ($final == null) {
        return null;
    }

    // only interested in alternative amplifiers
    if ($search->getFindAmplifiers()) {
        return $this->ampReturn($final['cost'], $amp, $weapon);
    }

    // only interested in finisher
    if ($search->getFindFinishers()) {
        return $this->finisherReturn($final['cost'], $final['cost_per_sec'], $weapon);
    }

    // only interested in other creatures
    if ($search->getFindCreatures()) {
        return $this->creatureReturn($final, $weapon, $creature);
    }

    $final = $this->postReturnCalculations($final, $weapon, $amp, $search);

    $result = Merger::addDetails(array(), $creature, $weapon, $amp, $final, $creature);
    $result = Merger::addAlwaysShownColumns($result, $search, $weapon, $final);
    $result = Merger::addBondTheoryToResult($search, $creature, $result, $final);
    $result = Merger::addRestOfColumns($result, $weapon, $final, $weapon_damage);
    $result = Merger::addMaximizeColumns($search, $result, $weapon, $amp, $final);
    $result = Merger::unsetForCreature($result, $creature);
    $result = Merger::unsetForAmp($result, $weapon, $amplifiers);
    $result = Merger::unsetMarkup($result, $search);

    return $result;
  }

    private function canUseEnhancers(Weapon $weapon) {
        $class = $weapon->getClass();

        if ($class == "Mindforce") {
            return false;
        }

        if ($class == "Attached") {
            return false;
        }

        if ($class == "Mounted") {
            return false;
        }

        return true;
    }

    private function applyEnhancers(Enhancer $enhancer, $enhancer_list, Weapon $weapon) {
        $class = $weapon->getClass();

        if ($enhancer_list == null || $class == 'Mindforce' || $class == 'Mounted') {
            return $enhancer;
        }

        foreach ($enhancer_list as $slot => $enhancer_type) {
            if ($enhancer_type === 0) {
                continue;
            }

            // accuracy
            if (floatval($enhancer_type) == 1) {
                $enhancer->addCrit(20);
                $enhancer->addAccuracyEnhancer($slot);
            }

            // damage
            if (floatval($enhancer_type) == 2) {
                $enhancer->addDamage(floatval($weapon->getDamage()) * 0.1);
                $enhancer->addAmmoBurn(floatval($weapon->getBurn()) * 0.1);
                $enhancer->addDurability(-(floatval($weapon->getDecay()) * 0.1));
                $enhancer->addDamageEnhancer($slot);
                continue;
            }

            // economy
            if (floatval($enhancer_type) == 3) {
                $enhancer->addDurability(floatval($weapon->getDecay()) * 0.01);
                $enhancer->addAmmoBurn(-(floatval($weapon->getBurn()) * 0.01));
                $enhancer->addEconomyEnhancer($slot);
                continue;
            }

            // range
            if (floatval($enhancer_type) == 4) {
                $enhancer->addRange(0.05);
                $enhancer->addRangeEnhancer($slot);
                continue;
            }

            // skill
            if (floatval($enhancer_type) == 5) {
                // TODO: don't know how it works
                $enhancer->addSkillEnhancer($slot);
                continue;
            }
        }

        return $enhancer;
    }

    private function skillBased(Search $search, Weapon $weapon) {
        if (is_numeric($search->getHitProfession()) || is_numeric($search->getDamageProfession())) {
            $search->setWantSkillBased(true);
        }
        else {
            $search->setWantSkillBased(false);
            $search->setSkillBased(false);
            $search->setHitProfession(100);
            $search->setDamageProfession(100);

            return $search;
        }

        if (!is_numeric($search->getHitProfession()) && !is_numeric($search->getDamageProfession())) {
            $search->setSkillBased(false);
            $search->setHitProfession(100);
            $search->setDamageProfession(100);
        }
        else {
            $search->setSkillBased(true);

            if (!is_numeric($search->getHitProfession())) {
                $search->setHitProfession($weapon->getHitMax());
            }
            else {
                $search->setHitProfession(floatval($search->getHitProfession()));
            }

            if (!is_numeric($search->getDamageProfession())) {
                $search->setDamageProfession($weapon->getDamageMax());
            }
            else {
                $search->setDamageProfession(floatval($search->getDamageProfession()));
            }

            if ($search->getDamageProfession() > 100) {
                $search->setDamageprofession(100.0);
            }

            if ($search->getHitProfession() > 100) {
                $search->setHitProfession(100.0);
            }

            // cannot calculate skill based if no max is known
            if (strlen($weapon->getHitMax()) == 0
                || strlen($weapon->getDamageMax()) == 0
                || is_numeric($weapon->getHitMax()) === false
                || is_numeric($weapon->getDamageMax()) === false)
            {
                $search->setSkillBased(false);
                $weapon->setHitMax(100.0);
                $weapon->setDamageMax(100.0);
                $search->setHitProfession(100.0);
                $search->setDamageProfession(100.0);
            }
        }

        if ($search->getSkillBased()) {
            if (floatval($search->getDamageProfession()) <= 0) {
                $search->setDamageProfession(0.001);
            }

            if (floatval($search->getHitProfession()) <= 0) {
                $search->setHitProfession(0.001);
            }
        }

        return $search;
    }

    private function shouldSkipUnknownSkill(Search $search) {
        return $search->getSkipUnknownSkill() && $search->getSkillBased() === false;
    }

    private function selectAmplifier(Weapon $weapon, $_amplifiers) {
        if ($_amplifiers == null || !array_key_exists(Utils::ampType($weapon->getType()), $_amplifiers)) {
            return new Amplifier();
        }

        $_amp = $_amplifiers[Utils::ampType($weapon->getType())];

        if ($_amp == null) {
            return new Amplifier();
        }

        return $_amp;
    }

    private function adjustCreatureHpRegen(Search $search, Creature $creature = null) {
        $hp = $search->getCreatureInputHp();
        $regen = $search->getCreatureInputRegen();
        $find_fin = $search->getFindFinishers();
        $find_creatures = $search->getFindCreatures();

        // don't adjust hp or regen here
        if ($find_creatures) {
            return $creature;
        }

        if (!$find_fin && $hp != null && is_numeric($hp)) {
            $temp = floatval($hp);

            if ($temp > 0) {
                $creature->setHp($temp);
            }
        }

        if ($regen != null && is_numeric($regen)) {
            $temp = floatval($regen);

            if ($temp > 0) {
                $creature->setRegen($temp);
            }
        }

        return $creature;
    }

    private function canUseScopeAndSights(Weapon $weapon) {
        $class = $weapon->getClass();

        if ($class == "Mindforce") {
            return false;
        }

        if ($class == "Attached") {
            return false;
        }

        if ($class == "Mounted") {
            return false;
        }

        if ($class == "Melee") {
            return false;
        }

        if ($class == "Support") {
            return false;
        }

        return true;
    }

    private function applyScopeAndSights(Weapon $weapon, $scope_and_sights) {
        if (!$this->canUseScopeAndSights($weapon)) {
            return;
        }
        
        foreach (array('scope', 'sight1', 'sight2') as $type) {
            $this->addWeaponDecayFromAttachment($weapon, $scope_and_sights[$type]);
            $this->addWeaponCritChanceFromAttachment($weapon, $scope_and_sights[$type]);
            $this->addWeaponCritDamageFromAttachment($weapon, $scope_and_sights[$type]);
        }
    }

    private function addWeaponDecayFromAttachment(Weapon $weapon, Attachment $attachment) {
        $w_value = $weapon->getDecay();
        $a_value = $attachment->getDecay();

        if ($a_value == null) {
            $a_value = 0.0;
        }
        if ($w_value == null) {
            $w_value = 0.0;
        }

        $weapon->setDecay(floatval($w_value) + floatval($a_value));
    }

    private function addWeaponCritChanceFromAttachment(Weapon $weapon, Attachment $attachment) {
        $w_value = $weapon->getCritChance();
        $a_value = $attachment->getCritChance();
        $weapon->setCritChance(floatval($w_value) + floatval($a_value));
    }

    private function addWeaponCritDamageFromAttachment(Weapon $weapon, Attachment $attachment) {
        $w_value = $weapon->getCritDamage();
        $a_value = $attachment->getCritDamage();
        $weapon->setCritDamage(floatval($w_value) + floatval($a_value));
    }

    private function tryToApplyEnhancers(Search $search, Weapon $weapon) {
        if ($this->canUseEnhancers($weapon)) {

            $enhancer = $this->applyEnhancers(new Enhancer(), $search->getEnhancerList(), $weapon);
            $weapon->setDecay(floatval($weapon->getDecay()) - $enhancer->getDurability());
            $weapon->setBurn(floatval($weapon->getBurn()) + $enhancer->getAmmoBurn());
            $weapon->setDamage(floatval($weapon->getDamage()) + $enhancer->getDamage());
            $weapon->setRange(floatval($weapon->getRange()) * $enhancer->getRange());
        }
        else {
            $enhancer = new Enhancer();
        }
        return $enhancer;
    }

  private function shouldUseWeaponMarkup(Search $search, Weapon $weapon) {
    if ($search->getUseWeaponMarkup() == false) {
      return false;
    }

    if (Utils::isLimited($weapon->getName())) {
      return true;
    }

    return false;
  }

  private function shouldUseAmpMarkup(Amplifier $amp) {
    $markup = $amp->getMarkup();
    
    if ($markup != null && is_numeric($markup)) {
      if (Utils::isLimited($amp->getName())) {
        return true;
      }
    }

    return false;
  }

  private function cloneAmplifiers($_amplifiers) {
    if ($_amplifiers == null) {
      return array();
    }

    $amplifiers = array();
    if (array_key_exists('Laser', $_amplifiers)) {
      $amplifiers['Laser'] = clone $_amplifiers['Laser'];
    }
    else {
      $amplifiers['Laser'] = null;
    }
        
    if (array_key_exists('BLP', $_amplifiers)) {
      $amplifiers['BLP'] = clone $_amplifiers['BLP'];
    }
    else {
      $amplifiers['BLP'] = null;
    }

    return $amplifiers;
  }
  
  private function postReturnCalculations($final, Weapon $weapon, Amplifier $amp, Search $search) {
    $final['_ammo_cost'] = 
            ($final['ammo_cost'] / 10000) * 
            ($weapon->getAttacks() / 60) * $final['time'];

    $no_markup_amp = $amp->getDecay() * ($weapon->getAttacks() / 60) * $final['time'];
    $final['_amp_decay'] = $no_markup_amp * $amp->getMarkup();

    $no_markup_weapon = $weapon->getDecay() * ($weapon->getAttacks() / 60) * $final['time'];
    $final['_weapon_decay'] = $no_markup_weapon * ($weapon->getMarkup() / 100);

    $final['_weapon_decay_from_markup'] = 0;
    $final['_amp_decay_from_markup'] = 0;
    
    if ($weapon->getMarkup() > 100) {
        $final['_weapon_decay_from_markup'] = $final['_weapon_decay'] - $no_markup_weapon;
    }

    if ($search->getUseAmpMarkup()) {
        $final['_amp_decay_from_markup'] = $final['_amp_decay'] - $no_markup_amp;
    }

    return $final;
  }
  
  private function finalCalculations(Search $search, Weapon $weapon, Amplifier $amp, Creature $creature = null, Enhancer $enhancer) {
    $damage = $weapon->getDamage();

    $final['weapon_dps'] = $damage * $weapon->getAttacks() / 60;

    // cannot be killed
    if ($creature != null && $creature->getRegen() > $final['weapon_dps']) {
        return null;
    }

    $final['weapon_decay_per_sec'] = 
            ($weapon->getDecay() * 
            ($weapon->getMarkup() / 100)) * 
            ($weapon->getAttacks() / 60);

    $final['amp_decay_per_sec'] = 
            $amp->getDecay() * 
            ($weapon->getAttacks() / 60);

    $final['ammo_cost'] = floatval($weapon->getBurn()) + floatval($amp->getBurn());
    
    $final['ammo_cost_per_sec'] = 
            ($final['ammo_cost'] / 100) * 
            ($weapon->getAttacks() / Calculator::TO_SEC);

    // cost in PECs
    $enhancer_decay = $this->calculateTotalEnhancerDecay($search, $enhancer, $weapon);
    $final['enhancer_decay_per_sec'] = $enhancer_decay['decay'];
    $final['enhancer_decay_per_sec_from_markup'] = $enhancer_decay['decay_from_markup'];

    // everything is in PECs
    $final['cost_per_sec'] = 
            floatval($final['amp_decay_per_sec']) +  
            floatval($final['weapon_decay_per_sec']) + 
            floatval($final['enhancer_decay_per_sec']) + 
            floatval($final['ammo_cost_per_sec']);

    if ($final['cost_per_sec'] == 0) {
        Utils::error("cost_per_sec is zero");
    }

    $final['time'] = $this->calculateTime($search, $creature, $final['weapon_dps']);

    $final['health_effective'] = 
            $final['time'] * 
            $final['weapon_dps'];

    $final['cost'] = 
            ($final['cost_per_sec'] * 
            $final['time']) / 100;

    $final['damage_per_pec'] = 
            $final['weapon_dps'] / 
            $final['cost_per_sec'];

    $final['overkill_cost'] = 0;
    $final['lost_damage_in_overkill'] = 0;
    $final['regen_cost'] = 0;
    $final['ped_per_hp'] = 0;

    if ($creature != null) {
        $final['lost_damage_in_overkill'] = $damage / 2;
        
        $final['ped_per_hp'] = 
                $final['cost'] / 
                $final['health_effective'];
                
        $final['overkill_cost'] = 
                $final['ped_per_hp'] * 
                $final['lost_damage_in_overkill'];

        $final['enhancer_cost'] = 0;
        $final['enhancer_cost_from_markup'] = 0;

        if ($search->getUseEnhancerDecay()) {
            $final['enhancer_cost'] = 
                $final['enhancer_decay_per_sec'] *
                $final['time'];

            $final['enhancer_cost_from_markup'] =
                $final['enhancer_decay_per_sec_from_markup'] *
                $final['time'];
        }
                
        $final['regen_cost'] = 
                $final['ped_per_hp'] * 
                ($final['health_effective'] - 
                $creature->getHp());
                
        $final['cost'] += $final['overkill_cost'];
    }

    if ($search->getBondTheory() && $creature != null) {
        $bond_set = Utils::bondTheory($creature->getHp(), $search->getBondLoot(), $search->getBondDpp(), $search->getBondMulti());
        $bond_mod = Utils::bondTheory($creature->getHp(), $search->getBondLoot(), $final['damage_per_pec'], $search->getBondMulti());

        $final['profit'] = ($bond_set['average'] / $final['cost']) * 100 - 100;
        $final['profit_mod'] = ($bond_mod['average'] / $final['cost']) * 100 - 100;
        $final['bond_min'] = $bond_mod['min'];
        $final['bond_max'] = $bond_mod['max'];
    }

    return $final;
  }

  private function calculateTotalEnhancerDecay(Search $search, Enhancer $enhancer, Weapon $weapon) {
    $total_decay = 0;
    $total_markup = 0;

    if (!$search->getUseEnhancerDecay()) {
        return array(
          'decay' => 0,
          'decay_from_markup' => 0
        );
    }

    $dem = $search->getDamageEnhancerMarkup();
    $det = $search->getDamageEnhancerTT();
    $ded = $search->getDamageEnhancerDecay();

    $sem = $search->getSkillEnhancerMarkup();
    $set = $search->getSkillEnhancerTT();
    $sed = $search->getSkillEnhancerDecay();

    $rem = $search->getRangeEnhancerMarkup();
    $ret = $search->getRangeEnhancerTT();
    $red = $search->getRangeEnhancerDecay();

    $eem = $search->getEconomyEnhancerMarkup();
    $eet = $search->getEconomyEnhancerTT();
    $eed = $search->getEconomyEnhancerDecay();

    $aem = $search->getAccuracyEnhancerMarkup();
    $aet = $search->getAccuracyEnhancerTT();
    $aed = $search->getAccuracyEnhancerDecay();

    for ($i = 0; $i < $enhancer->getDamageEnhancers(); $i++) {
      $eslot = $enhancer->getDamageEnhancerSlot($i);

      $edecay = $this->calculateEnhancerDecayCost(
              $dem[$eslot],
              $det[$eslot],
              $ded[$eslot],
              $weapon->getAttacks());

      $total_decay += $edecay['decay'];
      $total_markup += $edecay['decay_from_markup'];
    }

    for ($i = 0; $i < $enhancer->getSkillEnhancers(); $i++) {
      $eslot = $enhancer->getSkillEnhancerSlot($i);

      $edecay = $this->calculateEnhancerDecayCost(
              $sem[$eslot],
              $set[$eslot],
              $sed[$eslot],
              $weapon->getAttacks());

      $total_decay += $edecay['decay'];
      $total_markup += $edecay['decay_from_markup'];
    }

    for ($i = 0; $i < $enhancer->getRangeEnhancers(); $i++) {
      $eslot = $enhancer->getRangeEnhancerSlot($i);

      $edecay = $this->calculateEnhancerDecayCost(
              $rem[$eslot],
              $ret[$eslot],
              $red[$eslot],
              $weapon->getAttacks());

      $total_decay += $edecay['decay'];
      $total_markup += $edecay['decay_from_markup'];
    }

    for ($i = 0; $i < $enhancer->getAccuracyEnhancers(); $i++) {
      $eslot = $enhancer->getAccuracyEnhancerSlot($i);

      $edecay = $this->calculateEnhancerDecayCost(
              $aem[$eslot],
              $aet[$eslot],
              $aed[$eslot],
              $weapon->getAttacks());

      $total_decay += $edecay['decay'];
      $total_markup += $edecay['decay_from_markup'];
    }

    for ($i = 0; $i < $enhancer->getEconomyEnhancers(); $i++) {
      $eslot = $enhancer->getEconomyEnhancerSlot($i);

      $edecay = $this->calculateEnhancerDecayCost(
              $eem[$eslot],
              $eet[$eslot],
              $eed[$eslot],
              $weapon->getAttacks());

      $total_decay += $edecay['decay'];
      $total_markup += $edecay['decay_from_markup'];
    }

    // we want it in PECs
    $result = array(
        'decay' => $total_decay * 100,
        'decay_from_markup' => $total_markup * 100
    );

    return $result;
  }

  private function calculateEnhancerDecayCost($markup, $tt, $decay_rate, $attacks) {
    $decay_rate = 1/$decay_rate;
    $markup = $markup / 100;

    $decay = ($markup * $tt) * ($decay_rate * ($attacks / Calculator::TO_SEC));
    $no_markup = $decay / $markup;

    $result = array(
        'decay' => $decay,
        'decay_from_markup' => $decay - $no_markup
    );

    return $result;
  }
  
  private function ampReturn($cost, Amplifier $amp, Weapon $weapon) {
      if ($cost == 0) {
          return null;
      }

      return array(
          'id' => $amp->getId(), 
          'type' => Utils::ampType($weapon->getType()), 
          'name' => $amp->getName(), 
          'cost' => Utils::decimalToNumber($cost, 4)
      );
  }
  
  private function finisherReturn($cost, $cost_per_sec, Weapon $weapon) {
      if ($cost == 0) {
          return null;
      }
    
      $min = $cost_per_sec * 60.0 / $weapon->getAttacks() / 100.0;
      
      if ($cost < $min) {
          $cost = $min;
      }
        
      return array(
          'id' => $weapon->getId(), 
          'name' => $weapon->getName(), 
          'cost' => $cost
      );
  }
  
  private function creatureReturn(array $final, Weapon $weapon, Creature $creature) {
        $cost = $final['cost'];
        $cost_per_sec = $final['cost_per_sec'];
        #$overkill_cost = $final['overkill_cost'];
        #$regen_cost = $final['regen_cost'];
        $lost = $final['lost_damage_in_overkill'];
        $health_effective = $final['health_effective'];
        
      if ($cost == 0) {
          return null;
      }
    
      $min = $cost_per_sec * 60.0 / $weapon->getAttacks() / 100.0;
      
      if ($cost < $min) {
          $cost = $min;
      }
      
      $regen = $health_effective - $creature->getHp();
      $rank = ($lost + $regen) / $cost;
      
      return array(
          'id' => $creature->getId(), 
          'name' => $creature->getName(),
          'overkill' => $lost,
          'overkillp' => $lost / $health_effective * 100,
          'regen' => $regen,
          'regenp' => $regen / $health_effective * 100,
          'rank' => $rank,
          'cost' => $cost,
          'threat' => $creature->getThreat(),
          'damage' => $creature->getDamage(),
          'hp' => $creature->getHp()
      );
  }
  
  // approximation, 50000 iterations gives quite accurate results 
  private function calculateTime(Search $search, Creature $creature = null, $dps) {
      if ($creature == null) {
          return 0;
      }
      
      $hp = $creature->getHp();
      $reg = $creature->getRegen();
      
      if ($search->getIgnoreRegen() === true) {
      	return $hp / $dps;
      }

      if ($reg - $dps == 0) {
        $reg = $reg + 0.00001;
      }
      
      return -(($hp - $hp * pow($reg/$dps, 50000)) / ($reg - $dps));
  }
  
  function calculateCreatures(Weapon $_weapon, array $_creatures, array $_amp, Search $search) {
      $other_creatures = array();
        
      $_search = clone $search;
      $_search->setFindFinishers(false);
      $_search->setFindAmplifiers(false);
      $_search->setFindCreatures(true);
        
      foreach ($_creatures as $creature) {
          $other = $this->calc($_weapon, $creature, $_amp, $_search);
            
          if ($other == null) {
              continue;
          }
            
          array_push($other_creatures, $other);
      }
        
      return $other_creatures;
  }

  function calculateOtherAmps(Weapon $_weapon, array $creature, array $amp, Search $search) {
    global $manager;

    $amps = null;
    $weapon_type = Utils::ampType($_weapon->getType());

    $weapon = clone $_weapon;
    $amps = $manager->getAmps($weapon_type);

    if ($amps == null || count($amps) == 0) {
      return array();
    }

    $other_amps = array();

    foreach ($amps as $other_amp) {
      $other_amp = new Amplifier($other_amp);
      $amp_id = $this->getAmpId(@$amp[$weapon_type]);
        
      if ($other_amp->getId() != null && $amp_id != null && $other_amp->getId() == $amp_id) {
          continue;
      }

      if ($other_amp->getDamage() > $weapon->getDamage() * 0.5) {
          continue;
      }

      $amp_array = array($weapon_type => $other_amp);
      
      $_search = clone $search;
      $_search->setFindFinishers(false);
      $_search->setFindAmplifiers(true);
      
      $cost = $this->calc($weapon, $creature, $amp_array, $_search);

      if ($cost != null) {
          array_push($other_amps, $cost);
      }
    }

    return $other_amps;
  }

  function calculateFinishers($current_weapon, $_creature, $hp_left, array $amp, Search $search) {
    global $weapons;

    $creature = $_creature;
    $creature['hp'] = $hp_left;
    $finishers = array();

    foreach ($weapons as $weapon) {
      $weapon = new Weapon($weapon);

      if ($this->shouldSkipFinisher($current_weapon, $weapon, $search)) {
        continue;
      }

      $weapon_type = $weapon->getType();
      if ($this->from_array($amp, $weapon_type) != null) {
        if ($this->getAmpDamage($amp[$weapon_type]) > $weapon->getDamage() * 0.5) {
          continue;
        }
      }

      $_search = clone $search;
      
      $_search->setMaximize(false);
      $_search->setFindAmplifiers(false);
      $_search->setFindFinishers(true);

      // TODO: markup

      $cost = $this->calc($weapon, $creature, $amp, $_search);

      if ($cost != null) {
        array_push($finishers, $cost);
      }
    }

    return $finishers;
  }

  private function getAmpDamage(Amplifier $amp = null) {
      if ($amp == null) {
          return 0;
      }
      return $amp->getDamage();
  }

  private function getAmpId(Amplifier $amp = null) {
      if ($amp == null) {
          return -1;
      }
      return $amp->getId();
  }

  function shouldSkipFinisher(Weapon $current, Weapon $weapon, Search $search) {
    // don't suggest same weapons as main
    if ($current->getId() == $weapon->getId()) {
      return true;
    }
      
    // ignore limited weapons when finding finishers
    if (Utils::isLimited($weapon->getName())) {
      return true;
    }

    $type = $search->getFinisherType();
    $class = $search->getFinisherClass();

    if (isset($type) && $type != '--' && $weapon->getType() != $type) {
      return true;
    }

    if (isset($class) && $class != '--' && $weapon->getClass() != $class) {
      return true;
    }

    return false;
  }

  function adjustAttacksForTeamSize(Search $search, Weapon $weapon) {
    $size = $this->getTeamSize($search->getTeamSize());
    $weapon->setAttacks($weapon->getAttacks() * $size);
  }

  function getTeamSize($size) {
    if (is_numeric($size) && floatval($size) > 0) {
      $size = intval(floatval($size));
      if ($size > 0) {
        return $size;
      }
    }

    return 1; // default size is 1
  }

  function aasort(&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
  }

  function from_array($arr, $key1, $key2 = null) {
    if (!array_key_exists($key1, $arr)) {
        return null;
    }

    if ($key2 == null) {
        return $arr[$key1];
    }

    if (!array_key_exists($key2, $arr[$key1])) {
        return null;
    }

    return $arr[$key1][$key2];
  }
}
