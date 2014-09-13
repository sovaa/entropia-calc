   <div class="cost-chart-header">
       <h2><?=$lang[$LOCALE][$LANG_DETAILS]['cost-chart-header']?></h2>
   </div>
   <table class="cost-chart nd">
     <tr>
       <td class="cost-name" style="width: 100px;"><?=$lang[$LOCALE][$LANG_DETAILS]['cost-ammo']?></td>
       <td><div class="cost-ammo" style="width: <?=n($_ammo_cost / $calc_cost * 100)?>%;">&nbsp;</div></td>
       <td style="width: 10px;"><?=n($_ammo_cost / $calc_cost * 100)?>%</td>
     </tr>
     <tr>
       <td class="cost-name"><?=$lang[$LOCALE][$LANG_DETAILS]['cost-amp']?></td>
       <td>
         <?php if ($amp_decay > 0) { ?>
         <div class="cost-amp" style="width: <?=n($amp_decay / $calc_cost * 100)?>%;">&nbsp;</div>
         <?php }?>
       </td>
       <td><?=n($amp_decay / $calc_cost * 100)?>%</td>
     </tr>
     <tr>
       <td class="cost-name"><?=$lang[$LOCALE][$LANG_DETAILS]['cost-weapon']?></td>
       <td><div class="cost-weapon" style="width: <?=n($weapon_decay / $calc_cost * 100)?>%;">&nbsp;</div></td>
       <td><?=n($weapon_decay / $calc_cost * 100)?>%</td>
     </tr>
     <tr>
       <td class="cost-name"><?=$lang[$LOCALE][$LANG_DETAILS]['cost-overkill']?></td>
       <td><div class="cost-overkill" style="width: <?=n($overkill_cost / $calc_cost * 100)?>%;">&nbsp;</div></td>
       <td><?=n($overkill_cost / $calc_cost * 100)?>%</td>
     </tr>
     <?php
       if ($use_enhancer_decay) {
     ?>
     <tr>
       <td class="cost-name"><?=$lang[$LOCALE][$LANG_DETAILS]['cost-enhancers']?></td>
       <td><div class="cost-enhancer" style="width: <?=n($enhancer_cost / $calc_cost * 100)?>%;">&nbsp;</div></td>
       <td><?=n($enhancer_cost / $calc_cost * 100)?>%</td>
     </tr>
     <?php
       }
     ?>
   </table>
   <div style="padding-left: 25px;">
     <br />
     <div class="health-meter">
       <div style="width: <?=$overkill_percentage?>%;" class="tip overkill float" 
          title="<?=$lang[$LOCALE][$LANG_DETAILS]['overkill']?>: <?=n($overkill_percentage)?>%">&nbsp;</div>
  
                   <div style="width: <?=$regen_percentage?>%;" class="tip regen float" 
          title="<?=$lang[$LOCALE][$LANG_DETAILS]['regen']?>: <?=n($regen_percentage)?>%">&nbsp;</div>
  
                   <div style="width: <?=$health_percentage?>%;" class="tip health float" 
          title="<?=$lang[$LOCALE][$LANG_DETAILS]['original-health']?>: <?=n($health_percentage)?>%">&nbsp;</div>
     </div>
     <div>
       <div class="box overkill">&nbsp;</div> Overkill <div class="box regen">&nbsp;</div> Regen <div class="box health">&nbsp;</div> Original health
     </div>
   </div>
