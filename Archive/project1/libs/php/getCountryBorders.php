<?php

	$data = file_get_contents('../json/countryBorders.geo.json');


	$decode = json_decode($data, true);	

	$selectedCountryIso = $_REQUEST['countryIso'];

	$countriesArray = $decode['features'];

	$countryCoordinates = [];

	foreach($countriesArray as $country) {

		$countryIso = $country['properties']['iso_a2'];

		if($selectedCountryIso == $countryIso){
			$countryCoordinates = $country;
		}	
	}

	$output['status']['code'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "success";
	$output['status']['returnedIn'] = intval((microtime(true) - $executionStartTime) * 1000) . " ms";
	$output['result'] = $countryCoordinates;


	header('Content-Type: application/json; charset=UTF-8');

	echo json_encode($output); 

?>
