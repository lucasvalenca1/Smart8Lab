$(document).ready( () => {
  fillSelectOptions();
  getUserLocation();
});

let userLat = "";
let userLng = "";
let userCountryIso = "";
let selectedCountryIso = "";
let countryBorders = "";
let countryCapital = "";
let countryPopulation = "";
let countryCurrencyCode = "";
let exchangeRate = "";
let exchangeValue = "";
let countryBoundingBox = "";
let capitalCoordinates = [];
let countryPolygon = L.polygon([]);

let marker = "";
let markers = L.markerClusterGroup();

let map = L.map("map").setView([15, 0], 2);

let OpenStreetMap_Mapnik =   L.tileLayer('https://tile.jawg.io/4ec2f9de-1282-45cc-beed-63051d3fa8ae/{z}/{x}/{y}{r}.png?access-token=3Sjm5q2uF4gOLS2My1KANwwvQOueyNNHmJjuX5QdSVkZHhb19vp3msCmNgu4H3Fi',
  {
    accessToken: '3Sjm5q2uF4gOLS2My1KANwwvQOueyNNHmJjuX5QdSVkZHhb19vp3msCmNgu4H3Fi',
    maxZoom: 18,
    attribution: '<a href="http://jawg.io" title="Tiles Courtesy of Jawg Maps" target="_blank" class="jawg-attrib" >&copy; <b>Jawg</b>Maps</a> | <a href="https://www.openstreetmap.org/copyright" title="OpenStreetMap is open data licensed under ODbL" target="_blank" class="osm-attrib" >&copy; OSM contributors</a>',
  }
).addTo(map);

const fillSelectOptions = () => {
  $.getJSON("libs/php/getSelectOptions.php", data => {
    let countriesArray = data.result;
    countriesArray.forEach((country) => {
      $("#country-select").append(
        `<option value="${country[1]}">${country[0]}</option>`
      );
    });
  });
};

const getUserLocation = () => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition((position) => {
      userLat = position.coords.latitude;
      userLng = position.coords.longitude;
      selectUserLocation();
    });
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
};

const selectUserLocation = () => {
  $.ajax({
    url: "libs/php/getUserCurrentCountry.php",
    type: "POST",
    dataType: "json",
    data: {
      latitude: userLat,
      longitude: userLng,
    },
    success: result => {
      if (result.status.name == "ok") {
        userCountryIso = result.data;
        selectedCountryIso = userCountryIso;
        $("#country-select").val(selectedCountryIso);
        getCountryBorders();
      }
    },
    error: (errorThrown) => {
      x.innerHTML = 'Ops! Something does not seem right.';
      console.log(errorThrown);
    },
  });
};

const getCountryBorders = () => {
  $.ajax({
    url: "libs/php/getCountryBorders.php",
    type: "POST",
    dataType: "json",
    data: {
      countryIso: selectedCountryIso,
    },
    success: data => {
      let country = data.result;

      countryPolygon.setLatLngs(country.geometry.coordinates)

      countryBorders = L.geoJSON(country, {
        style: () => {
          return {
            color: '#183153',
            weight: 2,
            fillColor: 'white',
            fillOpacity: 0.5,
          }
        }
      }).bindPopup(layer => {
          return layer.feature.properties.description;
      }).addTo(map);

      countryBoundingBox = countryBorders.getBounds();

      map.fitBounds(countryBoundingBox);
      
      getCountryInfo();
    },
    error: (errorThrown) => {
      x.innerHTML = 'Ops! Something does not seem right.';
      console.log(errorThrown);
    },
  });
};

const getCountryInfo = () => {
  $.ajax({
    url: "libs/php/getCountryInfo.php",
    type: "POST",
    dataType: "json",
    data: {
      countryIso: selectedCountryIso,
    },
    success: result => {
      
      if (result.status.name == "ok") {
        countryCapital = result.capital;
        countryPopulation = result.population;
        countryCurrencyCode = result.currencyCode;
    
        getWikiEntries();
      }
    },
    error: (errorThrown) => {
      x.innerHTML = 'Ops! Something does not seem right.';
      console.log(errorThrown);
    },
  });
};

$("#country-select").on("change", () => {
  countryBorders.clearLayers();
  selectedCountryIso = $("#country-select").val();
  getCountryBorders();
});

