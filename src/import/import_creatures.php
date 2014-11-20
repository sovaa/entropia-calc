<?php
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>");

define('INCLUDE_CHECK', true);

$file = "csv/creatures.csv";

include("import.class.php");

$handle = @fopen($file, "r");
$inserted = 0;
$updated = 0;
$i = 0;

$exceptions = array();
$exceptions['Gallard Puny'] = array(10, 15);

$new = array();
$replaced = array();

if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
      $attrs = explode(';', $buffer);

      if ($attrs == null || $attrs == "" || count($attrs) < 2) {
        continue;
      }

      if ($attrs[0] == 'Creature') {
        continue;
      }

      // health
      if ($attrs[2] == null || trim($attrs[2]) == "") {
        continue;
      }

      // regen
      if ($attrs[3] == null || trim($attrs[3]) == "" || $attrs[3] == 0) {
        if ($attrs[4] == null || trim($attrs[4]) == "") {
          continue;
        }
        else {
          $attrs[3] = $attrs[4];
        }
      }
      else {
        $attrs[3] = $attrs[2] / $attrs[3];
      }

      $name = $attrs[0] . " " . $attrs[1];
      $health = $attrs[2];

      // puny mobs may only show stamina as 1, which indicated health of 10 on entropedia, but some puny mobs has >10hp but <20hp, so add exceptions for known ones
      if (array_key_exists($name, $exceptions) && $exceptions[$name][0] == $health) {
          array_push($replaced, "Replacing health '$health' with '{$exceptions[$name][1]}' for $name.<br />");
          $health = $exceptions[$name][1];
      }

      $values = array(
          'name'   => $name,
          'hp'     => $health,
          'regen'  => $attrs[3],
          'maturity' => $i,
          'damage' => $attrs[5],
          'threat' => $attrs[10]
      );

      $rs = Dao::execute($dao, "select * from creature where name = ?", array($values['name']));

      if (isset($rs) && $rs != null && count($rs) != 0) {
        $updated++;
        Import::update($values, "creature");
      }
      else {
        $inserted++;
        array_push($new, $values['name']);
        Import::insert($values, "creature");
      }

      $i++;
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
        <?php echo("Updated $updated creatures.<br />Inserted $inserted new creatures."); ?>
<br />
<pre>
<?php 
print_r($replaced); 
print_r($new);
?>
</pre>
    </body>
</html>

