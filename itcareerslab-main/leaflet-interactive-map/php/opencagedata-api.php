<?php
$apiKey = 'f4157baa893043db8384c145f3cfde6d';
$query = urlencode($_GET['query']);

$url = "https://api.opencagedata.com/geocode/v1/json?q={$query}&key={$apiKey}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>