          <div id="filter-header">
            <?= $lang[$LOCALE][$LANG_SEARCH]['filter-header'] ?>
          </div>
          
          <div>
            <input value="<?= $lang[$LOCALE][$LANG_SEARCH]['add-filter'] ?>" type="button" id="add-filter" />
            <input type="hidden" value="<?=$filters?>" id="filters" name="filters" />
          </div>
          <table id="filter-list">
            <?php
              for ($i = 0; $i < $filters; $i++) {
            ?>
            <tr class="filter-entry">
              <td>
                <select class="column" name="filter-column-name[]">
                  <?php
                      foreach ($filter_names as $key) {
                        if ($filter_name_list[$i] == $key) {
                          echo("<option selected='selected' value='$key'>{$lang[$LOCALE][$LANG_HEADER][$key]}</option>");
                        }
                        else {
                          echo("<option value='$key'>{$lang[$LOCALE][$LANG_HEADER][$key]}</option>");
                        }
                      }
                  ?>
                </select>
              </td>
              <td>
                <select class="symbol" name="filter-column-match[]">
                  <?php
                      foreach ($filter_matches as $key) {
                        $pkey = $key;
                        if ($key == '&lt;') {
                          $key = '<';
                        }
                        else if ($key == '&gt;') {
                          $key = '>';
                        }

                        if ($filter_match_list[$i] == $key) {
                          echo("<option selected='selected' value='$pkey'>$pkey</option>");
                        }
                        else {
                          echo("<option value='$pkey'>$pkey</option>");
                        }
                      }
                  ?>
                </select>
              </td>
              <td>
                <?php if (isset($single_weapon_name)) { ?>
                <input name="filter-column-value[]" type="text" value="<?=$single_weapon_name?>" />
                <?php } else { ?>
                <input name="filter-column-value[]" type="text" value="<?=count($filter_value_list) > 0 ? $filter_value_list[$i] : ''?>" />
                <?php } ?>
              </td>
              <td>
                <input type="button" value="-" class="remove-filter" />
              </td>
            </tr>
            <?php
              }
            ?>
          </table>

<br />
<br />
<br />

<div>
    <span style="font-weight: bold; padding-left: 25px;">
      <?=$lang[$LOCALE][$LANG_SEARCH]['skip-header']?>
    </span>
    <br />
    <br />

    <select id="skip-list" name="skip-list[]" multiple="multiple" size="10" style="width: 400px;">
        <?php
        
        if (isset($skip_list) && is_array($skip_list) && count($skip_list) > 0) {
          foreach ($skip_list as $skip) {
            echo("<option value='$skip'>$skip</option>");
          }
        }

        ?>
    </select>

    <br />
    <input type="button" id="skip-list-remove" value="<?=$lang[$LOCALE][$LANG_SEARCH]['skip-remove']?>" style="font-weight: bold;" />
    <input type="button" id="skip-list-clear" value="<?=$lang[$LOCALE][$LANG_SEARCH]['skip-clear']?>" />
</div>
