<?php

class Filter {
    public static function shouldFilter($result, $name, $match, $value) {
        foreach ($name as $i => $tmpval) {
            $filter_name = $name[$i];
            $filter_match = $match[$i];
            $filter_value = $value[$i];

            if (!array_key_exists($filter_name, $result)) {
                continue;
            }

            if ($filter_value != null && $filter_value != "") {
                if ($filter_match == "=") {
                    if (stripos($result[$filter_name], $filter_value) === false) {
                        return false;
                    }
                }
                else if ($filter_match == "!=") {
                    if (stripos($result[$filter_name], $filter_value) > 0) {
                        return false;
                    }
                }
                else if ($filter_match == "regex") {
                    if (@preg_match('/' . $filter_value . '/', $result[$filter_name]) == 0) {
                        return false;
                    }
                }
                else if ($filter_match == "<") {
                    if (floatval($result[$filter_name]) >= floatval($filter_value)) {
                        return false;
                    }
                }
                else if ($filter_match == ">") {
                    if (floatval($result[$filter_name]) <= floatval($filter_value)) {
                        return false;
                    }
                }
                else if ($filter_match == "approx") {
                    $strs = explode("*", $filter_value);
                    $found = true;
                    $pos = 0;

                    foreach ($strs as $str) {
                        if ($str == null || $str == "") {
                            continue;
                        }

                        $pos_new = stripos($result[$filter_name], $str, $pos);

                        if ($pos_new === false) {
                            $found = false;
                            break;
                        }

                        $pos = $pos_new + 2;
                    }

                    if ($found == false) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}