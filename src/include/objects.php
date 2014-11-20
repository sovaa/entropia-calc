<?php

class Creature {
    private $_id;
    private $_name;
    private $_hp;
    private $_regen;
    private $_maturity;
    private $_damage;
    private $_threat;
    
    public function Creature($creature) {
        $this->_id = trim(@$creature['id']);
        $this->_name = trim(@$creature['name']);
        $this->_hp = floatval(trim(@$creature['hp']));
        $this->_regen = floatval(trim(@$creature['regen']));
        $this->_maturity = trim(@$creature['maturity']);
        $this->_damage = trim(@$creature['damage']);
        $this->_threat = trim(@$creature['threat']);

        if (!is_numeric($this->getDamage())) {
            $this->_damage = 0;
        }
        else {
            $this->_damage = floatval($this->getDamage());
        }

        if (!is_numeric($this->getThreat())) {
            $this->_threat = 0;
        }
        else {
            $this->_threat = floatval($this->getThreat());
        }
    }
    
    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getDamage() {
        return $this->_damage;
    }

    public function setDamage($dmg) {
        $this->_damage = $dmg;
    }

    public function getThreat() {
        return $this->_threat;
    }

    public function setThreat($threat) {
        $this->_threat = $threat;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getHp() {
        return $this->_hp;
    }

    public function setHp($hp) {
        $this->_hp = $hp;
    }

    public function getRegen() {
        return $this->_regen;
    }

    public function setRegen($regen) {
        $this->_regen = $regen;
    }

    public function getMaturity() {
        return $this->_maturity;
    }

    public function setMaturity($maturity) {
        $this->_maturity = $maturity;
    }
}

class Search {
    private $_useWeaponMarkup;
    private $_useAmpMarkup;
    private $_ignoreRegen;
    private $_maximize;
    private $_damageProfession;
    private $_hitProfession;
    private $_enhancerList;
    private $_creatureInputHp;
    private $_creatureInputRegen;
    private $_findFinishers;
    private $_findAmplifiers;
    private $_findCreatures;
    private $_enhancerListFinisher;
    private $_finisherType;
    private $_finisherClass;
    private $_skillBased;
    private $_wantSkillBased;
    private $_skipUnknownSkill;
    private $_bondTheory;
    private $_bondLoot;
    private $_bondDpp;
    private $_bondMulti;
    private $_useEnhancerDecay;
    private $_teamSize;

    private $_damageEnhancerMarkup;
    private $_rangeEnhancerMarkup;
    private $_accuracyEnhancerMarkup;
    private $_economyEnhancerMarkup;
    private $_skillEnhancerMarkup;

    private $_damageEnhancerDecay;
    private $_rangeEnhancerDecay;
    private $_accuracyEnhancerDecay;
    private $_economyEnhancerDecay;
    private $_skillEnhancerDecay;

    private $_damageEnhancerTT;
    private $_rangeEnhancerTT;
    private $_accuracyEnhancerTT;
    private $_economyEnhancerTT;
    private $_skillEnhancerTT;
    
    public function Search() {
        $this->_findAmplifiers = false;
        $this->_findFinishers = false;
        $this->_findCreatures = false;
        $this->_useAmpMarkup = false;
        $this->_skillBased = false;
        $this->_bondTheory = false;
        $this->_useEnhancerDecay = false;
        $this->_teamSize = 1;

        $this->_damageEnhancerMarkup = array();
        $this->_rangeEnhancerMarkup = array();
        $this->_accuracyEnhancerMarkup = array();
        $this->_economyEnhancerMarkup = array();
        $this->_skillEnhancerMarkup = array();

        $this->_damageEnhancerDecay = array();
        $this->_rangeEnhancerDecay = array();
        $this->_accuracyEnhancerDecay = array();
        $this->_economyEnhancerDecay = array();
        $this->_skillEnhancerDecay = array();

        $this->_damageEnhancerTT = array();
        $this->_rangeEnhancerTT = array();
        $this->_accuracyEnhancerTT = array();
        $this->_economyEnhancerTT = array();
        $this->_skillEnhancerTT = array();
    }

