<?php

require_once("init.php");

function getCreature(Manager $manager, $data, $hp, $regen) {
    $creature = array();

    if (isset($data) && is_numeric($data) && floatval($data) >= 0) {
        $creature = $manager->getCreature($data);
    }
    else if (!is_numeric($hp) || floatval($hp) <= 0) {
        return null;
    }
    else {
        $creature['hp'] = $hp;
        $creature['regen'] = $regen;
        $creature['id'] = -1;
        $creature['maturity'] = 0;
    }

    return $creature;
}

$__hp = 0;
$__regen = 0;

if (count($creature_input_hp) < 20 && is_numeric($creature_input_hp) && floatval($creature_input_hp) > 0) {
    $__hp = floatval($creature_input_hp);
}

if (count($creature_input_reg) < 20 && is_numeric($creature_input_reg) && floatval($creature_input_reg) > 0) {
    $__regen = floatval($creature_input_reg);
}

if (isset($data['creature'])) {
  include(PATH . "/include/calculator.php");

  $calc = new Calculator();
  $creature = getCreature($manager, $data['creature'], $__hp, $__regen);

  // ordinary amp
  $amplifier = array();
  $amplifier['BLP'] = getAmplifier($amp_markup, $data['amp_blp']);
  $amplifier['Laser'] = getAmplifier($amp_markup, $data['amp_energy']);

  /*
  if ($amplifier['Laser'] != null) {
    $seaid = $amplifier['Laser']->getId();
  }

  if ($amplifier['BLP'] != null) {
    $sbaid = $amplifier['BLP']->getId();
  }
  */

  $scope_and_sights = array();
  $scope_and_sights['scope'] = getScope($selected_scope_id);
  $scope_and_sights['sight1'] = getSight($selected_sight1_id);
  $scope_and_sights['sight2'] = getSight($selected_sight2_id);

  // finisher amp
  $amp_markup_fin = 0; // TODO: implement this
  $amplifier_fin = array();
  $amplifier_fin['BLP'] = getAmplifier($amp_markup_fin, $finisher_amp_blp);
  $amplifier_fin['Laser'] = getAmplifier($amp_markup_fin, $finisher_amp_energy);

  $weapon_id = array_key_exists('weapon-id', $data) ? $data['weapon-id'] : null;
  
  $results = array();
  $weapons = getWeapons($weapon_id);

  foreach ($weapons as $weapon) {
    // weapon type selected
    if ($selected_type != null && $selected_type != '--' && $weapon['type'] != $selected_type) {
      continue;
    }

    // weapon class selected
    if ($selected_class != null && $selected_class != '--' && $weapon['class'] != $selected_class) {
      continue;
    }

    // see if the filters will reduce the result
    if (Filter::shouldFilter($weapon, $filter_name_list, $filter_match_list, $filter_value_list) == false) {
      continue;
    }

    if (Utils::shouldSkip($weapon['name'], $skip_list)) {
      continue;
    }
    
    if ($skip_limited && Utils::isLimited($weapon['name'])) {
    	continue;
    }

    $weapon = createWeapon($weapon);

    applyWeaponBuffs($weapon);

    // can only increase damage by 50%
    if (ampTooPowerful($weapon, $amplifier)) {
        continue;
    }

    $post = 'markup-' . $weapon->getId();
    if (array_key_exists($post, $data) && $data[$post] != null) {
        if ($data[$post] != "0" && is_numeric($data[$post])) {
            $weapon->setMarkup($data[$post]);
        }
    }
    
    $search = new Search();
    
    $search->setFindAmplifiers($find_amplifiers);
    $search->setFindFinishers($find_finishers);
    $search->setFindCreatures($find_creatures);
    $search->setCreatureInputHp($creature_input_hp);
    $search->setCreatureInputRegen($creature_input_reg);
    $search->setMaximize($maximize);
    $search->setDamageProfession($damage_profession);
    $search->setHitProfession($hit_profession);
    $search->setEnhancerList(getFilterEnhancers($enhancer_list));
    $search->setEnhancerListFinisher(getFilterEnhancers($enhancer_list_fin));
    $search->setFinisherType($selected_type_fin);
    $search->setFinisherClass($selected_class_fin);
    $search->setUseWeaponMarkup($use_weapon_markup);
    $search->setIgnoreRegen($ignore_regen);
    $search->setSkipUnknownSkill($skip_unknown_skill);
    $search->setTeamSize($team_size);
    $search->setBondTheory($bond_theory);
    $search->setBondLoot($bond_loot);
    $search->setBondDpp($bond_dpp);
    $search->setBondMulti($bond_multi);
    $search->setUseEnhancerDecay($use_enhancer_decay);

    if ($use_enhancer_decay) {
        $search = getEnhancerStats($search, $enhancer_markups, $enhancer_decays, $enhancer_types);
    }

    if (is_numeric($amp_markup) && floatval($amp_markup) > 0) {
        $search->setUseAmpMarkup(true);
    }
    else {
        $search->setUseAmpMarkup(false);
    }

    if (TEST) {
        echo("weapon: <br />" . base64_encode(serialize($weapon)) . "<br /><br />");
        echo("creature: <br />" . base64_encode(serialize($creature)) . "<br /><br />");
        echo("amplifier: <br />" . base64_encode(serialize($amplifier)) . "<br /><br />");
        echo("amplifier_fin: <br />" . base64_encode(serialize($amplifier_fin)) . "<br /><br />");
        echo("search: <br />" . base64_encode(serialize($search)) . "<br /><br />");
        echo("scope_and_sights: <br />" . base64_encode(serialize($scope_and_sights)) . "<br /><br />");
    }

    $result = $calc->calcWrapper($weapon, $creature, $amplifier, $amplifier_fin, $search, $scope_and_sights);

    if (TEST) {
        echo("result: <br />" . base64_encode(serialize($result)) . "<br /><br />");
        die();
    }


    if ($result != null) {
      if (Filter::shouldFilter($result, $filter_name_list, $filter_match_list, $filter_value_list) == false) {
        continue;
      }

      $results[] = $result;
    }
  }
}

