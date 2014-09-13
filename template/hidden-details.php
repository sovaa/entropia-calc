<?php

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

function getFilterCreatures($other_mobs) {
    $filter_creatures = array();
    //$__min_threat = 0;
    $__max_threat = 0;

    foreach($other_mobs as $_creature) {
        if (count($filter_creatures) >= MAX_OTHER_CREATURES) {
            break;
        }

        if ($_creature['threat'] > $__max_threat) {
            $__max_threat = $_creature['threat'];
        }

        array_push($filter_creatures, $_creature);
    }

    $__tmp_creatures = $filter_creatures;
    $filter_creatures = array();

    $__max_threat = log($__max_threat);

    foreach($__tmp_creatures as $_creature) {
        $threat = 0;

        if ($_creature['threat'] != 0) {
            $threat = log($_creature['threat']);
        }

        $_creature['color'] = $threat / $__max_threat;
        array_push($filter_creatures, $_creature);
    }

    return $filter_creatures;
}

function getUrl() {
  $url = 'http';

  if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") {
    $url .= "s";
  }

  $url .= "://";

  if ($_SERVER["SERVER_PORT"] != "80") {
    $url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
  }
  else {
    $url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
  }

  return dirname($url) . '/';
}

?>

<table id="hidden-details" style="display: none;">
 <?php
     foreach ($results as $result) {
         $details = $result['details'];
         $lost_damage_in_overkill = n($details['lost_damage_in_overkill']);
         $ped_per_hp = n($details['ped_per_hp'] * 100);
         $health_effective = n($details['health_effective']);

         $enhancer_cost = n($details['enhancer_cost']);
         $enhancer_cost_from_markup = n($details['enhancer_cost_from_markup']);
         
         $overkill_cost = n($details['overkill_cost'] * 100);
         $ammo_cost = n($details['ammo_cost']);
         $_ammo_cost = n($details['ammo_cost'] * 100);
         $amp_decay = n($details['amp_decay']);
         $weapon_decay = n($details['weapon_decay']);
         $weapon_decay_from_markup = n($details['weapon_decay_from_markup']);
         $amp_decay_from_markup = n($details['amp_decay_from_markup']);
         $regen_cost = $details['regen_cost'];

         $critical_hit_damage = $details['critical_hit_damage'];
         $critical_hit_damage_bonus = $details['critical_hit_damage_bonus'];
         $critical_hit_rate = $details['critical_hit_rate'];
         $critical_hit_rate_bonus = $details['critical_hit_rate_bonus'];
         $critical_enhancer_bonus = $details['critical_hit_enhancer_bonus'];
         $damage_from = $details['damage_from'];
         $damage_to = $details['damage_to'];
         $max_dmg = $details['max_damage'];
         $effective_damage = $details['effective_damage'];

         if (!isset($hit_profession) || $hit_profession == null) {
             $hit_profession = 100.0;
         }

         $overkill_percentage = 0;
         if ($health_effective != null && $health_effective > 0) {
            $overkill_percentage = n($lost_damage_in_overkill / $health_effective * 100);
         }

         $cost = array_key_exists('cost', $result) ? $result['cost'] : null;

         $min_cost = $result['cost_per_sec'] * $result['weapon_attacks'] / 60.0;

         $other_amps = $details['amps'];
         $finishers = $details['finishers'];
         $other_mobs = $details['creatures'];

         $weapon_id = array_key_exists('weapon-id', $details) ? $details['weapon-id'] : null;
         $creature_id = $details['creature-id'];
         $creature_regen = $details['creature-regen'];

         $amp_laser_fin_id = array_key_exists('amp-laser-fin-id', $details) ? $details['amp-laser-fin-id'] : null;
         $amp_blp_fin_id = array_key_exists('amp-blp-fin-id', $details) ? $details['amp-blp-fin-id'] : null;

         $url = getUrl() . "?creature-hp=$lost_damage_in_overkill&creature-regen=$creature_regen&creature=$creature_id";

         if (isset($amp_laser_fin_id) && is_numeric($amp_laser_fin_id)) {
           $url .= "&amp;amp_energy=$amp_laser_fin_id";
         }

         if (isset($amp_blp_fin_id) && is_numeric($amp_blp_fin_id)) {
           $url .= "&amp;amp_blp=$amp_blp_fin_id";
         }

         aasort($other_amps, 'cost');
         aasort($finishers, 'cost');
         aasort($other_mobs, 'rank');

         $filter_amps = array();
         foreach($other_amps as $other_amp) {
           if ($other_amp['cost'] > $cost) {
             continue;
           }

           array_push($filter_amps, $other_amp);
         }

         $filter_finishers = array();
         foreach($finishers as $finisher) {
           if (count($filter_finishers) >= MAX_FINISHERS) {
             break;
           }

           $mod_cost = ($cost - ($min_cost / 100));
           $finisher['raw_cost'] = $finisher['cost'];
           $finisher['cost'] = $mod_cost + $finisher['cost'];

           if ($finisher['cost'] > $cost) {
             //continue;
           }

           array_push($filter_finishers, $finisher);
         }

         $filter_creatures = getFilterCreatures($other_mobs);

         $regen_percentage = 0;
         if ($cost != null && $cost > 0) {
            $regen_percentage = ($regen_cost / $cost) * 100;
         }

         $health_percentage = 100 - $regen_percentage - $overkill_percentage;

         include(PATH . "/template/hidden-details-html.php");
     }
 ?>
</table>

