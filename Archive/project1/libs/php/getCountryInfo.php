<?php

	// remove for production

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	$executionStartTime = microtime(true);

	$url='http://api.geonames.org/countryInfoJSON?formatted=true&country=' . $_REQUEST['countryIso'] . '&username=cassiofortunato&style=full';

	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);

	$result=curl_exec($ch);

	curl_close($ch);

	$decode = json_decode($result,true);	

	$countryInfo = $decode['geonames'][0];

	$output['status']['code'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "success";
	$output['status']['returnedIn'] = intval((microtime(true) - $executionStartTime) * 1000) . " ms";
	$output['capital'] = $countryInfo['capital'];
	$output['population'] = $countryInfo['population'];
	$output['currencyCode'] = $countryInfo['currencyCode'];
	
	header('Content-Type: application/json; charset=UTF-8');

	echo json_encode($output); 

?>
