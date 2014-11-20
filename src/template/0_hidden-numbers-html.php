<?php

$calc_cost = n($_ammo_cost) + $amp_decay + $weapon_decay + $overkill_cost;

if ($use_enhancer_decay) {
  $calc_cost += $enhancer_cost;
}

if ($calc_cost == 0) {
  $calc_cost = 1;
}

$currency = " PEC";
$mod = 1;

if (floatval($calc_cost) > 400) {
  $currency = " PED";
  $mod = 100;
}

?>

<div class="tc">
  <h2><?=$lang[$LOCALE][$LANG_DETAILS]['details-header']?></h2>
</div>
 
<br />
<table class="nd">
  <tr>
    <td style="width: 170px;">&nbsp;</td>
    <td style="width: 120px;"><b>Cost (incl. markup)</b></td>
    <td style="width: 80px;"><b>Markup cost</b></td>
    <td style="width: 70px;"><b>Markup %</b></td>
  </tr>
  <tr>
    <td>
      <b><?=$lang[$LOCALE][$LANG_DETAILS]['lost_damage_in_overkill']?></b>
    </td>
    <td class="tr">
      <?=$lost_damage_in_overkill?> HP
    </td>
    <td></td>
  </tr>

  <tr>
     <td>
       <b><?=$lang[$LOCALE][$LANG_DETAILS]['ped_per_hp']?></b>
     </td>
     <td class="tr">
       <?=$ped_per_hp?>
     </td>
     <td></td>
   </tr>

   <tr>
     <td>
       <b><?=$lang[$LOCALE][$LANG_DETAILS]['overkill_percentage']?></b>
     </td>
     <td class="tr">
       <?=$overkill_percentage?>%
     </td>
     <td></td>
   </tr>

   <tr>
    <td>
      <b><?=$lang[$LOCALE][$LANG_DETAILS]['overkill_cost']?></b>
    </td>
    <td class="tr">
      <span class="cost-value"><?=n($overkill_cost / $mod)?></span> <?=$currency?>
    </td>
    <td></td>
   </tr>

   <tr>
     <td>
       <b><?=$lang[$LOCALE][$LANG_DETAILS]['ammo_cost']?></b>
     </td>
     <td class="tr">
       <span class="cost-value"><?=n($_ammo_cost / $mod)?></span> <?=$currency?>
     </td>
     <td></td>
   </tr>

   <tr>
     <td>
       <b><?=$lang[$LOCALE][$LANG_DETAILS]['amp_decay']?></b>
     </td>
     <td class="tr">
       <span class="cost-value"><?=n($amp_decay / $mod)?></span> <?=$currency?> 
     </td>
     <td>
       <span class="cost-value"><?=n($amp_decay_from_markup / $mod)?></span> <?=$currency?>
     </td>
     <td>
       <span class="cost-value"><?=$amp_decay == 0 ? "0.0" : n($amp_decay_from_markup / $amp_decay * 100, 1)?></span>%
     </td>
   </tr>

   <tr>
     <td>
       <b><?=$lang[$LOCALE][$LANG_DETAILS]['weapon_decay']?></b>
     </td>
     <td class="tr">
       <span class="cost-value"><?=n($weapon_decay / $mod)?></span> <?=$currency?> 
     </td>
     <td>
       <span class="cost-value"><?=n($weapon_decay_from_markup / $mod)?></span> <?=$currency?>
     </td>
     <td>
       <span class="cost-value"><?=$weapon_decay == 0 ? "0.0" : n($weapon_decay_from_markup / $weapon_decay * 100, 1)?></span>%
     </td>
   </tr>

   <?php if ($use_enhancer_decay) { ?>
   <tr>
     <td>
       <b><?=$lang[$LOCALE][$LANG_DETAILS]['enhancer-cost']?></b>
     </td>
     <td class="tr">
       <span class="cost-value"><?=n($enhancer_cost / $mod)?></span> <?=$currency?>
     </td>
     <td>
       <span class="cost-value"><?=n($enhancer_cost_from_markup / $mod)?></span> <?=$currency?>
     </td>
     <td>
       <span class="cost-value"><?=$enhancer_cost == 0 ? "0.0" : n($enhancer_cost_from_markup / $enhancer_cost * 100, 1)?></span>%
     </td>
   </tr>
   <?php } ?>

   <tr>
     <td>
       <b><?=$lang[$LOCALE][$LANG_DETAILS]['regen-cost']?></b>
     </td>
     <td class="tr">
       <span class="cost-value"><?=n(($regen_cost * 100) / $mod)?></span> <?=$currency?>
     </td>
     <td></td>
   </tr>
 </table>
