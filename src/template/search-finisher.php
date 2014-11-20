<div id="search-finisher-wrapper" class="search-sub-wrapper">
    <div class="search-wrapper-header">
      <?=$lang[$LOCALE][$LANG_SEARCH]['search-finisher-header']?>
    </div>

    <select class="setting" name="finisher-amp-energy">
      <?php
          echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-energy-amp']}</option>");
          foreach ($amps_energy as $amp) {
            if ($finisher_amp_energy == $amp['id']) {
              echo("<option selected='selected' value='{$amp['id']}'>{$amp['name']}</option>");
            }
            else {
              echo("<option value='{$amp['id']}'>{$amp['name']}</option>");
            }
          }
      ?>
    </select><br />
    <select class="setting" name="finisher-amp-blp">
      <?php
          echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-blp-amp']}</option>");
          foreach ($amps_blp as $amp) {
            if ($finisher_amp_blp == $amp['id']) {
              echo("<option selected='selected' value='{$amp['id']}'>{$amp['name']}</option>");
            }
            else {
              echo("<option value='{$amp['id']}'>{$amp['name']}</option>");
            }
          }
      ?>
    </select><br />

    <select class="setting" name="type-fin">
      <?php
          echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-type']}</option>");
          foreach ($types as $type) {
            if ($selected_type_fin == $type) {
              echo("<option selected='selected' value='$type'>$type</option>");
            }
            else {
              echo("<option value='$type'>$type</option>");
            }
          }
      ?>
    </select><br />
    <select class="setting" name="class-fin">
      <?php
          echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-class']}</option>");
          foreach ($classes as $class) {
            if ($selected_class_fin == $class) {
              echo("<option selected='selected' value='$class'>$class</option>");
            }
            else {
              echo("<option value='$class'>$class</option>");
            }
          }
      ?>
    </select>

    <?php 
    /*
    <div id="toggle-enhancers"><?=$lang[$LOCALE][$LANG_SEARCH]['toggle-enhancers']?></div>
    <div id="select-enhancers" style="display: none;">
      <input type="hidden" name="hide-enhancers" id="hide-enhancers" value="<?=$hide_enhancers?>" />
      <div id="change-all-enhancers">
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
      ?>
      <select class="enhancers" name="enhancers[]">
        <?php
            foreach ($enhancer_names as $key => $value) {
              if ($key === 0) {
                echo("<option selected='selected' value='$key'>{$lang[$LOCALE][$LANG_SEARCH][$value]} $i</option>");
              }
              else if ($enhancer_list[$i] == $key) {
                echo("<option selected='selected' value='$key'>{$lang[$LOCALE][$LANG_SEARCH][$value]} {$to_roman[$i + 1]}</option>");
              }
              else {
                echo("<option value='$key'>{$lang[$LOCALE][$LANG_SEARCH][$value]} {$to_roman[$i + 1]}</option>");
              }
            }
        ?>
      </select><br />
      <?php
        }
      ?>
    </div> <!-- select-enhancers -->
    */ ?>
</div>
