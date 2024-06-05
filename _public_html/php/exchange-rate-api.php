<?php
require_once __DIR__ . '/config.php';

$url = "https://openexchangerates.org/api/latest.json?app_id=" . OPEN_EXCHANGE_RATES_API_KEY;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
