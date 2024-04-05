<?php
// fetchi weather data and returning a JSON response

$data = [
    ["lat" => 51.510357, "lng" => -0.116773, "popupContent" => "Marker 1 Content From the Backend"],
    // Add more markers with content
];

echo json_encode($data);