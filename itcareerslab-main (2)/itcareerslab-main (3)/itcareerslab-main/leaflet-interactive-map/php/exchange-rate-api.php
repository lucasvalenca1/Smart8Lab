<?php
$apiKey = '9ec9e68884ff42e79cd02100874477b0';

$url = "https://openexchangerates.org/api/latest.json?app_id={$apiKey}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
