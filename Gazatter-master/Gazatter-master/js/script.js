function formatDate (dateString) {
  const date = new Date(dateString)

  const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
  const months = [
    'Jan',
    'Feb',
    'Mar',
    'Apr',
    'May',
    'Jun',
    'Jul',
    'Aug',
    'Sep',
    'Oct',
    'Nov',
    'Dec'
  ]

  const dayOfWeek = days[date.getDay()]

  const dayOfMonth = date.getDate()
  const month = months[date.getMonth()]

  // Adding suffix to the day of the month
  let daySuffix
  if (dayOfMonth === 1 || dayOfMonth === 21 || dayOfMonth === 31) {
    daySuffix = 'st'
  } else if (dayOfMonth === 2 || dayOfMonth === 22) {
    daySuffix = 'nd'
  } else if (dayOfMonth === 3 || dayOfMonth === 23) {
    daySuffix = 'rd'
  } else {
    daySuffix = 'th'
  }

  return `${dayOfWeek}, ${dayOfMonth}${daySuffix} ${month}`
}

function formatDateTime (originalTime) {
  // Parse the original UTC time
  const parsedTime = new Date(originalTime)

  // Function to get the correct day suffix
  function getDaySuffix (day) {
    if (day >= 4 && day <= 20) return 'th'
    switch (day % 10) {
      case 1:
        return 'st'
      case 2:
        return 'nd'
      case 3:
        return 'rd'
      default:
        return 'th'
    }
  }

  // Formatting the parsed time
  const options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
    hour12: true,
    timeZone: 'UTC'
  }
  let formattedTime = parsedTime.toLocaleString('en-US', options)

  // Adding the day suffix
  const day = parsedTime.getUTCDate()
  const suffix = getDaySuffix(day)
  formattedTime = formattedTime.replace(day, `${day}${suffix}`)

  return formattedTime
}

var shouldUseCurrentUserLocation = true // Global flag
var currentGeoJSONLayer = null // Global reference to the current GeoJSON layer

/**
 * Country Data object contains:
 * exchangeRate
 * geocode
 * weather
 * wikipedia
 */
var countryData = {} // Global mapping of country data
var isoCodeToCountryName = {} // Global mapping of ISO codes to country names
var map // Global reference to the Leaflet map

var streets = L.tileLayer(
  'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}',
  {
    attribution:
      'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012'
  }
)

var satellite = L.tileLayer(
  'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
  {
    attribution:
      'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
  }
)
var basemaps = {
  Streets: streets,
  Satellite: satellite
}

let markers = L.markerClusterGroup()
/**
 * EasyButton is a plugin for Leaflet that allows you to add custom buttons to the map.
 */
var demographicsInfoBtn = L.easyButton(
  'fa-solid fa-info fa-beat-fade',
  function (btn, map) {
    if (countryData.demographics) {
      updateDemographicsModal(countryData.demographics)
      $('#demographicsInfoModal').modal('show')
    } else {
      console.error('Demographics data is not available.')
    }

    $('#demographicsInfoModal').modal('show')
  }
)

