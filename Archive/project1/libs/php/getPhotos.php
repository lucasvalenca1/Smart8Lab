<?php

	// remove for production

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	$executionStartTime = microtime(true);

	$url='https://api.unsplash.com/search/photos?page=1&query=' . $_REQUEST['countryCapital'] . '&client_id=tENyE3mWbs-wyKHDWG2xOUVlpST-UvrqK_XzOBKIiUU';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);

	$result=curl_exec($ch);

	curl_close($ch);

	$decode = json_decode($result, true);	

	

	$output['status']['code'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "success";
	$output['status']['returnedIn'] = intval((microtime(true) - $executionStartTime) * 1000) . " ms";
	$output['pictures'] = $decode['results'];

	
	
	
	header('Content-Type: application/json; charset=UTF-8');

	echo json_encode($output); 

?>
