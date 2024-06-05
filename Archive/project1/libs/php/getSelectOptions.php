<?php

	$data = file_get_contents('../json/countryBorders.geo.json');

	$decode = json_decode($data, true);	
	$countriesArray = $decode['features'];
	$countryList = [];
		foreach($countriesArray as $country) {
			if($country['properties']['iso_a2'] != -99){
				array_push($countryList, [$country['properties']['name'], $country['properties']['iso_a2']]);
			}	
		}

	function compareByName($a, $b) {
		return strcmp($a[0], $b[0]);
		}
		usort($countryList, 'compareByName');

	$output['status']['code'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "success";
	$output['status']['returnedIn'] = intval((microtime(true) - $executionStartTime) * 1000) . " ms";
	$output['result'] = $countryList;

	header('Content-Type: application/json; charset=UTF-8');

	echo json_encode($output); 

?>
  