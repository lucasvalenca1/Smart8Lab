$(document).ready(function () {
  // Initialize the map next to the Big Ben
  var map = L.map("map").setView([51.510357, -0.116773], 13);
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
      '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  }).addTo(map);

  var markers = L.markerClusterGroup();

  // Simulate fetching data with AJAX from a PHP script
  fetch("php/geo-api.php")
    .then((response) => response.json())
    .then((data) => {
      // Assuming data is an array of {lat, lng, popupContent}
      data.forEach((item) => {
        var marker = L.marker([item.lat, item.lng]).bindPopup(
          item.popupContent
        );
        markers.addLayer(marker);
      });
      map.addLayer(markers);
      map.fitBounds(markers.getBounds());
    })
    .catch((error) => console.log("Error:", error));

  // TO-DO Add more features, custom buttons
});
