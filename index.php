<?php

function isLocal() {
    return $_SERVER['REMOTE_ADDR'] == '127.0.0.1';
}

// skip the notices
//error_reporting (E_ALL ^ E_NOTICE);

error_reporting(E_ALL);
ini_set('display_errors', 1);

ini_set("max_execution_time", "300");
header('Cache-Control: max-age=1800, must-revalidate');
header('Vary: Accept-Encoding');
header('Content-Language: en');
header('Content-Type: text/html; charset=utf-8');
define('INCLUDE_CHECK', true);
define('TEST', false);

$results = array();

include("include/config.php");
include("include/objects.php");
include("include/utils.php");
include("include/filter.php");
include("include/merger.php");
include("include/damage.php");
include("include/manager.php");
include("include/locale.php");
include("include/init.php");
include("include/handler.php");

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Entropia Armory</title>

        <link rel="stylesheet" type="text/css" href="css/styles-min.css" />

        <?php if (isLocal()) { ?>
            <script data-cfasync="false" type="text/javascript" src="js/jquery.min.js"></script>
            <script data-cfasync="false" type="text/javascript" src="js/jquery.dataTables.min.js"></script>
        <?php } else { ?>
            <script data-cfasync="false" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
            <script data-cfasync="false" type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.1/jquery.dataTables.min.js"></script>
        <?php } ?>

        <script data-cfasync="false" type="text/javascript" src="js/scripts-min.js"></script> 

        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-31832437-1']);
            _gaq.push(['_trackPageview']);
            
            (function() {
              var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
              ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
              var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>

    </head>
    <?php flush(); ?>
    <body>
      <?php
        $mtime = microtime();
        $mtime = explode(" ",$mtime);
        $mtime = $mtime[1] + $mtime[0];
        $starttime = $mtime; 
      ?>

      <?php include("template/header.php"); ?>
      <?php include("template/logo.php"); ?>

      <div id="main-container">
        <div id="cost-helper">
          <div id="cost-helper-inner">
            <?=$lang[$LOCALE][$LANG_HELP]['cost-details']?>
          </div>
        </div>
  
        <div id="skill-helper">
          <div id="skill-helper-inner">
            <?=$lang[$LOCALE][$LANG_HELP]['skill-details']?>
          </div>
        </div>
  
        <div id="creature-helper">
          <div id="creature-helper-inner">
            <?=$lang[$LOCALE][$LANG_HELP]['creature-details']?>
          </div>
        </div>
  
        <div id="enhancer-helper">
          <div id="enhancer-helper-inner">
            <?=$lang[$LOCALE][$LANG_HELP]['enhancer-details']?>
          </div>
        </div>
  
        <form method="get" action="." id="search-form">
          <div id="search-wrapper">
            <table id="search-wrapper-divider">
                <tr>
                    <td id="search-wrapper-search">
                        <?php include("template/search.php"); ?>
                    </td>
                    <td id="search-wrapper-line">
                        &nbsp;
                    </td>
                    <td id="search-wrapper-filters">
                        <?php include("template/filters.php"); ?>
                    </td>
                </tr>
            </table>
  
            <div>
              <br />
              <input type="submit" value="<?=$lang[$LOCALE][$LANG_SEARCH]['apply-filters']?>" />
              <input type="button" id="reset" value="<?=$lang[$LOCALE][$LANG_SEARCH]['reset']?>" />
              <a href="#results" id="hide-search"><?= $lang[$LOCALE][$LANG_SEARCH]['show-hide-filters'] ?></a>
            </div>
          </div>
  
          <?php
            if ($results == null) {
              // show nothing
            }
            else if (count($results) == 0) {
              echo("<hr />\n");
              echo("<div id=\"no-results\">{$lang[$LOCALE][$LANG_ERROR]['no-results']}</div>");
            }
            else {
              echo("<hr />\n");

              if ($bond_theory && $creature != null) {
                include("template/bond.php");
              }

              include("template/results.php");
            }
          ?>
        </form>
      </div><!-- div#main-container -->
      <div id="page-load-time">
        <br /><br /><br />

        <?php
            $mtime = microtime();
            $mtime = explode(" ",$mtime);
            $mtime = $mtime[1] + $mtime[0];
            $endtime = $mtime;
            $totaltime = ($endtime - $starttime);
            echo("This page was created in ".$totaltime." seconds.");  
        ?>
      </div>
    </body>
</html>

