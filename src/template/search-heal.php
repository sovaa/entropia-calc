<div id="search-heal-wrapper" class="search-sub-wrapper">
  <div class="search-wrapper-header">
    <?=$lang[$LOCALE][$LANG_SEARCH]['search-heal-header']?>
  </div>
  
  <table style="width: 40%; float: left;">
  	<tr>
  	  <th style="width: 60%;" class="search-key-td">
  	    Player HP
  	  </th>
  	  <td>
  	    <input type="text" style="width: 50px;" name="player-hp" value="120" />
  	  </td>
  	</tr>
  	<tr>
  	  <th class="search-key-td">
  	    Heal when HP at
  	  </th>
  	  <td>
  	    <input type="text" style="width: 50px;" name="player-heal-at" value="10" />%
  	  </td>
  	</tr>
  	<tr>
  	  <th class="search-key-td">
  	    Markup
  	  </th>
  	  <td>
  	    <input type="text" style="width: 50px;" name="player-heal-markup" />%
  	  </td>
  	</tr>
  </table>
  
  <table style="width: 40%;">
  	<tr>
  	  <th style="width: 60%;" class="search-key-td">
  	    Dodge profession
  	  </th>
  	  <td>
  	    <input type="text" style="width: 50px;" name="player-dodge" value="0" />
  	  </td>
  	</tr>
  	<tr>
  	  <th class="search-key-td">
  	    Evade profession
  	  </th>
  	  <td>
  	    <input type="text" style="width: 50px;" name="player-evade" value="0" />
  	  </td>
  	</tr>
  	<tr>
  	  <th class="search-key-td">
  	    Paramedic profession
  	  </th>
  	  <td>
  	    <input type="text" style="width: 50px;" name="player-paramedic" />
  	  </td>
  	</tr>
  	<tr>
  	  <th class="search-key-td">
  	    Biotropic profession
  	  </th>
  	  <td>
  	    <input type="text" style="width: 50px;" name="player-biotropic" />
  	  </td>
  	</tr>
  </table>
  
  <br />
  <table>
  	<tr>
  	  <td style="text-align: right; padding-right: 5px; font-weight: bold;">
  	    Method of healing
  	  </td>
  	  <td>
  	  	<label>
  	      <input type="radio" style="vertical-align: middle;" name="player-heal-type" value="once" />
  	      <span style="vertical-align: middle;">
  	        Heal once.
  	      </span>
  	    </label>
        <label style="vertical-align: middle">
          <input type="radio" style="vertical-align: middle;" name="player-heal-type" value="max" checked="checked" />
          <span style="vertical-align: middle;">
            Heal max.
          </span>
        </label>
          <input type="radio" style="vertical-align: middle;" name="player-heal-type" value="max" />
          <span style="vertical-align: middle;">
            Heal max if mob HP &gt;<input type="text" style="width: 25px;" value="10" />%, 
            else heal to <input type="text" style="width: 25px;" value="25" />%.
          </span>
  	  </td>
  	</tr>
  </table>
  
  <br />
  
  <table style="width: 100%;"><tr><td style="width: 50%; vertical-align: top;">
	  <select class="setting" name="heal-id" id="medical-tool">
	    <?php
	      echo("<option value='--'>{$lang[$LOCALE][$LANG_SEARCH]['select-heal']}</option>");
	      foreach ($heals as $heal) {
	      	$json = json_encode($heal, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
	      	
	        if ($selected_heal_id == $heal['id']) {
	          echo("<option selected='selected' title='$json' value='{$heal['id']}'>{$heal['name']}</option>");
	        }
	        else {
	          echo("<option title='$json' value='{$heal['id']}'>{$heal['name']}</option>");
	        }
	      }
	    ?>
	  </select><br />
	  <div id="toggle-heal-enhancers"><?=$lang[$LOCALE][$LANG_SEARCH]['toggle-heal-enhancers']?></div>
	  <div id="select-heal-enhancers" class="enhancers-selector" style="display: none;">
	    <input type="hidden" name="hide-heal-enhancers" id="hide-heal-enhancers" value="<?=$hide_heal_enhancers?>" />
	    <div class="change-all-heal-enhancers">
	      <?=$lang[$LOCALE][$LANG_SEARCH]['change-all-heal-enhancers']?><br />
	      <select class="all-heal-enhancers" name="all-heal-enhancers">
	        <?php
	          foreach ($enhancer_heal_names as $key => $value) {
	            if ($all_heal_enhancers == $key) {
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
	    <select class="heal-enhancers" name="heal-enhancers[]">
	      <?php
	        foreach ($enhancer_heal_names as $key => $value) {
	          if ($key === 0) {
	            echo("<option selected='selected' value='$key'>{$lang[$LOCALE][$LANG_SEARCH][$value]} $i</option>");
	            }
	          else if ($enhancer_heal_list[$i] == $key) {
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
	  </div> <!-- select-heal-enhancers -->
	  </td><td style="vertical-align: top;">
	  
	  <div id="medical-info">
		  <table>
		  	<tr>
		  	  <td class="key">
		  	    Profession
		  	  </td>
		  	  <td>
		  		<span id="heal-stats-profession">Paramedic</span>
		  	  </td>
		  	</tr>
		  	<tr>
		  	  <td class="key">
		  	    Maxed
		  	  </td>
		  	  <td>
		  		<span id="heal-stats-max">6.5</span> Levels
		  	  </td>
		  	</tr>
		  	<tr>
		  	  <td class="key">
		  	    Heal
		  	  </td>
		  	  <td>
		  		<span id="heal-stats-heal">160</span> HP
		  	  </td>
		  	</tr>
		  	<tr>
		  	  <td class="key">
			    Effective Heal
		  	  </td>
		  	  <td>
		  		<span id="heal-stats-effective">160</span> HP
		  	  </td>
		  	</tr>
		  	<tr>
		  	  <td class="key">
		  	    Start Interval
		  	  </td>
		  	  <td>
		  		<span id="heal-stats-start">60</span> HP
		  	  </td>
		  	</tr>
		  	<tr>
		  	  <td class="key">
		  	    Uses
		  	  </td>
		  	  <td>
		  		<span id="heal-stats-uses">30</span>/min
		  	  </td>
		  	</tr>
		  	<tr>
		  	  <td class="key">
		  	    Reload
		  	  </td>
		  	  <td>
		  		<span id="heal-stats-reload">2</span> sec
		  	  </td>
		  	</tr>
		  	<tr>
		  	  <td class="key">
		  	    Heal/second
		  	  </td>
		  	  <td>
		  		<span id="heal-stats-hps">80</span> HP
		  	  </td>
		  	</tr>
		  	<tr>
		  	  <td class="key">
		  	    Decay
		  	  </td>
		  	  <td>
		  		<span id="heal-stats-decay">1</span> PEC
		  	  </td>
		  	</tr>
		  	<tr>
		  	  <td class="key">
		  	    Cost
		  	  </td>
		  	  <td>
		  		<span id="heal-stats-cost">1</span> PEC
		  	  </td>
		  	</tr>
		  	<tr>
		  	  <td class="key">
		  	    Heal/PEC
		  	  </td>
		  	  <td>
		  		<span id="heal-stats-eco">160</span> HP
		  	  </td>
		  	</tr>
		  </table>
	  </div>
	  
　　</td></tr></table>
</div>
<div style="clear: both;"></div>