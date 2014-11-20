      <div id="legend">
        <div>
          <span id="marked-row">&nbsp;&nbsp;&nbsp;&nbsp;</span>
          &nbsp;Marked row.
        </div>
        <div>
          <span id="no-skill-based">&nbsp;&nbsp;&nbsp;&nbsp;</span>
          &nbsp;Cannot calculate skill based statistics (missing info on recommended/maxed profession level).
        </div>
      </div>

      <div id="result-wrapper-div">
        <table id="result" class="tablesorter">
          <thead class="column-header">
            <tr>
              <th title="Skip">Skip</th>
              <?php
                foreach ($results[0] as $key => $value) {
                  if ($key == 'id' || $key == 'details' || $key == 'can_calc_skill') {
                    continue;
                  }

                  echo("<th class='$key' title='{$lang[$LOCALE][$LANG_INFO][$key]}'>{$lang[$LOCALE][$LANG_HEADER][$key]}</th>");
                }
              ?>
            </tr>
          </thead>
          <tbody>
             <?php
               foreach ($results as $result) {
                 if ($result == null || count($result) == 0 || !array_key_exists('id', $result)) {
                   continue;
                 }
             ?>
                 <tr id="row-<?=$result['id']?>" class="rr <?=($result['can_calc_skill'] == false ? ' not-skill-based' : '')?>">
                   <td style="text-align: center;"><span class="skip-row" onclick="skip('<?=$result['id']?>', '<?=$result['weapon_name']?>')">[x]</span></td>

                   <?php
                     foreach ($result as $key => $value) {
                       if ($key == 'id' || $key == 'details' || $key == 'can_calc_skill') {
                         continue;
                       }

                       if ($key == 'weapon_name') {
                         $link = "http://www.entropedia.info/Info.aspx?chart=Weapon&amp;name=" . str_replace(' ', '_', $value);
                         $value = "<a href=\"$link\">$value</a>";
                       }
                       
                       if ($key == 'profit' || $key == 'profit_mod') {
                         echo("<td class='$key'>");
                         $profit_color = "red";

                         if (floatval($value) >= 0) {
                            $profit_color = "green";
                         }

                         echo("<span style='color: $profit_color;'>$value%</span></td>");
                       }
                       else if ($key == 'weapon_markup') {
                         echo("<td class='$key'>");
                         echo("<input type='text' name='markup-{$result['id']}' value='$value' /></td>");
                       }
                       else if ($key == 'cost') {
                         echo("<td id='id-{$result['id']}' class='$key " . ($value == '0' ? 'gray-text':'') ."'>$value</td>");
                       }
                       else {
                         echo("<td class='$key " . ($value == '0' ? 'gray-text':'') ."'>$value</td>");
                       }
                     }
                   ?>
                 </tr>
               <?php
                 }
               ?>
             </tbody>
          </table>
          <?php include(PATH . "/template/hidden-details.php"); ?>
        </div>