    public function getTeamSize() {
        return $this->_teamSize;
    }

    public function setTeamSize($size) {
        $this->_teamSize = $size;
    }

    public function setDamageEnhancerTT($enhancer) {
        $this->_damageEnhancerTT = $enhancer;
    }

    public function getDamageEnhancerTT() {
        return $this->_damageEnhancerTT;
    }

    public function setRangeEnhancerTT($enhancer) {
        $this->_rangeEnhancerTT = $enhancer;
    }

    public function getRangeEnhancerTT() {
        return $this->_rangeEnhancerTT;
    }

    public function setAccuracyEnhancerTT($enhancer) {
        $this->_accuracyEnhancerTT = $enhancer;
    }

    public function getAccuracyEnhancerTT() {
        return $this->_accuracyEnhancerTT;
    }

    public function setEconomyEnhancerTT($enhancer) {
        $this->_economyEnhancerTT = $enhancer;
    }

    public function getEconomyEnhancerTT() {
        return $this->_economyEnhancerTT;
    }

    public function setSkillEnhancerTT($enhancer) {
        $this->_skillEnhancerTT = $enhancer;
    }

    public function getSkillEnhancerTT() {
        return $this->_skillEnhancerTT;
    }

    public function setDamageEnhancerDecay($enhancer) {
        $this->_damageEnhancerDecay = $enhancer;
    }

    public function getDamageEnhancerDecay() {
        return $this->_damageEnhancerDecay;
    }

    public function setRangeEnhancerDecay($enhancer) {
        $this->_rangeEnhancerDecay = $enhancer;
    }

    public function getRangeEnhancerDecay() {
        return $this->_rangeEnhancerDecay;
    }

    public function setAccuracyEnhancerDecay($enhancer) {
        $this->_accuracyEnhancerDecay = $enhancer;
    }

    public function getAccuracyEnhancerDecay() {
        return $this->_accuracyEnhancerDecay;
    }

    public function setEconomyEnhancerDecay($enhancer) {
        $this->_economyEnhancerDecay = $enhancer;
    }

    public function getEconomyEnhancerDecay() {
        return $this->_economyEnhancerDecay;
    }

    public function setSkillEnhancerDecay($enhancer) {
        $this->_skillEnhancerDecay = $enhancer;
    }

    public function getSkillEnhancerDecay() {
        return $this->_skillEnhancerDecay;
    }

    public function setDamageEnhancerMarkup($enhancer) {
        $this->_damageEnhancerMarkup = $enhancer;
    }

    public function getDamageEnhancerMarkup() {
        return $this->_damageEnhancerMarkup;
    }

    public function setRangeEnhancerMarkup($enhancer) {
        $this->_rangeEnhancerMarkup = $enhancer;
    }

    public function getRangeEnhancerMarkup() {
        return $this->_rangeEnhancerMarkup;
    }

    public function setAccuracyEnhancerMarkup($enhancer) {
        $this->_accuracyEnhancerMarkup = $enhancer;
    }

    public function getAccuracyEnhancerMarkup() {
        return $this->_accuracyEnhancerMarkup;
    }

    public function setEconomyEnhancerMarkup($enhancer) {
        $this->_economyEnhancerMarkup = $enhancer;
    }

    public function getEconomyEnhancerMarkup() {
        return $this->_economyEnhancerMarkup;
    }

    public function setSkillEnhancerMarkup($enhancer) {
        $this->_skillEnhancerMarkup = $enhancer;
    }

    public function getSkillEnhancerMarkup() {
        return $this->_skillEnhancerMarkup;
    }

    public function getUseEnhancerDecay() {
        return $this->_useEnhancerDecay;
    }

    public function setUseEnhancerDecay($use) {
       $this->_useEnhancerDecay = $use;
    }

