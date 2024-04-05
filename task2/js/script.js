$("#searchPlaceNameWikipediaBtn").click(function () {
  $.ajax({
    url: "php/wikipedia-search-api.php",
    type: "POST",
    dataType: "json",
    data: {
      place_name: $("#placeNameInput").val(),
    },
    success: function (result) {
      console.log(JSON.stringify(result));

      if (result.status.name == "ok") {
        $("#output").html(JSON.stringify(result["data"]));
        // $("#output").html(JSON.stringify({name: result["data"][0]["thumbnailImg"]}));
        // $("#txtContinent").html(result["data"][0]["thumbnailImg"])
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("error" + JSON.stringify(jqXHR));
      $("#output").html("No information found. Please try another value.");
    },
  });
});

$("#postCodeSearchBtn").click(function () {
  $.ajax({
    url: "php/postalcode-api.php",
    type: "POST",
    dataType: "json",
    data: {
      postal_code: $("#postalcodeInput").val(),
    },
    success: function (result) {
      console.log(JSON.stringify(result));

      if (result.status.name == "ok") {
        $("#output").html(JSON.stringify(result["data"]));
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("error" + JSON.stringify(jqXHR));
      $("#output").html("No information found. Please try another value.");
    },
  });
});

$("#timezoneSearchBtn").click(function () {
  $.ajax({
    url: "php/timezone-api.php",
    type: "POST",
    dataType: "json",
    data: {
      latitude: $("#latitudeInput").val(),
      longitude: $("#longitudeInput").val(),
    },
    success: function (result) {
      console.log(JSON.stringify(result));

      if (result.status.name == "ok") {
        $("#output").html(JSON.stringify(result["data"]));
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("error" + JSON.stringify(jqXHR));
      $("#output").html("No information found. Please try another value.");
    },
  });
});

var map = L.map("map").setView([51.505, -0.09], 13);

// Add a tile layer to the map
L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19,
  attribution:
    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

// Add a marker to the map
var marker = L.marker([51.5, -0.09]).addTo(map);

// Add a circle to the map
var circle = L.circle([51.508, -0.11], {
  color: "red",
  fillColor: "#f03",
  fillOpacity: 0.5,
  radius: 500,
}).addTo(map);

// Add a polygon to the map
var polygon = L.polygon([
  [51.509, -0.08],
  [51.503, -0.06],
  [51.51, -0.047],
]).addTo(map);
$(window).on("load", function () {
  if ($("#preloader").length) {
    $("#preloader")
      .delay(1000)
      .fadeOut("slow", function () {
        $(this).remove();
      });
  }
});

// Initialize the map
let map = L.map("map").setView([0, 0], 2);

// Add a tile layer (replace with your preferred tile provider)
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

// Get the user's current location
navigator.geolocation.getCurrentPosition((position) => {
  const { latitude, longitude } = position.coords;
  // Update the map view with the user's location
  map.setView([latitude, longitude], 8);

  // Make an AJAX call to a PHP script to get the country data
  $.ajax({
    url: "get_country_data.php",
    type: "POST",
    data: { latitude, longitude },
    success: (data) => {
      // Handle the response data
      console.log(data);
    },
  });
});

// Populate the country select options
$.ajax({
  url: "get_countries.php",
  type: "GET",
  success: (data) => {
    $("#countrySelect").html(data);
  },
});
var map = L.map("map").setView([51.505, -0.09], 13);

var map = L.map("map", {
  center: [51.505, -0.09],
  zoom: 13,
});
