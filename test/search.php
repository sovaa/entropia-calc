<?php

DEFINE('TPATH', $_SERVER['PWD'] . '/');

/*include(TPATH . '/include/calculator.php');
include(TPATH . '/include/objects.php');
include(TPATH . '/include/utils.php');
include(TPATH . '/include/merger.php');
include(TPATH . "/include/damage.php");
include(TPATH . "/include/manager.php");
include(TPATH . "/include/init.php");
*/
define('INCLUDE_CHECK', true);

$results = array();

include('include/config.php');
include(TPATH . "include/objects.php");
include(TPATH . "include/utils.php");
include(TPATH . "include/filter.php");
include(TPATH . "include/merger.php");
include(TPATH . "include/damage.php");
include(TPATH . "include/manager.php");
include(TPATH . "include/locale.php");
include(TPATH . "include/init.php");
include(TPATH . "include/calculator.php");

function decodeInput($test, $file) {
    return unserialize(base64_decode(file_get_contents(TPATH . "/test/$test/$file.base64")));
}

$success = true;

function p($level, $msg) {
    global $success;
    $success = false;
    for ($i = 0; $i < $level; $i++) {
        echo("  ");
    }
    echo("$msg\n");
}

function loop($expected, $actual, $level, Prefix $prefix) {
    if (count($expected) == 0) {
        return;
    }

    foreach ($expected as $key => $value) {
        if (is_array($value)) {
            $prefix->addStore(array($level, "[ $key ]"));
            loop($value, $actual[$key], $level + 1, $prefix);
        }
        else {
            if ($value == $actual[$key]) {
                // nothing, all good
            }
            else {
                $pmax = array();
                foreach ($prefix->getStores() as $p) {
                    $pmax[$p[0]] = $p[1];
                }
                foreach ($pmax as $pkey => $pvalue) {
                    if ($pkey < $level) {
                        p($pkey, $pvalue);
                    }
                }
                p($level, "[ $key ]  expected: $value, actual {$actual[$key]}");
            }
        }
    }
}

$tests = array(
    'skillbased',
    'findamps',
    'findcreature',
    'findfinisher'
);

class Prefix {
    private $store = array();

    public function addStore($val) {
        $this->store[] = $val;
    }

    public function getStores() {
        return $this->store;
    }

    public function popStore() {
        array_pop($this->store);
    }

    public function clearLevel($level) {
        $newstore = array();
        foreach ($this->store as $s) {
            if ($s[0] == $level) {
                continue;
            }
            $newstore[] = $s;
        }
        $this->store = $newstore;
    }
}

foreach($tests as $test) {
    echo("\nTEST '$test' running...\n");
    $success = true;

    $weapon = decodeInput($test, "weapon");
    $creature = decodeInput($test, "creature");
    $amplifier = decodeInput($test, "amplifier");
    $search = decodeInput($test, "search");
    $weapon = decodeInput($test, "weapon");
    $amplifier_fin = decodeInput($test, "amplifier_finisher");
    $scope_and_sights = decodeInput($test, "scope_and_sights");
    $result_expected = decodeInput($test, "result");

    $calc = new Calculator();
    $result_actual = $calc->calcWrapper($weapon, $creature, $amplifier, $amplifier_fin, $search, $scope_and_sights);
    loop($result_expected, $result_actual, 0, new Prefix());

    if ($success) {
        echo("TEST '$test' passed!\n");
    }
}

