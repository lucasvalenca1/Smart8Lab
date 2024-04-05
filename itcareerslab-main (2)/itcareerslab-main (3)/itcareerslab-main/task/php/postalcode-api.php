<?php

	// remove for production
	//ini_set('display_errors', 'On');
	//error_reporting(E_ALL);

	$executionStartTime = microtime(true);
	
	$postcodeUrl = "http://api.geonames.org/postalCodeSearchJSON?formatted=true&postalcode=" . $_REQUEST['postal_code'] . "&maxRows=10&username=lucasdvalenca002&style=full";

	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_URL,$postcodeUrl); 
	$result=curl_exec($ch); 
	curl_close($ch); 

	$decode = json_decode($result,true); 

	$output['status']['code'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "success";
	$output['status']['returnedIn'] = intval((microtime(true) - $executionStartTime) * 1000) . " ms";
	$output['data'] = $decode['postalCodes'];
	
	header('Content-Type: application/json; charset=UTF-8');

	echo json_encode($output); 

?>