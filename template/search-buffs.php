<div id="search-buff-wrapper" class="search-sub-wrapper">
    <div class="search-wrapper-header">
      <?=$lang[$LOCALE][$LANG_SEARCH]['search-buff-header']?>
    </div>
    <div class="weapon-buff-info">
        <?=$lang[$LOCALE][$LANG_SEARCH]['search-buff-info']?>
    </div>

    <div class="weapon-buff-wrapper">
        <table>
            <tr>
                <td class="search-key-td">
                  <?=$lang[$LOCALE][$LANG_SEARCH]['buff-reload-speed']?><br />
                </td>
                <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['buff-reload-speed-tooltip']?>" class="tooltip search-input search-value-td">
                  <input name="buff-reload-speed" value="<?=$buff_reload_speed?>" type="text" class="idleField" />%
                </td>
            </tr>
            <tr>
                <td class="search-key-td">
                  <?=$lang[$LOCALE][$LANG_SEARCH]['buff-damage']?><br />
                </td>
                <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['buff-damage-tooltip']?>" class="tooltip search-input search-value-td">
                  <input name="buff-damage" value="<?=$buff_damage?>" type="text" class="idleField" />%
                </td>
            </tr>
            <tr>
                <td class="search-key-td">
                  <?=$lang[$LOCALE][$LANG_SEARCH]['buff-skill-req']?><br />
                </td>
                <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['buff-skill-req-tooltip']?>" class="tooltip search-input search-value-td">
                  <input name="buff-skill-req" value="<?=$buff_skill_req?>" type="text" class="idleField" />%
                </td>
            </tr>
        </table>
    </div>
    <div class="weapon-buff-wrapper">
        <table>
            <tr>
                <td class="search-key-td">
                  <?=$lang[$LOCALE][$LANG_SEARCH]['buff-ammo-burn']?><br />
                </td>
                <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['buff-ammo-burn-tooltip']?>" class="tooltip search-input search-value-td">
                  <input name="buff-ammo-burn" value="<?=$buff_ammo_burn?>" type="text" class="idleField" />%
                </td>
            </tr>
            <tr>
                <td class="search-key-td">
                  <?=$lang[$LOCALE][$LANG_SEARCH]['buff-crit-chance']?><br />
                </td>
                <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['buff-crit-chance-tooltip']?>" class="tooltip search-input search-value-td">
                  <input name="buff-crit-chance" value="<?=$buff_crit_chance?>" type="text" class="idleField" />%
                </td>
            </tr>
            <tr>
                <td class="search-key-td">
                  <?=$lang[$LOCALE][$LANG_SEARCH]['buff-crit-damage']?><br />
                </td>
                <td title="<?=$lang[$LOCALE][$LANG_SEARCH]['buff-crit-damage-tooltip']?>" class="tooltip search-input search-value-td">
                  <input name="buff-crit-damage" value="<?=$buff_crit_damage?>" type="text" class="idleField" />%
                </td>
            </tr>
        </table>
    </div>
    <table><tr><td>
        <label style="margin-top: 6px;">
            <input <?php if ($buff_floor_values) echo('checked="checked"') ?> name="buff-floor-values" type="checkbox" />
            <?=$lang[$LOCALE][$LANG_SEARCH]['buff-floor-values']?>
        </label>
    </td></tr></table>
</div>