const inside = (point, vs) => {
  let lat = point[0],
    lng = point[1];

  let inside = false;
  for (let i = 0, j = vs.length - 1; i < vs.length; j = i++) {
    let lati = vs[i][0], lngi = vs[i][1];
    let latj = vs[j][0], lngj = vs[j][1];

    let intersect = lngi > lng != lngj > lng 
      && lat < ((latj - lati) * (lng - lngi)) / (lngj - lngi) + lati;
    if (intersect) inside = !inside;
  }
  return inside;
}

const coordsObjToArray = (point, polygon) => {
  let newCoords = [];
  polygon.forEach((obj) => {
    let array = [];
    array.push(obj.lng, obj.lat);
    newCoords.push(array);
  });
  return inside(point, newCoords);
};

const getWikiEntries = () => {
  $.ajax({
    url: "libs/php/getWikiEntries.php",
    type: "POST",
    dataType: "json",
    data: {
      south: countryBoundingBox._southWest.lat,
      north: countryBoundingBox._northEast.lat,
      east: countryBoundingBox._northEast.lng,
      west: countryBoundingBox._southWest.lng,
    },
    success: result => {

      if (result.status.name == "ok") {

        markers.clearLayers();
        
        const entriesArray = result.data;
        const countryCoordsArray = countryPolygon.getLatLngs();
        if (countryCoordsArray.length == 1) {
          entriesArray.forEach((entry) => {
            countryCoordsArray.forEach((array) => {
              const entryCorrdinates = [entry.lat, entry.lng];

              if (coordsObjToArray(entryCorrdinates, array)) {
                if (entry.feature == "city") {
                  marker = L.marker(entryCorrdinates, {
                    icon: cityMarker,
                  }).bindPopup(
                    markerTemplate(
                      entry.title,
                      entry.thumbnailImg,
                      entry.summary,
                      entry.wikipediaUrl
                      )
                  );
                  markers.addLayer(marker).addTo(map);
                } else if (entry.feature == "edu") {
                  marker = L.marker(entryCorrdinates, {
                    icon: eduMarker,
                  }).bindPopup(
                    markerTemplate(
                      entry.title,
                      entry.thumbnailImg,
                      entry.summary,
                      entry.wikipediaUrl
                      )
                  );
                  markers.addLayer(marker).addTo(map);
                } else if (entry.feature == "edu") {
                  marker = L.marker(entryCorrdinates, {
                    icon: landmarkMarker,
                  }).bindPopup(
                    markerTemplate(
                      entry.title,
                      entry.thumbnailImg,
                      entry.summary,
                      entry.wikipediaUrl
                      )
                  );
                  markers.addLayer(marker).addTo(map);
                } else if (entry.feature == "airport") {
                  marker = L.marker(entryCorrdinates, {
                    icon: airportMarker,
                  }).bindPopup(
                    markerTemplate(
                      entry.title,
                      entry.thumbnailImg,
                      entry.summary,
                      entry.wikipediaUrl
                      )
                  );
                  markers.addLayer(marker).addTo(map);
                } else {
                  marker = L.marker(entryCorrdinates, {
                    icon: nullMarker,
                  }).bindPopup(
                    markerTemplate(
                      entry.title,
                      entry.thumbnailImg,
                      entry.summary,
                      entry.wikipediaUrl
                      )
                  );
                  markers.addLayer(marker).addTo(map);
                }
              }
            });
          });
        } else {
          entriesArray.forEach((entry) => {
            countryCoordsArray.forEach((array) => {
              let innerArray = array[0];

              if (!Array.isArray(innerArray)) {
                innerArray = array;
              }
             
              const entryCorrdinates = [entry.lat, entry.lng];

              if (coordsObjToArray(entryCorrdinates, innerArray)) {
                if (entry.feature == "city") {
                  marker = L.marker(entryCorrdinates, {
                    icon: cityMarker,
                  }).bindPopup(
                    markerTemplate(
                      entry.title,
                      entry.thumbnailImg,
                      entry.summary,
                      entry.wikipediaUrl
                      )
                  );
                  markers.addLayer(marker).addTo(map);
                } else if (entry.feature == "edu") {
                  marker = L.marker(entryCorrdinates, {
                    icon: eduMarker,
                  }).bindPopup(
                    markerTemplate(
                      entry.title,
                      entry.thumbnailImg,
                      entry.summary,
                      entry.wikipediaUrl
                      )
                  );
                  markers.addLayer(marker).addTo(map);
                } else if (entry.feature == "edu") {
                  marker = L.marker(entryCorrdinates, {
                    icon: landmarkMarker,
                  }).bindPopup(
                    markerTemplate(
                      entry.title,
                      entry.thumbnailImg,
                      entry.summary,
                      entry.wikipediaUrl
                      )
                  );
                  markers.addLayer(marker).addTo(map);
                } else if (entry.feature == "airport") {
                  marker = L.marker(entryCorrdinates, {
                    icon: airportMarker,
                  }).bindPopup(
                    markerTemplate(
                      entry.title,
                      entry.thumbnailImg,
                      entry.summary,
                      entry.wikipediaUrl
                      )
                  );
                  markers.addLayer(marker).addTo(map);
                } else {
                  marker = L.marker(entryCorrdinates, {
                    icon: nullMarker,
                  }).bindPopup(
                    markerTemplate(
                      entry.title,
                      entry.thumbnailImg,
                      entry.summary,
                      entry.wikipediaUrl
                    )
                  );
                  markers.addLayer(marker).addTo(map);
                }
              }
            });
          });
        }
      } 

    },
    error: (errorThrown) => {
      window.alert("Sorry, something is out of order. Please refresh the page and try again.")
      console.log(errorThrown)
    },
  });
  $(".fade-me").addClass("d-none");
  exchangeToGbp();
  getCapitalKey();
  getNews();
  getPhotos();
  getCams();
};