    public function getBondTheory() {
        return $this->_bondTheory;
    }

    public function setBondTheory($theory) {
       $this->_bondTheory = $theory;
    }

    public function getBondDpp() {
        return $this->_bondDpp;
    }

    public function setBondDpp($dpp) {
        $this->_bondDpp = $dpp;
    }

    public function getBondMulti() {
        return $this->_bondMulti;
    }

    public function setBondMulti($multi) {
        $this->_bondMulti = $multi;
    }

    public function getBondLoot() {
        return $this->_bondLoot;
    }

    public function setBondLoot($loot) {
        $this->_bondLoot = $loot;
    }

    public function getSkipUnknownSkill() {
        return $this->_skipUnknownSkill;
    }

    public function setSkipUnknownSkill($skip) {
        $this->_skipUnknownSkill = $skip;
    }

    public function getFindCreatures() {
        return $this->_findCreatures;
    }

    public function setFindCreatures($findCreatures) {
        $this->_findCreatures = $findCreatures;
    }
    
    public function getUseAmpMarkup() {
        return $this->_useAmpMarkup;
    }
    
    public function setUseAmpMarkup($use) {
        $this->_useAmpMarkup = $use;
    }
    
    public function setIgnoreRegen($ignore) {
    	$this->_ignoreRegen = $ignore;
    }
    
    public function getIgnoreRegen() {
    	return $this->_ignoreRegen;
    }
    
    public function getWantSkillBased() {
        return $this->_wantSkillBased;
    }
    
    public function setWantSkillBased($skillBased) {
        $this->_wantSkillBased = $skillBased;
    }
    
    public function getSkillBased() {
        return $this->_skillBased;
    }
    
    public function setSkillBased($skillBased) {
        $this->_skillBased = $skillBased;
    }
    
    public function getUseWeaponMarkup() {
        return $this->_useWeaponMarkup;
    }

    public function setUseWeaponMarkup($useWeaponMarkup) {
        $this->_useWeaponMarkup = $useWeaponMarkup;
    }

    public function getMaximize() {
        return $this->_maximize;
    }

    public function setMaximize($maximize) {
        $this->_maximize = $maximize;
    }

    public function getDamageProfession() {
        return $this->_damageProfession;
    }

    public function setDamageProfession($damage) {
        $this->_damageProfession = $damage;
    }

    public function getHitProfession() {
        return $this->_hitProfession;
    }

    public function setHitProfession($hitProfession) {
        $this->_hitProfession = $hitProfession;
    }

    public function getEnhancerList() {
        return $this->_enhancerList;
    }

    public function setEnhancerList($enhancerList) {
        $this->_enhancerList = $enhancerList;
    }

    public function getCreatureInputHp() {
        return $this->_creatureInputHp;
    }

    public function setCreatureInputHp($creatureInputHp) {
        $this->_creatureInputHp = $creatureInputHp;
    }

    public function getCreatureInputRegen() {
        return $this->_creatureInputRegen;
    }

    public function setCreatureInputRegen($creatureInputRegen) {
        $this->_creatureInputRegen = $creatureInputRegen;
    }

    public function getFindFinishers() {
        return $this->_findFinishers;
    }

    public function setFindFinishers($findFinishers) {
        $this->_findFinishers = $findFinishers;
    }

    public function getFindAmplifiers() {
        return $this->_findAmplifiers;
    }

    public function setFindAmplifiers($findAmplifiers) {
        $this->_findAmplifiers = $findAmplifiers;
    }

    public function getEnhancerListFinisher() {
        return $this->_enhancerListFinisher;
    }

    public function setEnhancerListFinisher($enhancerListFinisher) {
        $this->_enhancerListFinisher = $enhancerListFinisher;
    }

    public function getFinisherType() {
        return $this->_finisherType;
    }

    public function setFinisherType($finisherType) {
        $this->_finisherType = $finisherType;
    }

    public function getFinisherClass() {
        return $this->_finisherClass;
    }

