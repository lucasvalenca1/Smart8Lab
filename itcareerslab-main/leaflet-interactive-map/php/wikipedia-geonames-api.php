<?php
	//ini_set('display_errors', 'On');
	//error_reporting(E_ALL);

	$username = 'lucasdvalenca002';

	$executionStartTime = microtime(true);
	
	$wikipediaUrl = "http://api.geonames.org/wikipediaSearchJSON?formatted=true&q=" . $_REQUEST['place_name'] . "&maxRows=10&username=" . $username . "&style=full";

	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_URL,$wikipediaUrl); 
	$result=curl_exec($ch); 
	curl_close($ch); 

	echo $result;

?>