const markerTemplate = (title, thumb, summary, url) => {
  return `
  <div class="popup">
    <h6>${title}</h6>
    <img 
      src="${(thumb) ? thumb : 'libs/images/no-image.svg'}" 
      alt="${(thumb) ? title : 'no image icon'}"/>
    <p>${summary}</p>
    <a href="${url}" target="_blank">Wikipedia</a> 
  </div>
    `;
};

let cityMarker = L.ExtraMarkers.icon({
  icon: 'fa-city',
  markerColor: '#74C0FC',
  shape: 'circle',
  prefix: 'fa',
  svg: "true",
});
let eduMarker = L.ExtraMarkers.icon({
  icon: "fa-graduation-cap",
  markerColor: "#e2c521",
  shape: "circle",
  prefix: "fa",
  svg: "true",
});
let landmarkMarker = L.ExtraMarkers.icon({
  icon: "fa-landmark",
  markerColor: "#E599F7",
  shape: "circle",
  prefix: "fa",
  svg: "true",
});
let airportMarker = L.ExtraMarkers.icon({
  icon: "fa-plane",
  markerColor: "#FF8787",
  shape: "circle",
  prefix: "fa",
  svg: "true",
});
let nullMarker = L.ExtraMarkers.icon({
  icon: "fa-star",
  markerColor: "#63E6BE",
  shape: "circle",
  prefix: "fa",
  svg: "true",
});
 
let myModal = $('#country-info-modal');

L.easyButton('fa-circle-info', () => {
  
  $('#country-name').text($('#country-select option:selected').html())
  $('#capital-name').text(countryCapital)
  $('#country-population').text(numberWithCommas(countryPopulation))
  $('#country-currency-code').text(countryCurrencyCode)
  $('#currency-code-label').text(countryCurrencyCode)
  exchangeValue = $('#gbp-value').val() * exchangeRate
  $("#exchange-rate").val((Math.round(exchangeValue * 100) / 100).toFixed(2));
  myModal.modal("show")
}).addTo(map);

const exchangeToGbp = () => {
  getCovidInfo();
  $.ajax({
		url: "libs/php/getExchangeRates.php",
		type: 'POST',
		dataType: 'json',
		success: result => {
			if (result.status.name == "ok") {
        let exchangeData = result.data;
        const gbp = exchangeData.GBP;
        const oneGbpToUsd = 1/gbp;
        exchangeRate = oneGbpToUsd * exchangeData[countryCurrencyCode];
			}
		},
		error: (errorThrown) => {
			console.log(errorThrown)
		}
	});
}

$("#gbp-value").on("input", function(){
  exchangeValue = $(this).val() * exchangeRate
  $("#exchange-rate").val((Math.round(exchangeValue * 100) / 100).toFixed(2));
});
$("#exchange-rate").on("input", function(){
  exchangeValue = $(this).val() / exchangeRate
  $("#gbp-value").val((Math.round(exchangeValue * 100) / 100).toFixed(2));
});