function getEnhancerStats($search, $markup, $decay, $types) {
    global $manager;

    $stats = $manager->getWeaponEnhancers();

    $dmg_tts = array();
    $range_tts = array();
    $acc_tts = array();
    $eco_tts = array();
    $skill_tts = array();

    $dmg_markups = array();
    $range_markups = array();
    $acc_markups = array();
    $eco_markups = array();
    $skill_markups = array();
    
    $dmg_decays = array();
    $range_decays = array();
    $acc_decays = array();
    $eco_decays = array();
    $skill_decays = array();

    foreach ($stats as $stat) {
        $slot = $stat['slot'];

        if (stripos($stat['name'], 'Damage') !== false) {
            $dmg_tts[$slot] = $stat['tt'];
        }
        else if (stripos($stat['name'], 'Range') !== false) {
            $range_tts[$stat['slot']] = $stat['tt'];
        }
        else if (stripos($stat['name'], 'Accuracy') !== false) {
            $acc_tts[$stat['slot']] = $stat['tt'];
        }
        else if (stripos($stat['name'], 'Economy') !== false) {
            $eco_tts[$stat['slot']] = $stat['tt'];
        }
        else if (stripos($stat['name'], 'Skill') !== false) {
            $skill_tts[$stat['slot']] = $stat['tt'];
        }
    }

    foreach ($markup as $slot => $mark) {
        $type = $types[$slot];

        if (stripos($type, 'Damage') !== false) {
            $dmg_markups[$slot] = $mark;
            $dmg_decays[$slot] = $decay[$slot];
        }
        else if (stripos($type, 'Range') !== false) {
            $range_markups[$slot] = $mark;
            $range_decays[$slot] = $decay[$slot];
        }
        else if (stripos($type, 'Accuracy') !== false) {
            $acc_markups[$slot] = $mark;
            $acc_decays[$slot] = $decay[$slot];
        }
        else if (stripos($type, 'Economy') !== false) {
            $eco_markups[$slot] = $mark;
            $eco_decays[$slot] = $decay[$slot];
        }
        else if (stripos($type, 'Skill') !== false) {
            $skill_markups[$slot] = $mark;
            $skill_decays[$slot] = $decay[$slot];
        }
    }

    $search->setDamageEnhancerMarkup($dmg_markups);
    $search->setRangeEnhancerMarkup($range_markups);
    $search->setAccuracyEnhancerMarkup($acc_markups);
    $search->setEconomyEnhancerMarkup($eco_markups);
    $search->setSkillEnhancerMarkup($skill_markups);

    $search->setDamageEnhancerDecay($dmg_decays);
    $search->setRangeEnhancerDecay($range_decays);
    $search->setAccuracyEnhancerDecay($acc_decays);
    $search->setEconomyEnhancerDecay($eco_decays);
    $search->setSkillEnhancerDecay($skill_decays);

    $search->setDamageEnhancerTT($dmg_tts);
    $search->setRangeEnhancerTT($range_tts);
    $search->setAccuracyEnhancerTT($acc_tts);
    $search->setEconomyEnhancerTT($eco_tts);
    $search->setSkillEnhancerTT($skill_tts);

    return $search;
}