var weatherForecastBtn = L.easyButton('fa-solid fa-cloud', function (btn, map) {
  const selectElement = document.getElementById('countrySelect')

  const selectedCountry = selectElement.value
  const coords = map.getCenter()
  let weatherHtml = ''
  $('#weatherForecastModal').modal('show')
  document.getElementById('loadingSpinner').style.display = 'block'
  fetch(`php/weather-api.php?country=${selectedCountry}`)
    .then(response => {
      if (!response.ok) {
        throw new Error(`Failed to fetch weather data: ${response.statusText}`)
      }
      return response.json()
    })

    .then(data => {
      const maxTempCurrent = data.forecast.forecastday[0].day.maxtemp_c
      const minTempCurrent = data.forecast.forecastday[0].day.mintemp_c
      const textCurrent = data.forecast.forecastday[0].day.condition.text
      const iconCurrent = data.forecast.forecastday[0].day.condition.icon
      const tomorrowDate = data.forecast.forecastday[1].date
      const maxTempTomorrow = data.forecast.forecastday[1].day.maxtemp_c
      const minTempTomorrow = data.forecast.forecastday[1].day.mintemp_c
      const iconTomorrow = data.forecast.forecastday[1].day.condition.icon
      const nextTomorrowDate = data.forecast.forecastday[2].date
      const nextMaxTempTomorrow = data.forecast.forecastday[2].day.maxtemp_c
      const nextMinTempTomorrow = data.forecast.forecastday[2].day.mintemp_c
      const nextIconTomorrow = data.forecast.forecastday[2].day.condition.icon

      weatherHtml = `<div class="container mt-5">
  <div class="row">
    <div class="col-12">
      <div class="card weather-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
              <h5 class="card-title">TODAY</h5>
              <p class="card-text fw-bold">${textCurrent}</p>
            </div>

            <div class="weather-icon flex-grow-1"><img src= ${iconCurrent} /></div>

            <div class="">
              <div class="temperature fw-bold">${maxTempCurrent}ºC</div>
              <div class="text-muted">${minTempCurrent}ºC</div>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-md-6">
      <div class="card weather-card">
        <div class="card-body">
          <h5 class="card-title fw-bold">${formatDate(tomorrowDate)}</h5>
          <div class="d-flex justify-content-between">
            <div class="temperature">
              <div class="temperature fw-bold">${maxTempTomorrow}ºC</div>
              <div class="text-muted">${minTempTomorrow}ºC</div>
            </div>
            <div class="weather-icon"><img src=${iconTomorrow}  alt=${iconTomorrow}/></div>
          </div>

        </div>
      </div>
    </div>

    <div class="col-md-6">
    <div class="card weather-card">
      <div class="card-body">
        <h5 class="card-title fw-bold">${formatDate(nextTomorrowDate)}</h5>
        <div class="d-flex justify-content-between">
          <div class="temperature-container">
            <div class="temperature fw-bold">${nextMaxTempTomorrow}ºC</div>
            <div class="text-muted">${nextMinTempTomorrow}ºC</div>
          </div>
          <div class="weather-icon "><img src="${nextIconTomorrow}" alt="${nextIconTomorrow}"/></div>
        </div>

      </div>
    </div>
  </div>

    
  </div>
</div>`

      $('#weatherForecastModal .modal-body').html(weatherHtml)

      $('#weatherForecastModal').modal('show')
    })
    .catch(error => {
      console.error('Error fetching weather data:', error)
      // TO-DO show a default error message in the modal
    })
    .finally(() => {
      // Hide the loading spinner
      if (document.getElementById('loadingSpinner')) {
        document.getElementById('loadingSpinner').style.display = 'none'
      }
    })
})

var currencyExchangeBtn = L.easyButton(
  'fa-solid fa-dollar-sign',
  function (btn, map) {
    document.getElementById('conversion-result').textContent = ''

    populateCurrencySelect()

    $('#currencyExchangeModal').modal('show')
  }
)

