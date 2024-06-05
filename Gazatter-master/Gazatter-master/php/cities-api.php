<?php
require_once __DIR__ . '/config.php';
$isoCode = isset($_GET['isoCode']) ? $_GET['isoCode'] : '';
$apiKey = OPEN_WEATHER_MAP_API_KEY;
$url = "https://us1.locationiq.com/v1/search.php?key=pk.0f39f0c4480c3a5df676c1be573a9884&countrycodes=$isoCode&format=json&q=Los%20Angeles";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;