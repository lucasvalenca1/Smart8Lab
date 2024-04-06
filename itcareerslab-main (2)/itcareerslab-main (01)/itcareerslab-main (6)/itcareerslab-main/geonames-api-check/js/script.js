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

$(window).on("load", function () {
  if ($("#preloader").length) {
    $("#preloader")
      .delay(1000)
      .fadeOut("slow", function () {
        $(this).remove();
      });
  }
});