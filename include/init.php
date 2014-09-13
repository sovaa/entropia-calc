<?php

function percent($str) {
  if ($str === null) {
    return 0;
  }

  $nr = Utils::parseNumber($str, $default = -99, $min = -100);
  if ($nr > 99) {
    $nr = 99;
  }

  return $nr;
}

function checkboxToBoolean($box) {
  if ($box === "on") {
    return true;
  }
  return false;
}

$data = $_GET;

$manager = new Manager();
$creatures = $manager->getCreatures();
$weapons = $manager->getWeapons();
$amps_energy = $manager->getEnergyAmps();
$amps_blp = $manager->getBlpAmps();
$types = $manager->getTypes();
$classes = $manager->getClasses();
$scopes = $manager->getScopes();
$sights = $manager->getSights();

if (USE_HEALING === true) {
  $heals = $manager->getMedicalTools();
  $enhancer_heal_list = @$data['heal-enhancers'];
  $all_heal_enhancers = @$data['all-heal-enhancers'];

  $selected_heal_id = @$data['heal-id'];
  $use_healing = @$data['use-healing'];

  $hide_heal_enhancers = @$data['hide-heal-enhancers'];
  
  if ($hide_heal_enhancers == null || $hide_heal_enhancers == "") {
    $hide_heal_enhancers = 1;
  }

  $enhancer_heal_names = array(
    0 => "enhancer-heal-none",
    1 => "enhancer-heal-economy",
    2 => "enhancer-heal-heal",
    3 => "enhancer-heal-skill"
  );
}

$filters = 1;
$enhancers = 10;

$filter_name_list = @$data['filter-column-name'];
$filter_match_list = @$data['filter-column-match'];
$filter_value_list = @$data['filter-column-value'];
$filters_post = @$data['filters'];

if ($filter_name_list == null) {
  $filter_name_list = array();
}
if ($filter_match_list == null) {
  $filter_match_list = array();
}
if ($filter_value_list == null) {
  $filter_value_list = array();
}

$enhancer_markups   = @$data['enhancer-markup'];
$enhancer_decays    = @$data['enhancer-decay'];
$enhancer_types     = @$data['enhancer-type'];

$enhancer_list_fin  = array(); // TODO: implement this
$enhancer_list      = @$data['enhancers'];
$all_enhancers      = @$data['all-enhancers'];
$creature_input_hp  = @$data['creature-hp'];
$creature_input_reg = @$data['creature-regen'];
$skip_list          = @$data['skip-list'];

$selected_type      = @$data['type'];
$selected_class     = @$data['class'];
$selected_creature  = @$data['creature'];

$selected_type_fin  = @$data['type-fin'];
$selected_class_fin = @$data['class-fin'];

$hide_enhancers     = @$data['hide-enhancers'];
$amp_markup         = @$data['amp-markup'];
$use_weapon_markup  = @$data['use-weapon-markup'];
$maximize           = @$data['maximize'];
$damage_profession  = @$data['damage-profession'];
$hit_profession     = @$data['hit-profession'];
$team_size          = @$data['team-size'];

$use_enhancer_decay = @$data['use-enhancer-decay'];
$find_finishers     = @$data['find-finishers'];
$find_creatures     = @$data['find-creatures'];
$find_amplifiers    = @$data['find-amplifiers'];
$find_buffs         = @$data['find-buffs'];
$skip_limited       = @$data['skip-limited'];
$ignore_regen       = @$data['ignore-regen'];
$skip_unknown_skill = @$data['skip-unknown-skill'];
$bond_theory        = @$data['toggle-bond-theory'];
$bond_dpp           = @$data['bond-dpp'];
$bond_loot          = @$data['bond-loot'];
$bond_multi         = @$data['bond-multi'];
$finisher_amp_blp   = @$data['finisher-amp-blp'];
$finisher_amp_energy = @$data['finisher-amp-energy'];
$buff_floor_values  = @$data['buff-floor-values'];

$selected_sight1_id = @$data['sight1'];
$selected_sight2_id = @$data['sight2'];
$selected_scope_id  = @$data['scope'];