function updateDemographicsModal (demographics) {
  const attributes = [
    {
      icon: 'fa-street-view',
      name: 'Country Code',
      value: demographics.countryCode
    },
    {
      icon: 'fa-heart',
      name: 'Country Name',
      value: demographics.countryName
    },
    {
      icon: 'fa-car',
      name: 'Continent',
      value: demographics.continentName
    },
    { icon: 'fa-book', name: 'Capital', value: demographics.capital },
    {
      icon: 'fa-bath',
      name: 'Area (sq km)',
      value: demographics.areaInSqKm
    },
    { icon: 'fa-bell', name: 'Population', value: demographics.population },
    {
      icon: 'fa-anchor',
      name: 'Currency Code',
      value: demographics.currencyCode
    },
    {
      icon: 'fa-money-bill',
      name: 'Languages',
      value: demographics.languages
    },
    {
      icon: 'fa-globe',
      name: 'ISO Numeric',
      value: demographics.isoNumeric
    },
    { icon: 'fa-tree', name: 'ISO Alpha-3', value: demographics.isoAlpha3 }
    // Add more mappings as needed based on your API response structure
  ]

  // Select the modal body where the table is located
  const modalBody = document.querySelector('#demographicsInfoModal .modal-body')
  // Clear existing content
  modalBody.innerHTML = ''

  // Create a new table
  const table = document.createElement('table')
  table.className = 'table table-striped'

  // Iterate over each attribute and create a row for it
  attributes.forEach(attr => {
    if (attr.value) {
      // Only add rows for attributes with values
      const row = document.createElement('tr')

      // Icon cell
      const iconTd = document.createElement('td')
      iconTd.className = 'text-center'
      iconTd.innerHTML = `<i class="fa-solid ${attr.icon} fa-xl text-success"></i>`
      row.appendChild(iconTd)

      // Name cell
      const nameTd = document.createElement('td')
      nameTd.textContent = attr.name
      row.appendChild(nameTd)

      // Value cell
      const valueTd = document.createElement('td')
      valueTd.className = 'text-end'
      valueTd.textContent = attr.value
      row.appendChild(valueTd)

      // Append the row to the table
      table.appendChild(row)
    }
  })

  // Append the table to the modal body
  modalBody.appendChild(table)
}

function populateCurrencySelect () {
  const currencySelect = document.getElementById('currency-select')
  currencySelect.innerHTML = '' // Clear the select element

  // Check if the target currencuy is in the exchangeRate.rates
  if (
    countryData.exchangeRate.rates.hasOwnProperty(
      countryData.geocode.annotations.currency.iso_code
    )
  ) {
    const option = document.createElement('option')
    option.value = countryData.geocode.annotations.currency.iso_code
    option.text = countryData.geocode.annotations.currency.iso_code
    currencySelect.appendChild(option)
  } else {
    console.log('Currency not found in exchange rates')
  }
}

var breakingNewsWikipediaBtn = L.easyButton(
  'fa-brands fa-wikipedia-w',
  function (btn, map) {
    console.log(countryData.wikipedia)

    if (!countryData.wikipedia || countryData.wikipedia.length === 0) {
      document.getElementById(
        'wikipediaModalBody'
      ).innerHTML = `<p>No Wikipedia data found for ${countryData.countryName}.</p>`
    } else {
      const contentHtml = `
            <h4>${countryData.wikipedia.title}</h4>
            <p>${countryData.wikipedia.summary}</p>
            <p><a href="https://${
              countryData.wikipedia.wikipediaUrl
            }" target="_blank">Read more on Wikipedia</a></p>
            ${
              countryData.wikipedia.thumbnailImg
                ? `<img src="${countryData.wikipedia.thumbnailImg}" alt="${countryData.wikipedia.title}" style="width:25%;">`
                : ''
            }
      `

      document.getElementById(
        'wikipediaModalTitle'
      ).innerText = `Wikipedia Info`
      document.getElementById('wikipediaModalBody').innerHTML = contentHtml
    }

    $('#breakingNewsWikipediaModal').modal('show')
  }
)

const countryImagesBtn = L.easyButton(
  'fa-solid fa-newspaper',
  function (btn, map) {
    // TODO Implement the solution
    const selectElement = document.getElementById('countrySelect')
    let worldNewHtml = ''
    const selectedCountryIso = selectElement.value.slice(0, 2)

    fetch(`php/world-new-api.php?countryIso=${selectedCountryIso}`)
      .then(response => {
        if (!response.ok) {
          throw new Error(
            `Failed to fetch weather data: ${response.statusText}`
          )
        }
        return response.json()
      })
      .then(data => {
        console.log(data)

        if (data?.articles.length === 0) {
          // document.getElementById('loadingSpinner2').style.display = 'none'
          worldNewHtml = '<p>Data not available for this country</p>'
        }

        data.articles.slice(0, 4).forEach(article => {
          worldNewHtml += `
 <article class="news-card">
  <div class="news-title">
     <h6 class="fw-bold">${article.title} - ${article.source.name}</h6>
  </div>
  <div class="d-flex justify-content-between mt-4">
    <div class="news-timestamp">
      <span class="text-muted">${formatDateTime(
        article.publishedAt
      ).toLocaleString()}</span>
    </div>
    <div>
      <a href="${
        article.url
      }" class="read-more" target="_blank">Read More...</a>
    </div>
  </div>

</article>
<hr />
      `
        })
        $('#countryImagesModal .modal-body').html(worldNewHtml)

        $('#countryImagesModal').modal('show')
      })
      .catch(error => {
        console.log(error)
      })
  }
)

