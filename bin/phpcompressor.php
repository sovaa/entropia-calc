<?php

if (count($argv) < 2) {
    die("usage: php {$argv[0]} <file>\n");
}

$lines = file($argv[1]);

$output = "";

if (count($lines) > 0) {
    foreach($lines as $line) {
        $output .= minify_html1($line);
    }

    echo(minify_html1($output));
}

function minify_html1($d) {
    $d = str_replace(array(chr(9), chr(10), chr(11), chr(13)), ' ', $d);
    $d = preg_replace('`<\!\-\-.*\-\->`U', ' ', $d);
    $d = preg_replace('/[ ]+/', ' ', $d);
    $d = str_replace('> <', '><', $d);
    return $d;
}

?>
