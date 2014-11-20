 <div class="dh">
   <div class="tc">
     <h2><?=$lang[$LOCALE][$LANG_DETAILS]['finisher-header']?></h2>
   </div>
   <div class="pl">
     <?=$lang[$LOCALE][$LANG_DETAILS]['finisher-header-1']?>
     <span style="color: red; font-weight: bold;"><?=" " . n($min_cost, 4)?></span> PEC 
     <?=$lang[$LOCALE][$LANG_DETAILS]['finisher-header-2']?>
     <span style="color: red; font-weight: bold;"><?=" " . $lost_damage_in_overkill?></span> HP.<br /><br />
     <?=$lang[$LOCALE][$LANG_DETAILS]['finisher-header-3']?>
   </div>
 </div>

 <?php
   if ($filter_finishers != null && count($filter_finishers) > 0) {
 ?>
     <div class="table-creator-finishers" style="display: none;">
       <div class="creator-table">[{c:"finisher-table"}]</div>
       <div class="creator-header">
         [{c:"header wn",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['finisher-name-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['finisher-name']?>"},
         {c:"header ofh-cost",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['finisher-cost-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['finisher-cost']?>"},
         {c:"header ofh-cost",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['finisher-raw-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['finisher-raw']?>"},
         {c:"header ofh-diff",t:"<?=$lang[$LOCALE][$LANG_DETAILS]['finisher-diff-tooltip']?>",v:"<?=$lang[$LOCALE][$LANG_DETAILS]['finisher-diff']?>"}]
       </div>
       <div class="creator-body">
         <?php 
           $output = "";

           foreach($filter_finishers as $filter_finisher) {
             $finisher_id = $filter_finisher['id'];
             $diff = n(-floatval((1 - $filter_finisher['cost'] / $cost) * 100));
             $v000 = "href='$url&weapon-id=$finisher_id'";
             $v001 = "target='_blank'";
             $v01 = str_replace(" ", "&nbsp;", $filter_finisher['name']);
             $v10 = n($filter_finisher['cost'], 4);
             $v20 = n($filter_finisher['raw_cost'], 4);
             $v30 = $diff > 0 ? " style='color: #F00;'" : "";

             $output .= "{c0:\"wn\",c1:\"of-cost\",c2:\"of-raw\",c3:\"of-diff\",v000:\"$v000\",v001:\"$v001\",v01:\"$v01\",v10:\"$v10\",v20:\"$v20\",v30:\"$v30\",v31:\"$diff%\"},";
           } 
         ?>
         [<?=$output?>]
       </div>
     </div>
     <div class="table-target-finishers"></div>
 <?php } else { ?>
     <div class="hidden-details-not-found">
         <h4>No suitable finishers exists.</h4>
     </div>
 <?php } ?>