$(document).ready(function () {
  if (navigator.geolocation && shouldUseCurrentUserLocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        const lat = position.coords.latitude
        const lng = position.coords.longitude

        if (shouldUseCurrentUserLocation) {
          fetchCountryDataFromCoords(lat, lng)

          map.setView([lat, lng], 13)

          const marker = L.marker([lat, lng]).bindPopup('Your current location')
          markers.addLayer(marker)
          map.addLayer(markers)
          marker.openPopup()

          // Prevent future auto-centering on the user's location
          shouldUseCurrentUserLocation = false
        }
      },
      function (error) {
        console.log('Error getting current location from Browser', error)
      }
    )
  }

  /**
   * Create the map and set the initial view to London.
   */
  map = L.map('map', {
    layers: [streets]
  }).setView([51.510357, -0.116773], 13)

  // URL of the JSON file (relative path)
  const url = 'php/data/airlabs_airports_cities_mock_data.json' // Adjust the path according to your project structure

  let center = map.getCenter()

  fetchCountryDataFromCoords(center.lat, center.lng)

  /**
   * This function fetches the country data using the OpenCageData API.
   * It then fetches the country details using the country name and ISO code.
   * The country details include weather, exchange rate, Wikipedia, and demographics data.
   * @param {*} lat
   * @param {*} lng
   */
  function fetchCountryDataFromCoords (lat, lng) {
    fetch(`php/opencagedata-api.php?lat=${lat}&lng=${lng}`)
      .then(response => response.json())
      .then(data => {
        // Assuming the API returns data, you might need to adjust based on the actual response structure
        if (data && data.results && data.results.length > 0) {
          const result = data.results[0]
          const countryName = result.components.country

          fetchCountryDetailsByCountryName(
            countryName,
            result.components['ISO_3166-1_alpha-2']
          )
        }
      })
      .catch(error => console.log('Error fetching country data:', error))
  }

  /**
   * Add the basemaps to the map.
   * The user can switch between the Streets and Satellite basemaps.
   * The Streets basemap is the default.
   */
  layerControl = L.control.layers(basemaps).addTo(map)

  /**
   * Add the custom buttons to the map using the EasyButton plugin.
   */
  demographicsInfoBtn.addTo(map)
  weatherForecastBtn.addTo(map)
  currencyExchangeBtn.addTo(map)
  breakingNewsWikipediaBtn.addTo(map)
  countryImagesBtn.addTo(map)

  /**
   * Create a marker cluster group to hold the airport markers.
   * This will allow the user to see the number of airports in a cluster.
   * When the user zooms in, the cluster will break apart to show individual markers.
   * When the user zooms out, the cluster will re-form to show the number of airports in that area.
   * The markers are added to the map after fetching the airport data.
   * The map is then zoomed to fit the bounds of all the markers.
   * The markers are cleared when the user selects a different country from the dropdown.
   */

  /**
   * Fetch the list of countries from the API and populate the dropdown.
   * Also, create a mapping of ISO codes to country names.
   * This mapping will be used to display the country name in the info panel.
   */
  fetch('php/countries-api.php')
    .then(response => response.json())
    .then(countries => {
      // Sort the countries alphabetically by name
      countries.sort((a, b) => a.name.localeCompare(b.name))

      countries.forEach(country => {
        $('#countrySelect').append(new Option(country.name, country.iso_a3))

        isoCodeToCountryName[country.iso_a3] = country.name
      })
    })

  /**
   * Event listener for the country dropdown.
   * When the user selects a country, the map is centered on that country.
   * The country's border is fetched and displayed on the map.
   * The airports in that country are fetched and displayed on the map.
   * The map is then zoomed to fit the bounds of all the markers.
   * The markers are cleared when the user selects a different country from the dropdown.
   */
  $('#countrySelect').change(function () {
    const isoCode = $(this).val()
    const isoCodeAlpha2 = isoCode.substring(0, 2)
    const countryName = $(this).find('option:selected').text()

    // Clear the map of any existing markers
    markers.clearLayers()

    fetchCountryBorder(isoCode)
    fetchCountryDetailsByCountryName(countryName, isoCodeAlpha2)
    airlabsAPI(isoCodeAlpha2)
    citiesApi(isoCodeAlpha2)
  })

  /**
   * This function fetches the border of a country using its ISO code.
   * It then adds a GeoJSON layer to the map with the country's border.
   * The map is then zoomed to fit the country's border.
   * @param {*} isoCode
   */
  function fetchCountryBorder (isoCode) {
    fetch(`php/countries-api.php?iso=${isoCode}`)
      .then(response => response.json())
      .then(data => {
        if (data && data.geometry) {
          shouldUseCurrentUserLocation = false

          if (currentGeoJSONLayer) {
            map.removeLayer(currentGeoJSONLayer)
          }

          // Style for the GeoJSON layer
          const geoJsonStyle = {
            color: '#005073',
            weight: 3,
            fillColor: '#189ad3',
            fillOpacity: 0.5
          }

          /**
           * Create a GeoJSON layer with the country's border.
           * (disabled) Add a click event to the GeoJSON layer.
           * (disabled) When the user clicks on the country's border, the country's details are fetched.
           * The map is then zoomed to fit the country's border.
           */
          currentGeoJSONLayer = L.geoJSON(data.geometry, {
            style: geoJsonStyle
            // Add a click event to the GeoJSON layer
            // onEachFeature: function (feature, layer) {
            //   layer.on("click", function () {
            //     const countryName = isoCodeToCountryName[isoCode];
            //     if (countryName) {
            //       fetchCountryDetailsByCountryName(countryName);
            //     } else {
            //       console.error(
            //         "Country name not found for ISO code:",
            //         isoCode
            //       );
            //     }
            //   });
            // },
          }).addTo(map)
          map.fitBounds(currentGeoJSONLayer.getBounds())
        }
      })
      .catch(error => {
        console.log(error)
      })
  }

  function updateCountryData (selectedCountryData) {
    countryData = selectedCountryData
  }

  document.getElementById('convert').addEventListener('click', function () {
    const amount = document.getElementById('amount').value
    const currency = document.getElementById('currency-select').value
    const conversionResult = document.getElementById('conversion-result')

    if (amount && currency) {
      const result = convertCurrency(amount, currency)

      conversionResult.textContent = `${amount} ${currency} is approximately ${result.toFixed(
        2
      )} USD`
    } else {
      conversionResult.textContent =
        'Please enter an amount and select a currency'
    }
  })

  function convertCurrency (amount, currency) {
    return amount * countryData.exchangeRate.rates[currency]
  }

  function fetchCountryDetailsByCountryName (countryName, isoCode2) {
    fetch(`php/opencagedata-api.php?query=${encodeURIComponent(countryName)}`)
      .then(response => {
        if (!response.ok) {
          throw new Error(
            `Failed to fetch geocode data: ${response.statusText}`
          )
        }
        return response.text().then(text => (text ? JSON.parse(text) : {}))
      })
      .then(geocodeData => {
        if (!geocodeData.results || geocodeData.results.length === 0) {
          throw new Error('Geocode data is empty or malformed')
        }

        let coords = geocodeData.results[0].geometry

        return Promise.all([
          fetch(`php/weather-api.php?lat=${coords.lat}&lon=${coords.lng}`).then(
            resp => {
              if (!resp.ok) {
                throw new Error(
                  `Failed to fetch weather data: ${resp.statusText}`
                )
              }
              return resp.text().then(text => (text ? JSON.parse(text) : {}))
            }
          ),
          fetch('php/exchange-rate-api.php').then(resp => {
            if (!resp.ok) {
              throw new Error(
                `Failed to fetch exchange rate data: ${resp.statusText}`
              )
            }
            return resp.text().then(text => (text ? JSON.parse(text) : {}))
          }),
          fetch(
            `php/wikipedia-geonames-api.php?place_name=${encodeURIComponent(
              countryName
            )}`
          ).then(resp => {
            if (!resp.ok) {
              throw new Error(
                `Failed to fetch Wikipedia data: ${resp.statusText}`
              )
            }
            return resp.text().then(text => (text ? JSON.parse(text) : {}))
          }),
          fetch(
            `php/demographic-geonames-api.php?country_iso_code=${isoCode2}`
          ).then(resp => {
            if (!resp.ok) {
              throw new Error(
                `Failed to fetch demographic data: ${resp.statusText}`
              )
            }
            return resp.text().then(text => (text ? JSON.parse(text) : {}))
          })
        ]).then(
          ([weatherData, exchangeRateData, wikipediaData, demographicData]) => {
            return {
              geocodeData,
              weatherData,
              exchangeRateData,
              wikipediaData,
              demographicData
            }
          }
        )
      })
      .then(
        ({
          geocodeData,
          weatherData,
          exchangeRateData,
          wikipediaData,
          demographicData
        }) => {
          let apiResponses = {
            countryName: countryName,
            geocode: geocodeData.results[0],
            weather: weatherData,
            exchangeRate: exchangeRateData,
            wikipedia: wikipediaData.geonames
              ? wikipediaData.geonames[0]
              : null, // Adding null check for geonames
            demographics: demographicData.geonames
              ? demographicData.geonames[0]
              : null // Adding null check for geonames in demographics
          }

          updateCountryData(apiResponses)
        }
      )
      .catch(error => {
        console.error('Error fetching country details:', error.message)
      })
  }

  /**
   * The airlabsAPI function fetches a list of airports in a country using its ISO code.
   * It then adds markers to the map for each airport.
   * The map is then zoomed to fit the bounds of all the markers.
   * @param {*} isoCode
   */
  function airlabsAPI (isoCode) {
    fetch(`php/airlabs-api.php?isoCode=${isoCode}`)
      .then(response => response.json())
      .then(data => {
        console.log(data)
        /**
         * For each airport, create a marker with a plane icon and a popup with the airport's name.
         * Add the marker to the markers cluster group.
         * Add the markers cluster group to the map.
         * Zoom the map to fit the bounds of all the markers.
         */
        data.forEach(item => {
          var marker = L.marker([item.lat, item.lng], {
            icon: L.AwesomeMarkers.icon({
              icon: 'plane',
              prefix: 'fa',
              markerColor: 'green',
              spin: false
            })
          }).bindPopup(item.name)

          markers.addLayer(marker)
        })
        map.addLayer(markers)
        map.fitBounds(markers.getBounds())
      })
      .catch(error => console.log('Error:', error))
  }

  function citiesApi (isoCode) {
    fetch(`php/cities-api.php?isoCode=${isoCode}`)
      .then(response => {
        if (!response.ok) {
          throw new Error(`failed to fetch cities:  ${response.statusText}`)
        }
        return response.json()
      })
      .then(data => {
        data.forEach(item => {
          let marker = L.marker([item.lat, item.lon], {
            icon: L.AwesomeMarkers.icon({
              icon: 'city',
              prefix: 'fa',
              markerColor: 'red',
              spin: false
            })
          }).bindPopup(item.display_name)

          markers.addLayer(marker)
        })
        map.addLayer(markers)
        map.fitBounds(markers.getBounds())
      })
      .catch(error => {
        console.error('Error fetching cities details:', error.message)
      })
  }
})
