<?php
require_once __DIR__ . '/config.php';
$selectedCountry = $_GET['countryIso'];
$apiKey = WORLDNEWS_API_KEY;
$url = "https://newsapi.org/v2/top-headlines?country=$selectedCountry&apiKey=$apiKey";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Set the User-Agent header
$userAgent = "YourAppName/1.0";
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "User-Agent: $userAgent"
));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
