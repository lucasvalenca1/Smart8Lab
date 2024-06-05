<?php
require_once __DIR__ . '/config.php';
$selectedCountry = $_GET['country'];
$apiKey = OPEN_WEATHER_MAP_API_KEY;
$url = "http://api.weatherapi.com/v1/forecast.json?key=". $apiKey. "&q=$selectedCountry&days=3";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
