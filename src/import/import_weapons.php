<?php
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>");

define('INCLUDE_CHECK', true);

$weapons_file = "csv/weapons.csv";

include("import.class.php");

$handle = @fopen($weapons_file, "r");

$updated = 0;
$inserted = 0;
$new = array();

if (!$handle) {
    die("file not found!");
}

if ($handle) {
    $skip = true;
    while (($buffer = fgets($handle, 4096)) !== false) {
        $attrs = explode(';', $buffer);

        if ($attrs[0] == 'Name') {
            continue;
        }

        if ($attrs[16] == null || strlen(trim($attrs[16])) == 0) {
            $attrs[16] = null;
        }
        else {
            $attrs[16] = str_replace('%', '', $attrs[16]);

            if ($attrs[16] == '0.00' || $attrs[1] == '0') {
                $attrs[16] = null;
            }
        } // markup

        if ($attrs[12] == null || strlen(trim($attrs[12])) == 0) {
            continue;
        } // decay

        if ($attrs[8] == null || strlen(trim($attrs[8])) == 0) {
            continue;
        } // attacks

        if ($attrs[13] == null || strlen(trim($attrs[13])) == 0) {
            $attrs[13] = null;
        } // burn

        if ($attrs[31] != null) {
            if ($attrs[31] === 'Yes') {
                $attrs[31] = '1';
            }
            else {
                $attrs[31] = '0';
            }
        }
        else {
            $attrs[31] = '0';
        } // sib

        $values = array(
                'name'     => $attrs[0],
                'class'    => $attrs[1],
                'type'     => $attrs[2],
                'weight'   => $attrs[4],
                'damage'   => $attrs[5],
                'range'    => $attrs[6],
                'attacks'  => $attrs[8],
                'power'    => $attrs[11],
                'decay'    => $attrs[12],
                'burn'     => $attrs[13],
                'maxtt'    => $attrs[15],
                'mintt'    => $attrs[16],
                'markup'   => $attrs[17],
                'uses'     => $attrs[19],
                'dmgstb'   => $attrs[22],
                'dmgcut'   => $attrs[23],
                'dmgimp'   => $attrs[24],
                'dmgpen'   => $attrs[25],
                'dmgshr'   => $attrs[26],
                'dmgbrn'   => $attrs[27],
                'dmgcld'   => $attrs[28],
                'dmgacd'   => $attrs[29],
                'dmgelc'   => $attrs[30],
                'sib'      => $attrs[31],
                'hitprof'  => $attrs[37],
                'hitrec'   => $attrs[38],
                'hitmax'   => $attrs[39],
                'dmgprof'  => $attrs[40],
                'dmgrec'   => $attrs[41],
                'dmgmax'   => $attrs[42],
                'source'   => $attrs[43],
                'discovered' => $attrs[44],
                'found'    => $attrs[45],
                );

        $rs = Dao::execute($dao, "select * from weapon where name = ? and class = ? and type = ?", array($values['name'], $values['class'], $values['type']));

        if (isset($rs) && $rs != null && count($rs) != 0) {
            $updated++;
            Import::update($values, "weapon");
        }
        else {
            $inserted++;
            array_push($new, $values['name']);
            Import::insert($values, "weapon");
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
<?php echo("Updated $updated weapons.<br />Inserted $inserted new weapons."); ?>
<br />
<pre>
<?php print_r($new); ?>
</pre>
</body>
</html>