function getScope($id) {
    if ($id == null || !is_numeric($id)) {
      return new Attachment();
    }
    global $manager;
    return new Attachment($manager->getScope($id));
}

function getSight($id) {
    if ($id == null || !is_numeric($id)) {
      return new Attachment();
    }
    global $manager;
    return new Attachment($manager->getSight($id));
}

function getAmplifier($amp_markup, $id) {
    global $manager;

    $amplifier = new Amplifier($manager->getAmp($id));
    
    if (!is_numeric($amp_markup)) {
        $amplifier->setMarkup(1.0);
        return $amplifier;
    }
    
    if (strlen($amp_markup) > 15) {
        $amplifier->setMarkup(1.0);
    }
    else {
        $amplifier->setMarkup(floatval($amp_markup) / 100);
    }
    
    return $amplifier;
}

function applyWeaponBuffs(Weapon $weapon) {
    global $buff_reload_speed;
    global $buff_damage;
    global $buff_skill_req;
    global $buff_ammo_burn;
    global $buff_crit_chance;
    global $buff_crit_damage;

    $weapon->setAttacks(applyBuffTo($buff_reload_speed, $weapon->getAttacks()));
    $weapon->setDamage(applyBuffTo($buff_damage, $weapon->getDamage()));
    $weapon->setBurn(applyBuffTo($buff_ammo_burn, $weapon->getBurn()));
    $weapon->setHitMax(applyBuffTo($buff_skill_req, $weapon->getHitMax()));
    $weapon->setDamageMax(applyBuffTo($buff_skill_req, $weapon->getDamageMax()));
    $weapon->setCritChance(applyPercentBuffTo($buff_crit_chance, $weapon->getCritChance()));
    $weapon->setCritDamage(applyBuffTo($buff_crit_damage, $weapon->getCritDamage()));
}

function applyPercentBuffTo($buff, $orig) {
    global $buff_floor_values;

    if ($buff !== null && $buff !== 0) {
        $val = $orig + $buff;
        if ($buff_floor_values) {
            return intval($val);
        }
        else {
            return intval(round($val));
        }
    }

    return $orig;
}

function applyBuffTo($buff, $orig) {
    global $buff_floor_values;

    if ($buff !== null && $buff !== 0) {
        $val = $orig * percentToMultiplyValue($buff);
        if ($buff_floor_values) {
            return intval($val);
        }
        else {
            return intval(round($val));
        }
    }

    return $orig;
}

function percentToMultiplyValue($percent) {
    return (100 + $percent) / 100;
}

function createWeapon($weapon) {
    return new Weapon($weapon);
}

function getWeapons($weapon_id) {
    global $manager;

    $weapons = array();
    
    if (isset($weapon_id) && $weapon_id != null && is_numeric($weapon_id)) {
        $_weapon = $manager->getWeapon($weapon_id);
        $_weapon['weapon_name'] = $_weapon['name'];
        $weapons[] = $_weapon;
    }
    else {
        $_weapons = $manager->getWeapons();
      
          foreach ($_weapons as $_weapon) {
              $_weapon['weapon_name'] = $_weapon['name'];
              $weapons[] = $_weapon;
          }
    }
    
    return $weapons;
}

function ampTooPowerful($weapon, $amp) {
    $weapon_type = $weapon->getType();

    if (!array_key_exists($weapon_type, $amp)) {
        return false;
    }
    
    if ($amp[$weapon_type] == null) {
        return false;
    }      
      
    if ($amp[$weapon_type]->getDamage() > $weapon->getDamage() * 0.5) {
        return true;
    }
    
    return false;
}

function getFilterEnhancers($enhancer_list) {
  $filter_enhancers = array();

  if ($enhancer_list != null) {
    foreach ($enhancer_list as $enhancer) {
      if ($enhancer == 0) {
        //continue;
      }
  
      array_push($filter_enhancers, $enhancer);
    }
  }

  if (count($filter_enhancers) == 0) {
    $filter_enhancers = null;
  }

  return $filter_enhancers;
}

?>

