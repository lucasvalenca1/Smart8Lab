var shouldUpdateMapView = false; // Global flag
let isoCodeToCountryName = {}; // Global mapping of ISO codes to country names

$(document).ready(function () {
  let currentGeoJSONLayer = null;

  var streets = L.tileLayer(
    "https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}",
    {
      attribution:
        "Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012",
    }
  );

  var satellite = L.tileLayer(
    "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
    {
      attribution:
        "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community",
    }
  );
  var basemaps = {
    Streets: streets,
    Satellite: satellite,
  };

  let map = L.map("map", {
    layers: [streets]
  }).setView([51.510357, -0.116773], 13);

  var layerControl = L.control.layers(basemaps).addTo(map);

  L.easyButton("fa-info", function (btn, map) {
    $("#exampleModal").modal("show");
  }).addTo(map);

  let markers = L.markerClusterGroup();

  if (navigator.geolocation && shouldUpdateMapView) {
 
    navigator.geolocation.getCurrentPosition(
      function (position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        map.setView([lat, lng], 13);

        const marker = L.marker([lat, lng]).bindPopup("Your current location");
        markers.addLayer(marker);
        map.addLayer(markers);
        marker.openPopup();

        shouldUpdateMapView = false; 

        // map.fitBounds() adjust the map view to ensure that all markers within the specified bounds are visible on the screen
        // map.fitBounds(markers.getBounds());

       // Prevent map view from being updated again
      },
      function (error) {
        console.log("Error getting location", error);
      }
    );
  }

  fetch("php/countries-api.php")
    .then((response) => response.json())
    .then((countries) => {

      countries.sort((a, b) => a.name.localeCompare(b.name));

      countries.forEach((country) => {
        $("#countrySelect").append(new Option(country.name, country.iso_a3));

        isoCodeToCountryName[country.iso_a3] = country.name;
      });
    });

  $("#countrySelect").change(function () {
    const isoCode = $(this).val();
    const countryName = $(this).find("option:selected").text();

    fetchCountryBorder(isoCode);
    fetchCountryDetails(countryName);

    $("#infoPanel").empty();
  });

  function fetchCountryBorder(isoCode) {
    fetch(`php/countries-api.php?iso=${isoCode}`)
      .then((response) => response.json())
      .then((data) => {
        if (data && data.geometry) {
          if (currentGeoJSONLayer) {
            map.removeLayer(currentGeoJSONLayer);
          }
          currentGeoJSONLayer = L.geoJSON(data.geometry, {
            onEachFeature: function (feature, layer) {
              layer.on("click", function () {
                
                const countryName = isoCodeToCountryName[isoCode];

                if (countryName) {
                  fetchCountryDetails(countryName);
                } else {
                  console.error(
                    "Country name not found for ISO code:",
                    isoCode
                  );
                }
              });
            }
          }).addTo(map);
          map.fitBounds(currentGeoJSONLayer.getBounds());
        }
      });
  }

  function fetchCountryDetails(countryName) {
    fetch(`php/opencagedata-api.php?query=${encodeURIComponent(countryName)}`)
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            `Failed to fetch geocode data: ${response.statusText}`
          );
        }
        return response.text().then((text) => (text ? JSON.parse(text) : {}));
      })
      .then((geocodeData) => {
        if (!geocodeData.results || geocodeData.results.length === 0) {
          throw new Error("Geocode data is empty or malformed");
        }
        const coords = geocodeData.results[0].geometry;
        return Promise.all([
          fetch(`php/weather-api.php?lat=${coords.lat}&lon=${coords.lng}`).then(
            (resp) => {
              if (!resp.ok) {
                throw new Error(
                  `Failed to fetch weather data: ${resp.statusText}`
                );
              }
              return resp.text().then((text) => (text ? JSON.parse(text) : {}));
            }
          ),
          fetch("php/exchange-rate-api.php").then((resp) => {
            if (!resp.ok) {
              throw new Error(
                `Failed to fetch exchange rate data: ${resp.statusText}`
              );
            }
            return resp.text().then((text) => (text ? JSON.parse(text) : {}));
          }),
          fetch(
            `php/wikipedia-geonames-api.php?place_name=${encodeURIComponent(
              countryName
            )}`
          ).then((resp) => {
            if (!resp.ok) {
              throw new Error(
                `Failed to fetch Wikipedia data: ${resp.statusText}`
              );
            }
            return resp.text().then((text) => (text ? JSON.parse(text) : {}));
          }),
        ]).then(([weatherData, exchangeRateData, wikipediaData]) => {
          return { geocodeData, weatherData, exchangeRateData, wikipediaData };
        });
      })
      .then(({ geocodeData, weatherData, exchangeRateData, wikipediaData }) => {
        const details = {
          geocode: geocodeData.results[0],
          weather: weatherData,
          exchangeRate: exchangeRateData,
          wikipedia: wikipediaData.geonames ? wikipediaData.geonames[0] : null, // Adding null check for geonames
        };
        updateUI(details);
      })
      .catch((error) => {
        console.error("Error fetching country details:", error.message);
      });
  }

  function updateUI(data) {
      let annotations = data.geocode.annotations;
      let currency = annotations.currency;
      let timezone = annotations.timezone;
      let weather = data.weather;
      let exchangeRate = data.exchangeRate;
      let wikipedia = data.wikipedia;

      // Assuming the flag is provided as an emoji, wrap it in a span with a class for styling
      let flagHtml = `<span class="flag-large">${annotations.flag}</span>`;

      // Construct the URL for the weather icon
      let weatherIconUrl = `http://openweathermap.org/img/wn/${weather.weather[0].icon}.png`;

      let infoHTML = `
      ${flagHtml}
      <p>Timezone: ${timezone.name} (UTC ${timezone.offset_string})</p>
      <p>Currency: ${currency.name} (${currency.symbol})</p>
      <p>Drive on: ${annotations.roadinfo.drive_on}, Speed in: ${
        annotations.roadinfo.speed_in
      }</p>
      <p>Geohash: ${annotations.geohash}</p>
      <p>Current Weather: <img src="${weatherIconUrl}" alt="Weather icon" style="vertical-align: middle;"> ${
        weather.weather[0].description
      }, Temp: ${weather.main.temp}°C</p>
      <p>Exchange Rate to USD: ${exchangeRate.rates[currency.iso_code]} (1 ${
        currency.iso_code
      } to USD)</p>
      <p><a href="${
        annotations.OSM.url
      }" target="_blank">OpenStreetMap Details</a></p>
    `;

    if (wikipedia) {
      infoHTML += `
      <h3>Wikipedia Summary</h3>
      <p>${wikipedia.title}: ${wikipedia.summary}</p>
      <p><a href="https://${wikipedia.wikipediaUrl}" target="_blank">Read more on Wikipedia</a></p>
    `;
    }

    let infoPanel = document.getElementById("infoPanel");
    infoPanel.innerHTML = infoHTML;

    countryName.innerHTML = data.geocode.formatted;

    let infoModal = new bootstrap.Modal(document.getElementById("infoModal"));
    infoModal.show();
  }
});
