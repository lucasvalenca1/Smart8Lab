<?php
$apiKey = 'bce5b60b58164f05abf909ca1b16fa12';

$url = "https://openexchangerates.org/api/latest.json?app_id={$apiKey}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>