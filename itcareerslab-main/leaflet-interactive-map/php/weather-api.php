<?php
$apiKey = '7ca866e3e5138d79c96f03a10f59cf36';
$lat = $_GET['lat'];
$lon = $_GET['lon'];

$url = "http://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>