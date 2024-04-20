<?php
require_once __DIR__ . '/config.php';

$demographics = "http://api.geonames.org/countryInfoJSON?formatted=true&country=" . $_REQUEST['country_iso_code'] . "&username=" . GEONAMES_API_KEY . "&style=full";

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $demographics);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
