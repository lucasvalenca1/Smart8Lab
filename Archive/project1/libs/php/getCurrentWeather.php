<?php

	// remove for production

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	$executionStartTime = microtime(true);

	$url='http://dataservice.accuweather.com/currentconditions/v1/' . $_REQUEST['capitalKey'] . '?apikey=Em3S1AXJydUJwVKZrz0PlGfilF59Csjq';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);

	$result=curl_exec($ch);

	curl_close($ch);

	$decode = json_decode($result, true);	
	$capitalTemp = $decode['0']['Temperature']['Metric']['Value'];
	$currentCondition = $decode['0']['WeatherText'];
	$currentWeatherIcon = $decode['0']['WeatherIcon'];
	

	$output['status']['code'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "success";
	$output['status']['returnedIn'] = intval((microtime(true) - $executionStartTime) * 1000) . " ms";
	$output['capitalTemp'] = $capitalTemp;
	$output['currentCondition'] = $currentCondition;
	$output['currentWeatherIcon'] = $currentWeatherIcon;
	
	
	
	header('Content-Type: application/json; charset=UTF-8');

	echo json_encode($output); 

?>