    public function setFinisherClass($finisherClass) {
        $this->_finisherClass = $finisherClass;
    }
}

class Amplifier {
    private $_id;
    private $_decay;
    private $_damage;
    private $_burn;
    private $_markup;
    private $_name;

    public function Amplifier($amp = null) {
        if ($amp == null) {
            $this->_id = -1;
            $this->_decay = 0;
            $this->_damage = 0;
            $this->_burn = 0;
            $this->_markup = 100;
            $this->_name = "";

            return;
        }

        $this->_id = trim($amp['id']);
        $this->_name = trim($amp['name']);
        $this->_decay = trim($amp['decay']);
        $this->_damage = trim($amp['damage']);
        $this->_burn = trim($amp['burn']);
        $this->_markup = trim($amp['markup']);

        $this->_markup = str_replace('%', '', $this->getMarkup());

        if (!is_numeric($this->getMarkup()) || $this->getMarkup() == "0") {
            $this->_markup = 100;
        }
        else {
            $this->_markup = floatval($this->getMarkup());
        }
    }
    
    public function getId() {
        return $this->_id;
    }
    
    public function setId($id) {
        $this->_id = $id;
    }
    
    public function getName() {
        return $this->_name;
    }
    
    public function setName($name) {
        $this->_name = $name;
    }
    
    public function getDecay() {
        return $this->_decay;
    }
    
    public function getDamage() {
        return $this->_damage;
    }
    
    public function getBurn() {
        return $this->_burn;
    }
    
    public function getMarkup() {
        return $this->_markup;
    }
    
    public function setDecay($decay) {
        $this->_decay = $decay;
    }
    
    public function setDamage($damage) {
        $this->_damage = $damage;
    }
    
    public function setBurn($burn) {
        $this->_burn = $burn;
    }
    
    public function setMarkup($markup) {
        $this->_markup = $markup;
    }
}

class Attachment {
    private $_id;
    private $_name;
    private $_skillMod;
    private $_skillBonus;
    private $_zoom;
    private $_decay;
    private $_critChance;
    private $_critDamage;
    private $_markup;

    public function Attachment($_attachment = null) {
      if ($_attachment == null) {
        return;
      }
      $this->_id = trim($_attachment['id']);
      $this->_name = trim($_attachment['name']);
      $this->_skillMod = trim($_attachment['skillmod']);
      $this->_skillBonus = trim($_attachment['skillbonus']);
      $this->_zoom = trim($_attachment['zoom']);
      $this->_decay = trim($_attachment['decay']);
      $this->_critChance = trim($_attachment['critchance']);
      $this->_critDamage = trim($_attachment['critdamage']);
      $this->_markup = trim($_attachment['markup']);
    }

    public function getId() {
      return $this->_id;
    }
    public function setId($id) {
      $this->_id = $id;
    }

    public function getName() {
      return $this->_name;
    }
    public function setName($name) {
      $this->_name = $name;
    }
    
    public function getSkillMod() {
      return $this->_skillMod;
    }
    public function setSkillMod($skillMod) {
      $this->_skillMod = $skillMod;
    }

    public function getSkillBonus() {
      return $this->_skillBonus;
    }
    public function setSkillBonus($skillBonus) {
      $this->_skillBonus = $skillBonus;
    }

    public function getZoom() {
      return $this->_zoom;
    }
    public function setZoom($zoom) {
      $this->_zoom = $zoom;
    }

    public function getDecay() {
      return $this->_decay;
    }
    public function setDecay($decay) {
      $this->_decay = $decay;
    }

    public function getCritChance() {
      return $this->_critChance;
    }
    public function setCritChance($critChance) {
      $this->_critChance = $critChance;
    }

    public function getCritDamage() {
      return $this->_critDamage;
    }
    public function setCritDamage($critDamage) {
      $this->_critDamage = $critDamage;
    }

