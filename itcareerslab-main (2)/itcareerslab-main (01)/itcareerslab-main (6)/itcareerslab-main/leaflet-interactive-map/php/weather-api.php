<?php
require_once 'apikeys.php';
$lat = $_GET['lat'];
$lon = $_GET['lon'];

$url = "http://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid=" . OPEN_WEATHER_MAP_API_KEY . "&units=metric";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>