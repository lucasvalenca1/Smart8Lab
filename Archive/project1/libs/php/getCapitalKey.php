<?php

	// remove for production

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	$executionStartTime = microtime(true);

	$url='http://dataservice.accuweather.com/locations/v1/cities/' . $_REQUEST['selectedCountryIso'] . '/search?apikey=Em3S1AXJydUJwVKZrz0PlGfilF59Csjq&q=' . $_REQUEST['countryCapital'];




	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);

	$result=curl_exec($ch);

	curl_close($ch);

	$decode = json_decode($result, true);	
	$capitalKey = $decode['0']['Key'];

	$output['status']['code'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "success";
	$output['status']['returnedIn'] = intval((microtime(true) - $executionStartTime) * 1000) . " ms";
	$output['capitalKey'] = $capitalKey;
	
	
	
	header('Content-Type: application/json; charset=UTF-8');

	echo json_encode($output); 

?>