let capitalKey = "";
let capitalTemp = "";
let currentCondition = "";
let currentWeatherIcon = "";
let windSpeed = "";
let forecastIcons = [];
let forecastDates = [];
let minMaxTemps = [];
let weatherIcons = { 
  1: 'fa-solid fa-sun',
  2: 'fa-solid fa-sun',
  3: 'fa-solid fa-sun',
  4: 'fa-solid fa-sun',
  5: 'fa-solid fa-sun',
  6: 'fa-solid fa-cloud-sun',
  7: 'fa-solid fa-cloud',
  8: 'fa-solid fa-cloud',
  11: 'fa-solid fa-smog',
  12: 'fa-solid fa-cloud-rain',
  13: 'fa-solid fa-cloud-sun-rain',
  14: 'fa-solid fa-cloud-sun-rain',
  15: 'fa-solid fa-cloud-showers-heavy',
  16: 'fa-solid fa-cloud-sun-rain',
  17: 'fa-solid fa-cloud-sun-rain',
  18: 'fa-solid fa-cloud-showers-heavy',
  19: 'fa-solid fa-snowflake',
  20: 'fa-solid fa-snowflake',
  21: 'fa-solid fa-snowflake',
  22: 'fa-solid fa-snowflake',
  23: 'fa-solid fa-snowflake',
  24: 'fa-solid fa-icicles',
  25: 'fa-solid fa-snowflake',
  26: 'fa-solid fa-snowflake',
  29: 'fa-solid fa-temperature-low',
  30: 'fa-solid fa-temperature-high',
  31: 'fa-solid fa-snowflake',
  32: 'fa-solid fa-wind',
  33: 'fa-solid fa-sun',
  34: 'fa-solid fa-sun',
  35: 'fa-solid fa-cloud-sun',
  36: 'fa-solid fa-cloud-sun',
  37: 'fa-solid fa-cloud-smog',
  38: 'fa-solid fa-cloud',
  39: 'fa-solid fa-cloud-sun-rain',
  40: 'fa-solid fa-cloud-rain',
  41: 'fa-solid fa-cloud-showers-heavy',
  42: 'fa-solid fa-cloud-showers-heavy',
  43: 'fa-solid fa-cloud-snowflake',
  44: 'fa-solid fa-cloud-snowflake',
}

const getCurrentWeather = () => {
  $.ajax({
		url: "libs/php/getCurrentWeather.php",
		type: 'POST',
		dataType: 'json',
    data: {
      capitalKey: capitalKey,
    },
		success: result => {
			if (result.status.name == "ok") {
        capitalTemp = `${Math.round(result.capitalTemp)}${String.fromCharCode(176)}`
        currentWeatherIcon = result.currentWeatherIcon
			}
		},
		error: (errorThrown) => {
			console.log(errorThrown)
		}
	});
};

const toCelsius = fahrenheit => {
  let celsius = (fahrenheit - 32) * 5/9;
  return Math.round(celsius)
}

const addOrdinal = day => {
  if (day > 3 && day < 21) return 'th';
  switch (day % 10) {
      case 1:  return "st";
      case 2:  return "nd";
      case 3:  return "rd";
      default: return "th";
  }
};

const getWeatherForecast = () => {
  $.ajax({
		url: "libs/php/getWeatherForecast.php",
		type: 'POST',
		dataType: 'json',
    data: {
      capitalKey: capitalKey,
    },
		success: result => {
			if (result.status.name == "ok") {
        currentCondition = result.currentCondition
        const forecastArray = result.data
        forecastArray.forEach(day => {
          forecastIcons.push(day.Day.Icon);
          minMaxTemps.push([toCelsius(day.Temperature.Maximum.Value), toCelsius(day.Temperature.Minimum.Value)])
          let newDay = new Date(day.Date);
          let weekDay = newDay.toDateString().slice(0, 3);
          let monthDay = newDay.toDateString().slice(8, 10);
          forecastDates.push(`${weekDay} ${monthDay}${addOrdinal(monthDay)}`)
        })
			}
		},
		error: (errorThrown) => {
			console.log(errorThrown)
		}
	});
};

