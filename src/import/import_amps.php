<?php
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>");

define('INCLUDE_CHECK', true);

$file = "csv/amps.csv";

include("import.class.php");

  $handle = @fopen($file, "r");
  $inserted = 0;
  $updated = 0;
  $new = array();

  if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
      $attrs = explode(';', $buffer);

      if ($attrs[0] == "Name") {
        continue;
      }

      if ($attrs[7] == null || trim($attrs[7]) == "") {
        continue;
      }
      if ($attrs[3] == null || trim($attrs[3]) == "") {
        continue;
      }
      if ($attrs[8] == null || trim($attrs[8]) == "") {
        continue;
      }

      $values = array(
          'name'     => $attrs[0] . " (" . $attrs[3] . " dmg)",
          'decay'    => $attrs[7],
          'damage'   => $attrs[3],
          'burn'     => $attrs[8],
          'type'     => str_replace(" Amp", "", str_replace("Energy", "Laser", $attrs[1]))
      );

      $rs = Dao::execute($dao, "select * from amp where name = ? and type = ?", array($values['name'], $values['type']));

      if (isset($rs) && $rs != null && count($rs) != 0) {
        $updated++;
        Import::update($values, "amp");
      }
      else {
        $inserted++;
        array_push($new, $values['name']);
        Import::insert($values, "amp");
      }
    }

    if (!feof($handle)) {
      echo "Error: unexpected fgets() fail\n";
    }

    fclose($handle);
  }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd" xml:lang="en">

    <head>            
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title></title>
        <link rel="stylesheet" type="text/css" href="/stdtheme.css" />
        <script type="text/javascript"></script>
    </head>
    <body>
        <?php echo("Updated $updated amplifiers.<br />Inserted $inserted new amplifiers."); ?>
<br />
<pre>
<?php print_r($new); ?>
</pre>
    </body>
</html>

