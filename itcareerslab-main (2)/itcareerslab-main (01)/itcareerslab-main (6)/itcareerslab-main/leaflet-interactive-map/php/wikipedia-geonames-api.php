<?php
	require_once 'apikeys.php';
	//ini_set('display_errors', 'On');
	//error_reporting(E_ALL);
	
	$wikipediaUrl = "http://api.geonames.org/wikipediaSearchJSON?formatted=true&q=country+" . urlencode($_REQUEST['place_name']) . "&maxRows=1&username=" . GEONAMES_API_KEY . "&style=full";
	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_URL,$wikipediaUrl); 
	$result=curl_exec($ch); 
	curl_close($ch); 

	echo $result;

?>
