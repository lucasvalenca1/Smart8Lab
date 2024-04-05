<?php
// Load the countryBorders.geo.json file
$json = file_get_contents('countryBorders.geo.json');
$data = json_decode($json, true);

// Loop through the countries and create options for the select
$options = '';
foreach ($data['features'] as $feature) {
  $countryCode = $feature['properties']['ISO_A3'];
  $countryName = $feature['properties']['NAME'];
  $options .= "<option value='$countryCode'>$countryName</option>";
}

echo $options;