if ($find_buffs) {
    $buff_reload_speed  = percent(@$data['buff-reload-speed']);
    $buff_damage        = percent(@$data['buff-damage']);
    $buff_skill_req     = percent(@$data['buff-skill-req']);
    $buff_ammo_burn     = percent(@$data['buff-ammo-burn']);
    $buff_crit_chance   = percent(@$data['buff-crit-chance']);
    $buff_crit_damage   = percent(@$data['buff-crit-damage']);
}
else {
    $buff_reload_speed  = 0;
    $buff_damage        = 0;
    $buff_skill_req     = 0;
    $buff_ammo_burn     = 0;
    $buff_crit_chance   = 0;
    $buff_crit_damage   = 0;
}

$use_enhancer_decay = checkboxToBoolean($use_enhancer_decay);
$find_finishers     = checkboxToBoolean($find_finishers);
$find_creatures     = checkboxToBoolean($find_creatures);
$find_amplifiers    = checkboxToBoolean($find_amplifiers);
$find_buffs         = checkboxToBoolean($find_buffs);
$skip_limited       = checkboxToBoolean($skip_limited);
$use_weapon_markup  = checkboxToBoolean($use_weapon_markup);
$maximize           = checkboxToBoolean($maximize);
$ignore_regen       = checkboxToBoolean($ignore_regen);
$skip_unknown_skill = checkboxToBoolean($skip_unknown_skill);
$bond_theory        = checkboxToBoolean($bond_theory);
$buff_floor_values  = checkboxToBoolean($buff_floor_values);

if ($bond_theory) {
  $bond_multi = Utils::parseNumber($bond_multi, 3.5);
  $bond_dpp = Utils::parseNumber($bond_dpp, 3);
  $bond_loot = Utils::parseNumber($bond_loot, 10);
}

$all_enhancer_decays = array();
$all_enhancer_markups = array();

if (true) {
  $db_enhancers = $manager->getWeaponEnhancers();

  foreach ($db_enhancers as $dben) {
    $all_enhancer_decays[$dben['name']] = 1000;
    $all_enhancer_markups[$dben['name']] = floatval(trim(str_replace('PED', '', $dben['markup']))) / floatval(trim($dben['tt'])) * 100;
  }

  if (!isset($enhancer_types) || $enhancer_types == null || count($enhancer_types) == 0) {
    $enhancer_types = array();

    for ($i = 0; $i < 10; $i++) {
      $enhancer_types[$i] = 'NONE';
    }
  }

  if (!isset($enhancer_markups) || $enhancer_markups == null || count($enhancer_markups) == 0) {
    $enhancer_markups = array();

    for ($i = 0; $i < 10; $i++) {
      $enhancer_markups[$i] = 0;
    }

    /*
    for ($i = 0; $i < 10; $i++) {
      $etype = $enhancer_types[$i];

      if (stripos($etype, 'NONE') !== false) {
        $enhancer_markups[$i] = 0;
      }
      else {
        foreach ($db_enhancers as $dben) {
          if (stripos($dben['name'], $etype) !== false && $dben['slot'] == $i) {
            $enhancer_markups[$i] = trim(str_replace('PED', '', $dben['markup']));
          }
        }
      }
    }
    */
  }
  
  if (!isset($enhancer_decays) || $enhancer_decays == null || count($enhancer_decays) == 0) {
    $enhancer_decays = array();

    for ($i = 0; $i < 10; $i++) {
      $enhancer_decays[$i] = 0;
    }
  }
}

// only allow one of these at the same time, takes too much memory to execute otherwise
if ($find_finishers == true && $find_creatures == true) {
  $find_creatures = false;
}

// not need for markup if limited are skipped
if ($skip_limited == true && $use_weapon_markup == true) {
  $use_weapon_markup = false;
}

if ($skip_unknown_skill == true && strlen($damage_profession) == 0 && strlen($hit_profession) == 0) {
  $skip_unknown_skill = false;
}

if ($hide_enhancers == null || $hide_enhancers == "") {
  $hide_enhancers = 1;
}

if ($filters_post != null && floatval($filters_post) > 0) {
  $filters = $filters_post;
}
