<?php
// Get the latitude and longitude from the AJAX request
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Use the OpenCage Geocoder API to get the country data
$url = "https://api.opencagedata.com/geocode/v1/json?q=$latitude,$longitude&key=YOUR_API_KEY";
$response = file_get_contents($url);
$data = json_decode($response, true);

// Extract the relevant country data
$countryData = [
  'name' => $data['results'][0]['components']['country'],
  'capital' => $data['results'][0]['components']['city'],
  // Add more data as needed
];

// Return the country data as JSON
echo json_encode($countryData);
