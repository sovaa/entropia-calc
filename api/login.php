<?php

$url = 'https://browserid.org/verify';
$data = http_build_query(array('assertion' => $_POST['assertion'], 'audience' => urlencode('eldslott.org')));

$params = array(
    'http' => array(
        'method' => 'POST',
        'content' => $data,
        'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
            . "Content-Length: " . strlen($data) . "\r\n"
    )
);
    
$ctx = stream_context_create($params);
$fp = fopen($url, 'rb', false, $ctx);

if ($fp) {
  $result = stream_get_contents($fp);
}
else {
  $result = FALSE;
}

$json = json_decode($result);
$salt1 = "I1eVyaYkqDuDbnh4puV7ab5pUucHfm2yGhEPprR4lX4adl";
$salt2 = "UQedirNDoUbUoz4hNSFOTFFxndDc";

if ($json->status == 'okay') {
    setcookie('eldslott-browserid', $json->email, 0);

    $_SESSION['email'] = $json->email;

    print_r($result);
    // the user logged in successfully.
}
else {
    die("could not login");
    // log in failed.
}

?>
