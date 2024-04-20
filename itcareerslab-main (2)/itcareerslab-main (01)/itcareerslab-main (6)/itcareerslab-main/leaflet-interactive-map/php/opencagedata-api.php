<?php
require_once __DIR__ . '/config.php';
$countryName = isset($_GET['query']) ? urlencode($_GET['query']) : '';
$lat = isset($_GET['lat']) ? $_GET['lat'] : '';
$lng = isset($_GET['lng']) ? $_GET['lng'] : '';

if ($countryName != "") {
    $url = "https://api.opencagedata.com/geocode/v1/json?q={$countryName}&key=" . OPEN_CAGE_DATA_API_KEY;
} else {
    $url = "https://api.opencagedata.com/geocode/v1/json?q={$lat}+{$lng}&key=" . OPEN_CAGE_DATA_API_KEY;
}

// TODO: Implement Error Handling for the API call

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