const getCapitalKey = () => {
  $.ajax({
		url: "libs/php/getCapitalKey.php",
		type: 'POST',
		dataType: 'json',
    data: {
      selectedCountryIso: selectedCountryIso,
      countryCapital: countryCapital,
    },
		success: result => {
			if (result.status.name == "ok") {
        capitalKey = result.capitalKey
        getCurrentWeather();
        getWeatherForecast();
			}
		},
		error: (errorThrown) => {
			console.log(errorThrown)
		}
	});
};

let myWeatherModal = $('#weather-modal');
let myErrorModal = $('#error-modal')

L.easyButton('fa-cloud-sun', () => {
  $('#second-day-icon').empty()
  $('#third-day-icon').empty()
  $('#fourth-day-icon').empty()
  $('#fifth-day-icon').empty()
  $('#current-weather-icon').empty()


  $('#weather-capital-name').text(countryCapital)
  $('#this-week-day').text(forecastDates[0])
  $('#capital-temp').text(capitalTemp)
  $('#current-condition').text(currentCondition)
  $('#current-weather-icon').append(`<i class="${weatherIcons[currentWeatherIcon]} fa-4x"></i>`)
  
  $('#second-day').text(forecastDates[1])
  $('#third-day').text(forecastDates[2])
  $('#fourth-day').text(forecastDates[3])
  $('#fifth-day').text(forecastDates[4])
  
  $('#second-day-icon').prepend(`<i class="${weatherIcons[forecastIcons[1]]} fa-2x text-white"></i>`)
  $('#third-day-icon').prepend(`<i class="${weatherIcons[forecastIcons[2]]} fa-2x"></i>`)
  $('#fourth-day-icon').prepend(`<i class="${weatherIcons[forecastIcons[3]]} fa-2x"></i>`)
  $('#fifth-day-icon').prepend(`<i class="${weatherIcons[forecastIcons[4]]} fa-2x"></i>`)

  $('#current-max').text(minMaxTemps[0][0])
  $('#current-min').text(minMaxTemps[0][1])
  $('#second-max').text(minMaxTemps[1][0])
  $('#second-min').text(minMaxTemps[1][1])
  $('#third-max').text(minMaxTemps[2][0])
  $('#third-min').text(minMaxTemps[2][1])
  $('#fourth-max').text(minMaxTemps[3][0])
  $('#fourth-min').text(minMaxTemps[3][1])
  $('#fifth-max').text(minMaxTemps[4][0])
  $('#fifth-min').text(minMaxTemps[4][1])

 
  myWeatherModal.modal("show")

}).addTo(map);

let confirmedCases = "";
let criticalCases = "";
let deathCases = "";
let recoveredCases = "";


const getCovidInfo = () => {
  $.ajax({
		url: "libs/php/getCovidInfo.php",
		type: 'POST',
		dataType: 'json',
    data: {
      countryIso: selectedCountryIso,
    },
		success: result => {
			if (result.status.name == "ok") {
        confirmedCases = result.confirmedCases;
        criticalCases = result.criticalCases;
        deathCases = result.deathCases;
        recoveredCases = result.recoveredCases;
			}
		},
		error: (errorThrown) => {
			console.log(errorThrown)
		}
	});
};

let myCovidModal = $('#covid-info-modal');

L.easyButton('fa-virus-covid', () => {

  if(confirmedCases){
    $('#covid-country-name').text($('#country-select option:selected').html())
    $('#confirmed-cases').text(numberWithCommas(confirmedCases))
    $('#critical-cases').text(numberWithCommas(criticalCases))
    $('#death-cases').text(numberWithCommas(deathCases))
    $('#recovered-cases').text(numberWithCommas(recoveredCases))

    myCovidModal.modal("show");
  } else {
    myErrorModal.modal("show")
  }
 
}).addTo(map);

let firstNewsTitle = "";
let secondNewsTitle = "";
let thirdNewsTitle = "";

let firstNewsImg = "";
let secondNewsImg = "";
let thirdNewsImg = "";

let firstNewsDescription = "";
let secondNewsDescription = "";
let thirdNewsDescription = "";

let firstNewsLink = "";
let secondNewsLink = "";
let thirdNewsLink = "";

let newsArray = "";