    public function getMarkup() {
      return $this->_markup;
    }
    public function setMarkup($markup) {
      $this->_markup = $markup;
    }
}

class Weapon {
    private $_id;
    private $_class;
    private $_type;
    private $_name;
    private $_damage;
    private $_range;
    private $_markup;
    private $_decay;
    private $_burn; // ammo burned per use
    private $_attacks;
    private $_hitRecommended;
    private $_hitMax;
    private $_damageRecommended;
    private $_damageMax;
    private $_hitProfession;
    private $_damageProfession;
    private $_sib;
    private $_source;
    private $_weight;
    private $_power;
    private $_minTt;
    private $_maxTt;
    private $_uses;
    private $_discovered;
    private $_found;
    private $_damageStab;
    private $_damageCut;
    private $_damageImpale;
    private $_damagePenetrate;
    private $_damageShear;
    private $_damageBurn;
    private $_damageCold;
    private $_damageAcid;
    private $_damageElectricity;
    private $_critChance; // used for scopes/lasers with crit bonus
    private $_critDamage; // used for scopes/lasers with crit bonus
    private $_criticalHitDamage;
    private $_criticalHitDamageBonus;
    private $_criticalHitRate;
    private $_criticalHitRateBonus;
    private $_criticalHitEnhancerBonus;
    private $_damageFrom;
    private $_damageTo;
    private $_maximumDamage;
    private $_effectiveDamage;
    
    public function Weapon($_weapon) {
        $this->_id = trim($_weapon['id']);
        $this->_class = trim($_weapon['class']);
        $this->_type = trim($_weapon['type']);
        $this->_name = trim($_weapon['name']);
        $this->_damage = trim($_weapon['damage']);
        $this->_range = trim($_weapon['range']);
        $this->_markup = trim($_weapon['markup']);
        $this->_decay = trim($_weapon['decay']);
        $this->_burn = trim($_weapon['burn']);
        $this->_attacks = trim($_weapon['attacks']);
        $this->_hitRecommended = trim($_weapon['hitrec']);
        $this->_hitMax = trim($_weapon['hitmax']);
        $this->_damageRecommended = trim($_weapon['dmgrec']);
        $this->_damageMax = trim($_weapon['dmgmax']);
        $this->_hitProfession = trim($_weapon['hitprof']);
        $this->_damageProfession = trim($_weapon['dmgprof']);
        $this->_sib = trim($_weapon['sib']);
        $this->_source = trim($_weapon['source']);
        $this->_weight = trim($_weapon['weight']);
        $this->_power = trim($_weapon['power']);
        $this->_minTt = trim($_weapon['mintt']);
        $this->_maxTt = trim($_weapon['maxtt']);
        $this->_uses = trim($_weapon['uses']);
        $this->_discovered = trim($_weapon['discovered']);
        $this->_found = trim($_weapon['found']);
        $this->_damageStab = trim($_weapon['dmgstb']);
        $this->_damageCut = trim($_weapon['dmgcut']);
        $this->_damageImpale = trim($_weapon['dmgimp']);
        $this->_damagePenetrate = trim($_weapon['dmgpen']);
        $this->_damageShear = trim($_weapon['dmgshr']);
        $this->_damageBurn = trim($_weapon['dmgbrn']);
        $this->_damageCold = trim($_weapon['dmgcld']);
        $this->_damageAcid = trim($_weapon['dmgacd']);
        $this->_damageElectricity = trim($_weapon['dmgelc']);
        $this->_critChance = 0.0;
        $this->_critDamage = 0.0;
        $this->_criticalHitDamage = 0.0;
        $this->_criticalHitDamageBonus = 0.0;
        $this->_criticalHitRate = 0.0;
        $this->_criticalHitRateBonus = 0.0;
        $this->_criticalHitEnhancerBonus = 0.0;
        $this->_damageFrom = 0.0;
        $this->_damageTo = 0.0;
        $this->_maximumDamage = 0.0;
        $this->_effectiveDamage = 0.0;

        $this->_markup = str_replace('%', '', $this->getMarkup());

        if (!is_numeric($this->getMarkup()) || $this->getMarkup() == "0") {
            $this->_markup = 100;
        }
        else {
            $this->_markup = floatval($this->getMarkup());
        }

        if (strlen($this->getHitMax()) > 0 && is_numeric($this->getHitMax())) {
          $this->_hitMax = (double)$this->getHitMax();
        }
    
        if (strlen($this->getDamageMax()) > 0 && is_numeric($this->getDamageMax())) {
          $this->_damageMax = (double)$this->getDamageMax();
        }
        
        $this->_attacks = floatval($this->getAttacks());
        $this->_hitMax = trim($this->getHitMax());
        $this->_damageMax = trim($this->getDamageMax());
        $this->_hitProfession = trim($this->getHitProfession());
        $this->_damageProfession = trim($this->getDamageProfession());
    }
    
    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getCritDamage() {
        return $this->_critDamage;
    }

