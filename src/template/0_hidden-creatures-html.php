 <div class="dh">
   <div class="tc">
     <h2><?=$lang[$LOCALE][$LANG_DETAILS]['other-creatures']?></h2>
   </div>
   <div class="pl">
     <?=$lang[$LOCALE][$LANG_DETAILS]['creature-header-1']?>
   </div>
 </div>
 <?php
   if ($filter_creatures != null && count($filter_creatures) > 0) {
 ?>
     <div class="table-creator-creatures" style="display: none;">
       <div class="creator-table">[{c:"other-creatures-table"}]</div>
       <div class="creator-header">
         [{c:"header wn",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['other-creature-name-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['creature-name']?>"},
         {c:"header och-rank",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['other-creature-rank-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['creature-rank']?>"},
         {c:"header och-cost",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['other-creature-cost-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['creature-cost']?>"},
         {c:"header och-regen",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['other-creature-regen-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['creature-regen']?>"},
         {c:"header och-overkill",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['other-creature-overkill-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['creature-overkill']?>"},
         {c:"header och-dmg",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['other-creature-damage-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['creature-damage']?>"},
         {c:"header och-hp",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['other-creature-hitpoints-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['creature-hitpoints']?>"},
         {c:"header och-threat",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['other-creature-threat-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['creature-threat']?>"}]
       </div>
       <div class="creator-body">
         <?php 
             $output = "";

             foreach($filter_creatures as $other_creature) {
                $v000 = "href='#' onclick=\\\"cc({$other_creature['id']})\\\"";
                $v01 = str_replace(" ", "&nbsp;", $other_creature['name']);
                $v10 = n($other_creature['rank'], 4);
                $v20 = n($other_creature['cost'], 4);
                $v30 = n($other_creature['regenp'], 3) . '%';
                $v40 = n($other_creature['overkillp'], 3) . '%';
                $v50 = $other_creature['damage'] == 0 ? "--" : $other_creature['damage'];
                $v60 = $other_creature['hp'];
                $v70 = n($other_creature['color'], 2) * 100;
                $c7 = "bgp-" . n($other_creature['color'], 2);

                $output .= "{c0:\"wn\",c1:\"oc-rank\",c2:\"oc-cost\",c3:\"oc-reg\","; 
                $output .= "c4:\"oc-over\",c5:\"oc-dmg\",c6:\"oc-hp\",c7:\"$c7\",";
                $output .= "v000:\"$v000\",v01:\"$v01\",v10:\"$v10\",v20:\"$v20\",";
                $output .= "v30:\"$v30\",v40:\"$v40\",v50:\"$v50\",v60:\"$v60\",v70:\"$v70\"},";
         	} ?>
         [<?=$output?>]
       </div>
     </div>
     <div class="table-target-creatures"></div>
 <?php } else { ?>
     <div class="hidden-details-not-found">
         <h4>No suitable or better mob found.</h4>
     </div>
 <?php } ?>