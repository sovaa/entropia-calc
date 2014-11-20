 <div class="dh">
   <div class="tc">
     <h2><?=$lang[$LOCALE][$LANG_DETAILS]['other-amps']?></h2>
   </div>
   <div class="pl">
     <?=$lang[$LOCALE][$LANG_DETAILS]['amplifier-header-1']?>
   </div>
 </div>
 <?php
   if ($filter_amps != null && count($filter_amps) > 0) {
 ?>
     <div class="table-creator-amplifiers" style="display: none;">
       <div class="creator-table">[{c:"other-amps-table"}]</div>
       <div class="creator-header">
         [{c:"header wn",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['other-amp-name-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['amp-name']?>"},
         {c:"header oah-cost",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['other-amp-cost-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['amp-cost']?>"},
         {c:"header oah-diff",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['other-amp-diff-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['amp-diff']?>"}]
       </div>
       <div class="creator-body">
         <?php 
             $output = "";

             foreach($filter_amps as $other_amp) {
                $v000 = "href='#'";
                $v001 = "onclick=\\\"ca(" . $other_amp['id'] . ",'" . $other_amp['type'] . "')\\\"";
                $v01 = str_replace(" ", "&nbsp;", $other_amp['name']);
                $v10 = n($other_amp['cost'], 4);
                $v20 = "-" . n(floatval((1 - $other_amp['cost'] / $cost) * 100));

                $output .= "{c0:\"wn\",c1:\"oa-cost\",c2:\"oa-diff\",v000:\"$v000\",v001:\"$v001\",v01:\"$v01\",v10:\"$v10\",v20:\"$v20%\"},";
         } ?>
         [<?=$output?>]
       </div>
     </div>
     <div class="table-target-amplifiers"></div>
 <?php } else { ?>
     <div class="hidden-details-not-found">
         <h4>No suitable or better amplifier exists.</h4>
     </div>
 <?php } ?>