const getNews = () => {
    $.ajax({
		url: "libs/php/getNews.php",
		type: 'POST',
		dataType: 'json',
    data: {
      selectedCountryIso: selectedCountryIso,
    },
		success: result => {
			if (result.status.name == "ok") {
  
          newsArray = result.news;

          if (newsArray.length == 3) {
            secondNewsTitle = newsArray[1].title;
            thirdNewsTitle = newsArray[2].title;

            firstNewsImg = newsArray[0].urlToImage;
            secondNewsImg = newsArray[1].urlToImage;
            thirdNewsImg = newsArray[2].urlToImage;

            firstNewsDescription = newsArray[0].description;
            secondNewsDescription = newsArray[1].description;
            thirdNewsDescription = newsArray[2].description;

            firstNewsLink = newsArray[0].url;
            secondNewsLink = newsArray[1].url;
            thirdNewsLink = newsArray[2].url;
          }
			}
		},
		error: (errorThrown) => {
			console.log(errorThrown)
		}
	});
}

let myNewsModal = $('#news-modal');

L.easyButton('fa-newspaper', () => {

  if (newsArray.length == 3) {
    $('#news-country-name').text($('#country-select option:selected').html())

    $('#first-news-title').text(firstNewsTitle)
    $('#first-news-img').attr('src', firstNewsImg)
    $('#first-news-description').text(firstNewsDescription)
    $('#first-news-link').attr('href', firstNewsLink)  
    
    $('#second-news-title').text(secondNewsTitle)
    $('#second-news-img').attr('src', secondNewsImg)
    $('#second-news-description').text(secondNewsDescription)
    $('#second-news-link').attr('href', secondNewsLink)  
    
    $('#third-news-title').text(thirdNewsTitle)
    $('#third-news-img').attr('src', thirdNewsImg)
    $('#third-news-description').text(thirdNewsDescription)
    $('#third-news-link').attr('href', thirdNewsLink)

    myNewsModal.modal("show")  

  } else {
    myErrorModal.modal("show")
  }

}).addTo(map);


let urlArray = [];
let altArray = [];

const getPhotos = () => {
  $.ajax({
  url: "libs/php/getPhotos.php",
  type: 'POST',
  dataType: 'json',
  data: {
    countryCapital: countryCapital,
  },
  success: result => {
    if (result.status.name == "ok") {
      urlArray = [];
      altArray = [];
      let picturesArray = result.pictures

      picturesArray.forEach(picture => {
        urlArray.push(picture.urls.regular);
        altArray.push(picture.alt_description);
      });
     

    }
  },
  error: (errorThrown) => {
    console.log(errorThrown)
  }
});
}

let picturesModal = $('#pictures-modal');

L.easyButton('fa-image', () => {
  $('#first-image').attr('src', urlArray[0]);
  $('#first-image').attr('alt', altArray[0]);
  $('#second-image').attr('src', urlArray[1]);
  $('#second-image').attr('alt', altArray[1]);
  $('#third-image').attr('src', urlArray[2]);
  $('#third-image').attr('alt', altArray[2]);
  $('#fourth-image').attr('src', urlArray[3]);
  $('#fourth-image').attr('alt', altArray[3]);
  $('#fifth-image').attr('src', urlArray[4]);
  $('#fifth-image').attr('alt', altArray[4]);

  picturesModal.modal("show")  

}).addTo(map);


let webcam = "";
let cams = L.markerClusterGroup();

let camMarker = L.ExtraMarkers.icon({
  icon: 'fa-video',
  markerColor: '#E599F7',
  shape: 'circle',
  prefix: 'fa',
  svg: "true",
});

const getCams = () => {
  $.ajax({
    url: "libs/php/getCams.php",
    type: 'POST',
    dataType: 'json',
    data: {
      selectedCountryIso: selectedCountryIso,
    },
    success: result => {
      if (result.status.name == "ok") {

        cams.clearLayers();

        let camsArray = result.data;
        
        camsArray.forEach(cam => {
          let camTitle = cam.title
          let camVideo = cam.player.day.embed
          let lat = cam.location.latitude
          let lng = cam.location.longitude
          
          webcam = L.marker([lat,lng], {
            icon: camMarker,
          }).bindPopup(`
          <h5>${camTitle}</h5>
          <iframe id="" src="${camVideo}" title="W3Schools Free Online Web Tutorials"></iframe>
          `);
          cams.addLayer(webcam).addTo(map);
        });
        
      }
    },
    error: (errorThrown) => {
      console.log(errorThrown)
    }
  });
}
const numberWithCommas = number => {
  number = number.toString();
  let pattern = /(-?\d+)(\d{3})/;
  while (pattern.test(number))
      number = number.replace(pattern, "$1,$2");
  return number;
}
