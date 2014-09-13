<?php

if (!array_key_exists('eldslott-browserid', $_COOKIE)) {
    if (isset($_SESSION['email'])) {
        unset($_SESSION['email']);
    }

    die();
}

if (session_id() == '') {
    session_start();
}

$_SESSION['email'] = $_COOKIE['eldslott-browserid'];

echo("true");

?>
