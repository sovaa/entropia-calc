<div id="search-weapon-wrapper" class="search-sub-wrapper">
  <div class="search-wrapper-header">
    <?=$lang[$LOCALE][$LANG_SEARCH]['search-weapon-header']?>
  </div>

  <select class="setting" name="amp_energy">
    <?php
      echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-energy-amp']}</option>");
      foreach ($amps_energy as $amp) {
        if ($seaid == $amp['id']) {
          echo("<option selected='selected' value='{$amp['id']}'>{$amp['name']}</option>");
        }
        else {
          echo("<option value='{$amp['id']}'>{$amp['name']}</option>");
        }
      }
    ?>
  </select><br />

  <select class="setting" name="amp_blp">
    <?php
      echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-blp-amp']}</option>");
      foreach ($amps_blp as $amp) {
        if ($sbaid == $amp['id']) {
          echo("<option selected='selected' value='{$amp['id']}'>{$amp['name']}</option>");
        }
        else {
          echo("<option value='{$amp['id']}'>{$amp['name']}</option>");
        }
      }
    ?>
  </select><br />

  <select class="setting" name="scope">
    <?php
      echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-scope']}</option>");
      foreach ($scopes as $scope) {
        if ($selected_scope_id == $scope['id']) {
          echo("<option selected='selected' value='{$scope['id']}'>{$scope['name']}</option>");
        }
        else {
          echo("<option value='{$scope['id']}'>{$scope['name']}</option>");
        }
      }
    ?>
  </select><br />

  <select class="setting" name="sight1">
    <?php
      echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-sight-1']}</option>");
      foreach ($sights as $sight) {
        if ($selected_sight1_id == $sight['id']) {
          echo("<option selected='selected' value='{$sight['id']}'>{$sight['name']}</option>");
        }
        else {
          echo("<option value='{$sight['id']}'>{$sight['name']}</option>");
        }
      }
    ?>
  </select><br />

  <?php
  // only one sight gives these bonuses
  /* <select class="setting" name="sight2">
    <?php
      echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-sight-2']}</option>");
      foreach ($sights as $sight) {
        if ($selected_sight2_id == $sight['id']) {
          echo("<option selected='selected' value='{$sight['id']}'>{$sight['name']}</option>");
        }
        else {
          echo("<option value='{$sight['id']}'>{$sight['name']}</option>");
        }
      }
    ?>
  </select><br /> */ ?>

  <select class="setting" name="type">
    <?php
      echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-type']}</option>");
      foreach ($types as $type) {
        if ($selected_type == $type) {
          echo("<option selected='selected' value='$type'>$type</option>");
        }
        else {
          echo("<option value='$type'>$type</option>");
        }
      }
    ?>
  </select><br />

  <select class="setting" name="class">
    <?php
      echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-class']}</option>");
      foreach ($classes as $class) {
        if ($selected_class == $class) {
          echo("<option selected='selected' value='$class'>$class</option>");
        }
        else {
          echo("<option value='$class'>$class</option>");
        }
      }
    ?>
  </select>

  <div id="toggle-enhancers"><?=$lang[$LOCALE][$LANG_SEARCH]['toggle-enhancers']?></div>
  <div id="select-enhancers" class="enhancers-selector" style="display: none;">
    <input type="hidden" name="hide-enhancers" id="hide-enhancers" value="<?=$hide_enhancers?>" />
    <div class="change-all-enhancers">
      <?=$lang[$LOCALE][$LANG_SEARCH]['change-all-enhancers']?><br />
      <select class="all-enhancers" name="all-enhancers">
        <?php
          foreach ($enhancer_names as $key => $value) {
            if ($all_enhancers == $key) {
              echo("<option selected='selected' value='$key'>{$lang[$LOCALE][$LANG_SEARCH][$value]}</option>");
            }
            else {
              echo("<option value='$key'>{$lang[$LOCALE][$LANG_SEARCH][$value]}</option>");
            }
          }
        ?>
      </select><br />
    </div>
    <?php

      for ($i = 0; $i < $enhancers; $i++) {
        foreach ($enhancer_names as $key => $value) {
          $name = "{$lang[$LOCALE][$LANG_SEARCH][$value]} {$to_roman[$i + 1]}";
            
          if (stripos($name, 'Select') !== false) {
            continue;
          }

          echo("<span style='display: none;' id='enhancer-stats-$name'>{$all_enhancer_markups[$name]};{$all_enhancer_decays[$name]}</span>");
        }
      }

    ?>
    <table style='border-collapse: collapse;' class="enhancer-settings-table">
      <thead>
      <tr>
        <th class="header">&nbsp;</th>
        <th class="header" style="width: 100px;"><span class="enhancer-setting-wrapper">Markup (%)</span></th>
        <th class="header" style="width: 100px;"><span class="enhancer-setting-wrapper">Decay rate</span></th>
      </tr>
      </thead>
      <tbody>
    <?php
      for ($i = 0; $i < $enhancers; $i++) {
    ?>

    <tr><td>
    <select class="enhancers" name="enhancers[]">
      <?php
        foreach ($enhancer_names as $key => $value) {
          if ($key === 0) {
            echo("<option value='$key'>{$lang[$LOCALE][$LANG_SEARCH][$value]} $i</option>");
            }
          else if ($enhancer_list[$i] == $key) {
            echo("<option selected='selected' value='$key'>{$lang[$LOCALE][$LANG_SEARCH][$value]} {$to_roman[$i + 1]}</option>");
          }
          else {
            echo("<option value='$key'>{$lang[$LOCALE][$LANG_SEARCH][$value]} {$to_roman[$i + 1]}</option>");
          }

        }
      ?>
    </select>
    </td>
    <?php
        $enhancer_found = false;
        foreach ($enhancer_names as $key => $value) {
          if ($key === 0 || $enhancer_list[$i] == $key) {
            $enhancer_found = true;

            echo("<td class='enhancer-settings-column'><span class='enhancer-setting-wrapper'><input class='enhancer-setting' " .
                "id='enhancer-markup-$i' type='text' value='{$enhancer_markups[$i]}' name='enhancer-markup[]' /></span></td>");

            echo("<td class='enhancer-settings-column'><span class='enhancer-setting-wrapper'><input class='enhancer-setting' " .
                "id='enhancer-decay-$i' type='text' value='{$enhancer_decays[$i]}' name='enhancer-decay[]' /></span>");

            echo("<input type='hidden' id='enhancer-type-$i' value='{$enhancer_types[$i]}' name='enhancer-type[]' /></td>");
            break;
          }
        }

        if (!$enhancer_found) {
          echo("<td class='enhancer-settings-column'><input type='text' id='enhancer-markup-$i' disabled='disabled' name='enhancer-markup[]' /></td>");
          echo("<td class='enhancer-settings-column'><input type='text' id='enhancer-decay-$i' disabled='disabled' name='enhancer-decay[]' />");
          echo("<input type='hidden' id='enhancer-type-$i' name='enhancer-type[]' /></td>");
        }
    ?>
        </tr>

    <?php
      }
    ?>
      </tbody>
    </table>
  </div> <!-- select-enhancers -->
</div>
