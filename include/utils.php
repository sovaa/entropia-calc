<?php

class Utils {
    public static function isLimited($name) {
        if ($name == null || strlen(trim($name)) == 0) {
            return false;
        }

        if (stripos($name, '(L)') !== false) {
            return true;
        }

        return false;
    }

    public static function parseNumber($number, $default, $min = 0, $le = true) {
        if ($number == "" || !is_numeric($number)) {
            return $default;
        }

        if ($le && floatval($number) <= $min) {
            return $default;
        } else if (floatval($number) < $min) {
            return $default;
        }

        return floatval($number);
    }

    public static function printr($array) {
        echo("<pre>");
        print_r($array);
        echo("</pre>");
    }

    public static function bondTheory($hp, $loot, $dpp, $multi) {
        $bloot = $loot / 100;
        $bmax = $hp / ($dpp * 100);
        $bmin = $bmax * $bloot;
        $bglobal = $bmax * $multi;

        $baverage = ($bmax + $bmin) / 2;

        return array(
            'max' => $bmax,
            'min' => $bmin,
            'average' => $baverage,
            'global' => $bglobal,
            'multi' => $multi
        );
    }

    public static function shouldSkip($name, $skip_list) {
        if ($skip_list == null || !is_array($skip_list) || count($skip_list) == 0) {
            return false;
        }

        foreach ($skip_list as $skip) {
            if ($name == $skip) {
                return true;
            }
        }

        return false;
    }

    public static function ampType($weapon_type) {
        if ($weapon_type == "Laser") {
            return "Laser";
        }

        if ($weapon_type == "Plasma") {
            return "Laser";
        }

        if ($weapon_type == "BLP") {
            return "BLP";
        }

        return $weapon_type;
    }

    public static function decimalToNumber($str, $decimal_places = 3, $decimal_padding = 0) {
        $str = number_format($str, $decimal_places, '.', '');
        $number = explode('.', $str);

        if (!isset($number[1])) {
            $number[1] = '';
        }

        $decimal = str_pad($number[1], $decimal_places, $decimal_padding);

        return (float)$number[0] . '.' . $decimal;
    }

    public static function error($message) {
        $log = PATH . "/log/error.log";
        $fh = fopen($log, 'a');

        if ($fh === false) {
            return;
        }

        date_default_timezone_set('UTC');
        fwrite($fh, "----------------------\n");
        fwrite($fh, "[" . date("Y-m-d H:i:s") . "]: $message\n\n");
        fwrite($fh, $_SERVER['REQUEST_URI'] . "\n");
        fwrite($fh, "----------------------\n\n\n");

        fclose($fh);
    }
}

// short-hand synonym used by the minimized html to save as many bytes as possible
function n($str, $decimal_places = 3, $decimal_padding = 0) {
    return Utils::decimalToNumber($str, $decimal_places, $decimal_padding);
}

function error($message) {
    Utils::error($message);
}

function toNumber($s) {
    return number_format(round($s, 3), 3, '.', '');
}

function roundOneDecimal($s) {
    return round($s, 1);
}

function printr($array) {
    echo("<pre>");
    print_r($array);
    echo("</pre>");
}