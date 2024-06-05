<?php
$json_data = file_get_contents('data/countryBorders.geo.json');
$data = json_decode($json_data, true);

// Check if an ISO code was provided to return just the borders for that country
if (isset($_GET['iso'])) {
    $iso_code = $_GET['iso'];
    $border = array_values(array_filter($data['features'], function ($feature) use ($iso_code) {
        return $feature['properties']['iso_a3'] === $iso_code;
    }));
    header('Content-Type: application/json');
    echo json_encode($border ? $border[0] : null);
} else {
    // No ISO code provided, return the list of countries
    $countries = array_map(function ($feature) {
        return array(
            'iso_a3' => $feature['properties']['iso_a3'],
            'name' => $feature['properties']['name']
        );
    }, $data['features']);

    header('Content-Type: application/json');
    echo json_encode($countries);
}
?>