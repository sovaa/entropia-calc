<table id="search_form">
  <tr>
    <td class="first">
        <select class="setting" name="creature" id="setting-creature">
          <?php
              $prev_name = null;
              echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-creature']}</option>");

              foreach ($creatures as $creature) {
                $name_parts = explode(" ", $creature['name']);
                $cur_name = $name_parts[0];

                if ($prev_name == null) {
                  $prev_name = $cur_name;
                }

                if ($prev_name != null && $cur_name != $prev_name) {
                  $prev_name = $cur_name;
                  echo("<optgroup disabled='disabled' style='height: 1px;' label=''><option style='height: 1px;'></option></optgroup>");
                }

                if ($selected_creature == $creature['id']) {
                  echo("<option selected='selected' title='{$creature['hp']}:{$creature['regen']}' value='{$creature['id']}'>{$creature['name']}</option>");
                }
                else {
                  echo("<option title='{$creature['hp']}:{$creature['regen']}' value='{$creature['id']}'>{$creature['name']}</option>");
                }
              }
          ?>
        </select><br />

        <table id="creature-input">
          <!-- CREATURE HP -->
          <tr>
            <td class="search-key-td">
              <?php
                $creature_hp = "";
                if (array_key_exists('creature', $data) && $data['creature'] != null) {
                  $creature = $manager->getCreature($data['creature']);
                  $creature_hp = $creature['hp'];

                  $creature_input_hp = $data['creature-hp'];

                  if ($creature_input_hp != null && is_numeric($creature_input_hp)) {
                    $temp = floatval($creature_input_hp);

                    if ($temp > 0) {
                      $creature_hp = $temp;
                    }
                  }
                }
              ?>
              <span class="search-key"><?=$lang[$LOCALE][$LANG_SEARCH]['select-creature-hp']?></span>
            </td>
            <td class="search-value-td">
              <input type="text" class="idleField setting" name="creature-hp" id="setting-creature-hp" value="<?=$creature_hp?>" />
            </td>
          </tr>


          <!-- CREATURE REGEN -->
          <tr>
            <td class="search-key-td">
              <?php
                $creature_regen = "";
                if (array_key_exists('creature', $data) && $data['creature'] != null) {
                  $creature = $manager->getCreature($data['creature']);
                  $creature_regen = $creature['regen'];

                  if ($creature_input_reg != null && is_numeric($creature_input_reg)) {
                    $temp = floatval($creature_input_reg);

                    if ($temp > 0) {
                      $creature_regen = $temp;
                    }
                  }
                }
              ?>
              <span class="search-key"><?=$lang[$LOCALE][$LANG_SEARCH]['select-creature-regen']?></span>
            </td>
            <td class="search-value-td">
              <input type="text" class="idleField setting" name="creature-regen" id="setting-creature-regen" value="<?=$creature_regen?>" />
            </td>
          </tr>


          <!-- WEAPON ID -->
          <tr>
            <td class="search-key-td">
              <?php
                $weapon_id = "";

                if (array_key_exists('weapon-id', $data) && $data['weapon-id'] != null) {
                  $id = $data['weapon-id'];

                  if (is_numeric($id)) {
                    $temp = floatval($id);

                    if ($temp > 0) {
                      $weapon_id = $temp;
                    }
                  }
                }
              ?>
              <span class="search-key"><?=$lang[$LOCALE][$LANG_SEARCH]['select-weapon-id']?></span>
            </td>
            <td class="search-value-td">
              <input type="text" class="idleField setting" name="weapon-id" id="setting-weapon-id" value="<?=$weapon_id?>" />
            </td>
          </tr>


          <!-- AMP MARKUP -->
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td class="search-key-td">
              <?=$lang[$LOCALE][$LANG_SEARCH]['include_amp_markup']?><br />
            </td>
            <td class="search-input search-value-td">
              <input class="idleField" name="amp-markup" type="text" value="<?=$amp_markup?>" />%
            </td>
          </tr>


          <!-- SKILL BASED -->
          <tr>
            <td class="search-key-td">
              <?=$lang[$LOCALE][$LANG_SEARCH]['skill_based']?><br />
            </td>
            <td class="search-input search-value-td">
              <input name="hit-profession" value="<?=$hit_profession?>" type="text" class="idleField" />
              <?=$lang[$LOCALE][$LANG_SEARCH]['hit_profession']?><br />

              <input name="damage-profession" value="<?=$damage_profession?>" type="text" class="idleField" />
              <?=$lang[$LOCALE][$LANG_SEARCH]['damage_profession']?>
            </td>
          </tr>


          <!-- TEAM SIZE -->
          <tr>
            <td class="search-key-td">
              <?=$lang[$LOCALE][$LANG_SEARCH]['team_size']?><br />
            </td>
            <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['team-size-tooltip']?>" class="tooltip search-input search-value-td">
              <input name="team-size" value="<?=$team_size?>" type="text" class="idleField" />
            </td>
          </tr>
        </table>
      </td>


      <!-- SETTINGS -->
      <td>
        <table id="settings-input">
          <!-- SHOW ALL COLUMNS -->
          <tr>
            <td>
              <label>
                <input <?php if ($maximize) echo('checked="checked"') ?> name="maximize" type="checkbox" />
                <?=$lang[$LOCALE][$LANG_SEARCH]['maximize']?>
              </label>
            </td>
          </tr>


          <!-- USE WEAPON MARKUP -->
          <tr>
            <td>
              <label>
                <input <?php if ($use_weapon_markup) echo('checked="checked"') ?> name="use-weapon-markup" type="checkbox" />
                <?=$lang[$LOCALE][$LANG_SEARCH]['include_weapon_markup']?>
              </label>
            </td>
          </tr>


          <!-- SKIP LIMITED -->
          <tr>
            <td>
              <label>
                <input <?php if ($skip_limited) echo('checked="checked"') ?> name="skip-limited" type="checkbox" />
                <?=$lang[$LOCALE][$LANG_SEARCH]['skip-limited']?>
              </label>
            </td>
          </tr>


          <!-- FIND AMPLIFIERS -->
          <tr>
            <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['find-amplifiers-tooltip']?>" class="tooltip">
              <label>
                <input class="unique" <?php if ($find_amplifiers) {echo('checked="checked"');} ?> name="find-amplifiers" type="checkbox" />
                <?=$lang[$LOCALE][$LANG_SEARCH]['find-amplifiers']?><br />
              </label>
            </td>
          </tr>


          <!-- FIND FINISHERS -->
          <tr>
            <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['find-finishers-tooltip']?>" class="tooltip">
              <label>
                <input class="unique" <?php if ($find_finishers) {echo('checked="checked"');} ?> name="find-finishers" type="checkbox" />
                <?=$lang[$LOCALE][$LANG_SEARCH]['find-finishers']?><br />
              </label>
            </td>
          </tr>


          <!-- FIND OTHER CREATURES -->
          <tr>
            <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['find-creatures-tooltip']?>" class="tooltip">
              <label>
                <input class="unique" <?php if ($find_creatures) {echo('checked="checked"');} ?> name="find-creatures" type="checkbox" />
                <?=$lang[$LOCALE][$LANG_SEARCH]['find-creatures']?><br />
              </label>
            </td>
          </tr>


          <!-- IGNORE REGEN -->
          <tr>
            <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['ignore-regen-tooltip']?>">
              <label>
                <input <?php if ($ignore_regen) echo('checked="checked"') ?> name="ignore-regen" type="checkbox" />
                <?=$lang[$LOCALE][$LANG_SEARCH]['ignore-regen']?>
              </label>
            </td>
          </tr>


          <!-- SKIP UNKNOWN SKILL -->
          <tr>
            <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['skip-unknown-skill-tooltip']?>" class="tooltip">
              <label>
                <input name="skip-unknown-skill"  <?php if ($skip_unknown_skill) {echo('checked="checked"');} ?> type="checkbox" class="idleField"/>
                <?=$lang[$LOCALE][$LANG_SEARCH]['skip-unknown-skill']?><br />
              </label>
            </td>
          </tr>


          <!-- USE ENHANCER DECAY -->
          <tr>
            <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['use-enhancer-decay-tooltip']?>" class="tooltip">
              <label>
                <input name="use-enhancer-decay"  <?php if ($use_enhancer_decay) {echo('checked="checked"');} ?> type="checkbox" class="idleField"/>
                <?=$lang[$LOCALE][$LANG_SEARCH]['use-enhancer-decay']?><br />
              </label>
            </td>
          </tr>


          <!-- BOND THEORY -->
          <tr>
            <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['toggle-bond-theory-tooltip']?>" class="tooltip">
              <label>
                <input name="toggle-bond-theory" <?php if ($bond_theory) {echo('checked="checked"');} ?> type="checkbox" class="idleField"/>
                <?=$lang[$LOCALE][$LANG_SEARCH]['toggle-bond-theory']?><br />
              </label>
            </td>
          </tr>


          <!-- WEAPON BUFFS -->
          <tr>
            <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['find-buffs-tooltip']?>" class="tooltip">
              <label>
                <input name="find-buffs" <?php if ($find_buffs) {echo('checked="checked"');} ?> type="checkbox" class="idleField" />
                <?=$lang[$LOCALE][$LANG_SEARCH]['find-buffs']?><br />
              </label>
            </td>
          </tr>
          

          <?php if (USE_HEALING === true) { ?>
          <!-- USE HEALING -->
          <tr>
            <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['use-healing-tooltip']?>" class="tooltip">
              <label>
                <input <?php if ($use_healing) {echo('checked="checked"');} ?> name="use-healing" type="checkbox" />
                <?=$lang[$LOCALE][$LANG_SEARCH]['use-healing']?><br />
              </label>
            </td>
          </tr>
          <?php } ?>
        </table>
      </td>
    </tr>
  </table>
  <?php if (USE_HEALING === true) { ?>
  <div id="healing-selector">
    <?php
      include(PATH . '/template/search-heal.php');
    ?>
  </div>
  <?php } ?>
  <div id="weapon-selector-wrapper">
    <?php
      include(PATH . '/template/search-weapon.php');
      include(PATH . '/template/search-finisher.php');
      include(PATH . '/template/search-buffs.php');
    ?>
  </div>
  <div style="clear: both;"></div>
