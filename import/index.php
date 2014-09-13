<?php
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>");

define('INCLUDE_CHECK', true);
include("import.class.php");

$imports = array(
	'tools',
	'implants',
	'medicalenhancers',
        'weaponenhancers'
);

$skips = array(
	'tools' => "Name",
	'implants' => "Name",
	'medicalenhancers' => "Name",
        'weaponenhancers' => "Name"
);

$matches = array(
	'tools' => array(
	    'name',
	    'level',
	    'type',
	    'weight',
	    'heal',
	    'effective',
	    'start',
	    'range',
	    'uses',
	    'reload',
	    'hps',
	    'maxtt',
	    'mintt',
	    'markup',
	    'heals',
	    'decay',
	    'me',
	    'cost',
	    'eco',
	    'concentration',
	    'cooldown',
	    'cooldowngroup',
	    'ammo',
	    'profession',
	    'rec',
	    'max',
	    'sib',
	    'source',
	    'found',
	    'discovered',
	),
	'implants' => array(
            'name',
            'max',
            'weight',
            'decay',
            'maxtt',
            'mintt',
            'markup',
            'uses',
            'source',
            'discovered'
	),
	'medicalenhancers' => array(
	    'name',
	    'points',
	    'socket',
	    'heal',
	    'skill',
	    'decay',
	    'tt',
	    'markup',
	    'source',
	    'discovered'
	),
        'weaponenhancers' => array(
            'name',
            'points',
            'socket',
            'damage',
            'range',
            'accuracy',
            'skill',
            'economy',
            'tt',
            'markup',
            'source',
            'discovered'
        )
);

if (isset($_GET['import'])) {
	$import = new Import();
	$type = $_GET['import'];
	
	$table = substr($type, 0, strlen($type) - 1);
	$file = "csv/$type.csv";
	$match = $matches[$type];
	$skip = $skips[$type];
	
	$result = $import->execute($table, $file, $match, $skip);
	
	$updated = $result['updated'];
	$inserted = $result['inserted'];
	$new = $result['new'];
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
      <?php
        if (isset($_GET['import'])) {
          echo("Updated $updated {$_GET['import']}.<br />Inserted $inserted new {$_GET['import']}.");
      ?>
      
<br />
<pre>
<?php print_r($new); ?>
</pre>

      <?php
        }
        else {
        	echo("<h2>Import</h2>");
        	foreach ($imports as $key => $value) {
      ?>
      
      <a href="./?import=<?=$value?>"><?=$value?></a><br />
      
      <?php
        	}
      ?>
      
      <a href="import_creatures.php">creatures</a><br />
      <a href="import_amps.php">amps</a><br />
      <a href="import_weapons.php">weapons</a><br />
      
      <?php
        }
      ?>
    </body>
</html>