    public function setCritDamage($critDamage) {
        $this->_critDamage = $critDamage;
    }

    public function getCritChance() {
        return $this->_critChance;
    }

    public function setCritChance($critChance) {
        $this->_critChance = $critChance;
    }

    public function getClass() {
        return $this->_class;
    }

    public function setClass($class) {
        $this->_class = $class;
    }

    public function getType() {
        return $this->_type;
    }

    public function setType($type) {
        $this->_type = $type;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getDamage() {
        return $this->_damage;
    }

    public function setDamage($damage) {
        $this->_damage = $damage;
    }

    public function getRange() {
        return $this->_range;
    }

    public function setRange($range) {
        $this->_range = $range;
    }

    public function getMarkup() {
        return $this->_markup;
    }

    public function setMarkup($markup) {
        $this->_markup = $markup;
    }

    public function getDecay() {
        return $this->_decay;
    }

    public function setDecay($decay) {
        $this->_decay = $decay;
    }

    public function getBurn() {
        return $this->_burn;
    }

    public function setBurn($burn) {
        $this->_burn = $burn;
    }

    public function getAttacks() {
        return $this->_attacks;
    }

    public function setAttacks($attacks) {
        $this->_attacks = $attacks;
    }

    public function getHitRecommended() {
        return $this->_hitRecommended;
    }

    public function setHitRecommended($hitRecommended) {
        $this->_hitRecommended = $hitRecommended;
    }

    public function getHitMax() {
        return $this->_hitMax;
    }

    public function setHitMax($hitMax) {
        $this->_hitMax = $hitMax;
    }

    public function getDamageRecommended() {
        return $this->_damageRecommended;
    }

    public function setDamageRecommended($damageRecommended) {
        $this->_damageRecommended = $damageRecommended;
    }

    public function getDamageMax() {
        return $this->_damageMax;
    }

    public function setDamageMax($damageMax) {
        $this->_damageMax = $damageMax;
    }

    public function getHitProfession() {
        return $this->_hitProfession;
    }

    public function setHitProfession($hitProfession) {
        $this->_hitProfession = $hitProfession;
    }

    public function getDamageProfession() {
        return $this->_damageProfession;
    }

    public function setDamageProfession($prof) {
        $this->_damageProfession = $prof;
    }

    public function getSib() {
        return $this->_sib;
    }

    public function setSib($sib) {
        $this->_sib = $sib;
    }

    public function getSource() {
        return $this->_source;
    }

    public function setSource($source) {
        $this->_source = $source;
    }

    public function getWeight() {
        return $this->_weight;
    }

    public function setWeight($weight) {
        $this->_weight = $weight;
    }

    public function getPower() {
        return $this->_power;
    }

    public function setPower($power) {
        $this->_power = $power;
    }

    public function getMinTt() {
        return $this->_minTt;
    }

    public function setMinTt($minTt) {
        $this->_minTt = $minTt;
    }

    public function getMaxTt() {
        return $this->_maxTt;
    }

    public function setMaxTt($maxTt) {
        $this->_maxTt = $maxTt;
    }

    public function getUses() {
        return $this->_uses;
    }
    public function setUses($uses) {
        $this->_uses = $uses;
    }

    public function getDiscovered() {
        return $this->_discovered;
    }
    public function setDiscovered($discovered) {
        $this->_discovered = $discovered;
    }

    public function getFound() {
        return $this->_found;
    }
    public function setFound($found) {
        $this->_found = $found;
    }

    public function getDamageStab() {
        return $this->_damageStab;
    }
    public function setDamageStab($damageStab) {
        $this->_damageStab = $damageStab;
    }

    public function getDamageCut() {
        return $this->_damageCut;
    }
    public function setDamageCut($damageCut) {
        $this->_damageCut = $damageCut;
    }

    public function getDamageImpale() {
        return $this->_damageImpale;
    }
    public function setDamageImpale($damageImpale) {
        $this->_damageImpale = $damageImpale;
    }

    public function getDamagePenetrate() {
        return $this->_damagePenetrate;
    }
    public function setDamagePenetrate($damagePenetrate) {
        $this->_damagePenetrate = $damagePenetrate;
    }

    public function getDamageShear() {
        return $this->_damageShear;
    }
    public function setDamageShear($damageShear) {
        $this->_damageShear = $damageShear;
    }

    public function getDamageBurn() {
        return $this->_damageBurn;
    }
    public function setDamageBurn($damageBurn) {
        $this->_damageBurn = $damageBurn;
    }

    public function getDamageCold() {
        return $this->_damageCold;
    }
    public function setDamageCold($damageCold) {
        $this->_damageCold = $damageCold;
    }

    public function getDamageAcid() {
        return $this->_damageAcid;
    }
    public function setDamageAcid($damageAcid) {
        $this->_damageAcid = $damageAcid;
    }

    public function getDamageElectricity() {
        return $this->_damageElectricity;
    }
    public function setDamageElectricity($damageElectricity) {
        $this->_damageElectricity = $damageElectricity;
    }

    public function getCriticalHitDamage() {
        return $this->_criticalHitDamage;
    }
    public function setCriticalHitDamage($criticalHitDamage) {
        $this->_criticalHitDamage = $criticalHitDamage;
    }

    public function getCriticalHitDamageBonus() {
        return $this->_criticalHitDamageBonus;
    }
    public function setCriticalHitDamageBonus($criticalHitDamageBonus) {
        $this->_criticalHitDamageBonus = $criticalHitDamageBonus;
    }

    public function getCriticalHitEnhancerBonus() {
        return $this->_criticalHitEnhancerBonus;
    }
    public function setCriticalHitEnhancerBonus($criticalHitEnhancerBonus) {
        $this->_criticalHitEnhancerBonus = $criticalHitEnhancerBonus;
    }

    public function getCriticalHitRate() {
        return $this->_criticalHitRate;
    }
    public function setCriticalHitRate($criticalHitRate) {
        $this->_criticalHitRate = $criticalHitRate;
    }

    public function getCriticalHitRateBonus() {
        return $this->_criticalHitRateBonus;
    }
    public function setCriticalHitRateBonus($criticalHitRateBonus) {
        $this->_criticalHitRateBonus = $criticalHitRateBonus;
    }

    public function getEffectiveDamage() {
        return $this->_effectiveDamage;
    }
    public function setEffectiveDamage($effectiveDamage) {
        $this->_effectiveDamage = $effectiveDamage;
    }

    public function getMaximumDamage() {
        return $this->_maximumDamage;
    }
    public function setMaximumDamage($maximumDamage) {
        $this->_maximumDamage = $maximumDamage;
    }

    public function getDamageFrom() {
        return $this->_damageFrom;
    }
    public function setDamageFrom($damageFrom) {
        $this->_damageFrom = $damageFrom;
    }

    public function getDamageTo() {
        return $this->_damageTo;
    }
    public function setDamageTo($damageTo) {
        $this->_damageTo = $damageTo;
    }
}

class Enhancer {
    private $_damage;
    private $_ammoBurn;
    private $_durability;
    private $_crit;
    private $_range;

