//function geocodeAddress(geocoder, resultsMap) {
//  var address =  $("#lbl_address").text().trim();
//  geocoder.geocode({'address': address}, function(results, status) {
//    if (status === google.maps.GeocoderStatus.OK) {
//      resultsMap.setCenter(results[0].geometry.location);
//      var marker = new google.maps.Marker({
//        map: resultsMap,
//        position: results[0].geometry.location
//      });
//    } else {
//      alert('Geocode was not successful for the following reason: ' + status);
//    }
//  });
//}
//function initMap() {
//  var map = new google.maps.Map(document.getElementById('map_canvas'), {
//    zoom: 8,
//    center: {lat: -34.397, lng: 150.644}
//  });
//  var geocoder = new google.maps.Geocoder();
//
//    geocodeAddress(geocoder, map);
//}


function initMap() {
  var map = new google.maps.Map(document.getElementById('map_canvas'), {
    zoom: 8,
    center: {lat: -34.397, lng: 150.644}
  });
  var geocoder = new google.maps.Geocoder();
  geocodeAddress(geocoder, map);
}

function geocodeAddress(geocoder, resultsMap) {
  var address =  $("#lbl_address").text().trim();
//  alert(address);
  geocoder.geocode({'address': address}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      resultsMap.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: resultsMap,
        position: results[0].geometry.location
      });
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}