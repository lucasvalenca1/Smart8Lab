<?php
//require_once 'apikeys.php';

// Airlabs API are currently not available (waiting list)
// So, I will use a static array of airports

// Get the latitude and longitude from the query string
// $lat = isset($_GET['lat']) ? $_GET['lat'] : '';
// $lng = isset($_GET['lng']) ? $_GET['lng'] : '';

// $url = "https://airlabs.co/api/v9/nearby?lat={$lat}&lng=${lng}&distance=20&api_key=${AIRLABS_API_KEY}";

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $response = curl_exec($ch);
// curl_close($ch);

// echo json_encode($response);

/*** Airlabs Mock data */
$jsonData = file_get_contents('data/airlabs_airports_cities_mock_data.json');

// Decode the JSON data an associate array
$data = json_decode($jsonData, true);

// Get the isoCode from the query string
$isoCode = isset($_GET['isoCode']) ? $_GET['isoCode'] : '';

// Filter the airports by the isoCode
// Using PHP Closure to filter the airports
$filteredAirports = array_filter($data["airports"], function ($airport) use ($isoCode) {
    return $airport['country_code'] === $isoCode;
});

// array_values() is used to reset the keys of the array
echo json_encode(array_values($filteredAirports));