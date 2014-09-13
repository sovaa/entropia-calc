<tr class="cost-details-row" id="result-<?=$result['id']?>">
  <td class="colspan-<?=sizeof($result)-1?> cost-details">
    <div class="yui3-u-1 mw11">
      <div class="yui3-u-1-2">
        <?php include(PATH . "/template/hidden-numbers-html.php"); ?>
      </div>

      <div class="yui3-u-1-2">
        <?php include(PATH . "/template/hidden-visuals-html.php"); ?>
      </div>
    </div>
    <div class="yui3-u-1 mw11">
        <?php include(PATH . "/template/hidden-formulae.php"); ?>
    </div>
    <hr />

    <div class="yui3-u-1 mw11">
      <?php if ($find_finishers === true) { ?>
        <div class="yui3-u-1-2">
          <?php include(PATH . "/template/hidden-finishers-html.php"); ?>
        </div>
      <?php } ?>
       
      <?php if ($find_amplifiers === true) { ?>
        <div class="yui3-u-1-2">
          <?php include(PATH . "/template/hidden-amps-html.php"); ?>
        </div>
      <?php } ?>
    </div>
    
    <?php if ($find_creatures === true) { ?>
      <div class="yui3-u-1 mw11">
        <?php include(PATH . "/template/hidden-creatures-html.php"); ?>
      </div>
    <?php } ?>
  </td>
</tr>

