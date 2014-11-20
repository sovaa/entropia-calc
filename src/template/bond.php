<div id="bond-theory">

  <h3>Bond Theory for <?=$creature['name']?></h3>
  <i>You may adjust the parameters and press 'Search' again to apply them.</i><br />

  DPP used is 
  <input type="text" value="<?=$bond_dpp?>" name="bond-dpp" style="width: 30px;" /> with a minimum loot of 
  <input type="text" value="<?=$bond_loot?>" name="bond-loot" style="width: 30px" />% and a minimum multiplier of 
  <input type="text" value="<?=$bond_multi?>" name="bond-multi" style="width: 30px" />.<br /><br />

  <?php
   $bond = Utils::bondTheory($creature['hp'], $bond_loot, $bond_dpp, $bond_multi);
  ?>

  <table class="result-table">
      <tr>
          <td class="key">Min</td>
          <td class="value"><?=n($bond['min'])?> PED</td>
          <td style="width: 68%;">Minimal possible loot TT value for one creature (except 'no loot' and fragments).</td>
      </tr>
      <tr>
          <td class="key">Max</td>
          <td class="value"><?=n($bond['max'])?> PED</td>
          <td>Maximum possible loot TT value for one creature when no multiplier is applied.</td>
      </tr>
      <tr>
          <td class="key">Average</td>
          <td class="value"><?=n($bond['average'])?> PED</td>
          <td>The average loot TT value returned for one creature (not considering multipliers).</td>
      </tr>
      <tr>
          <td class="key">x<?=n($bond['multi'], 1)?> Multiplier</td>
          <td class="value"><?=n($bond['global'], 2)?> PED</td>
          <td>The lowest possible loot TT value when a multiplier is applied, this is what constitutes globals (if the TT is high enough).</td>
      </tr>
  </table>

  <br />

  Look in the "Bond Profit" column below to se your average return if you receive no multipliers (globals if TT is high enough). Will most likely always be negative, meaning you loose peds, unless you start changing the DPP and min loot values.

  <br />
  <br />
  <i>To learn more about The Bond Theory, read the original thread on 
  <a href="http://www.planetcalypsoforum.com/forums/showthread.php?236806-Player-s-Notes-vol-1-Hunting-Loot-Mechanics">Planet Calypso Forums</a>.</i>
</div>