    private $_damageEnhancers;
    private $_accuracyEnhancers;
    private $_rangeEnhancers;
    private $_skillEnhancers;
    private $_economyEnhancers;

    private $_damageEnhancerSlots;
    private $_accuracyEnhancerSlots;
    private $_rangeEnhancerSlots;
    private $_skillEnhancerSlots;
    private $_economyEnhancerSlots;
    
    public function Enhancer() {
        $this->_damage = 0;
        $this->_ammoBurn = 0;
        $this->_durability = 0;
        $this->_crit = 100;
        $this->_range = 1;

        $this->_damageEnhancers = 0;
        $this->_accuracyEnhancers = 0;
        $this->_rangeEnhancers = 0;
        $this->_skillEnhancers = 0;
        $this->_economyEnhancers = 0;

        $this->_damageEnhancerSlots = array();
        $this->_accuracyEnhancerSlots = array();
        $this->_rangeEnhancerSlots = array();
        $this->_skillEnhancerSlots = array();
        $this->_economyEnhancerSlots = array();
    }

    public function addDamageEnhancer($slot) {
        $this->_damageEnhancerSlots[$this->_damageEnhancers] = $slot;
        $this->_damageEnhancers += 1;
    }

    public function addAccuracyEnhancer($slot) {
        $this->_accuracyEnhancerSlots[$this->_accuracyEnhancers] = $slot;
        $this->_accuracyEnhancers += 1;
    }

    public function addRangeEnhancer($slot) {
        $this->_rangeEnhancerSlots[$this->_rangeEnhancers] = $slot;
        $this->_rangeEnhancers += 1;
    }

    public function addSkillEnhancer($slot) {
        $this->_skillEnhancerSlots[$this->_skillEnhancers] = $slot;
        $this->_skillEnhancers += 1;
    }

    public function addEconomyEnhancer($slot) {
        $this->_economyEnhancerSlots[$this->_economyEnhancers] = $slot;
        $this->_economyEnhancers += 1;
    }

    public function getDamageEnhancerSlot($i) {
        return $this->_damageEnhancerSlots[$i];
    }

    public function getAccuracyEnhancerSlot($i) {
        return $this->_accuracyEnhancerSlots[$i];
    }

    public function getRangeEnhancerSlot($i) {
        return $this->_rangeEnhancerSlots[$i];
    }

    public function getSkillEnhancerSlot($i) {
        return $this->_skillEnhancerSlots[$i];
    }

    public function getEconomyEnhancerSlot($i) {
        return $this->_economyEnhancerSlots[$i];
    }

    public function getDamageEnhancers() {
        return $this->_damageEnhancers;
    }

    public function getAccuracyEnhancers() {
        return $this->_accuracyEnhancers;
    }

    public function getRangeEnhancers() {
        return $this->_rangeEnhancers;
    }

    public function getSkillEnhancers() {
        return $this->_skillEnhancers;
    }

    public function getEconomyEnhancers() {
        return $this->_economyEnhancers;
    }
    
    public function addDamage($bonus) {
        $this->_damage += $bonus;
    }
    
    public function addAmmoBurn($bonus) {
        $this->_ammoBurn += $bonus;
    }
    
    public function addDurability($bonus) {
        $this->_durability += $bonus;
    }
    
    public function addCrit($bonus) {
        $this->_crit += $bonus;
    }
    
    public function addRange($bonus) {
        $this->_range += $bonus;
    }
    
    public function getDamage() {
        return $this->_damage;
    }
    
    public function getAmmoBurn() {
        return $this->_ammoBurn;
    }
    
    public function getDurability() {
        return $this->_durability;
    }
    
    public function getCrit() {
        return $this->_crit;
    }
    
    public function getRange() {
        return $this->_range;
    }
}

?>

