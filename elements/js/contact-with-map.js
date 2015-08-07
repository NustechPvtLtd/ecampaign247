var address =$('#lbl_address').text();

if (GBrowserIsCompatible()) { 

	var map = new GMap2(document.getElementById("map_canvas"));
	map.setUIToDefault();
	
	// Create a base icon for all of our markers that specifies the
	// shadow, icon dimensions, etc.
	var baseIcon = new GIcon(G_DEFAULT_ICON);
	baseIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
	baseIcon.iconSize = new GSize(20, 34);
	baseIcon.shadowSize = new GSize(37, 34);
	baseIcon.iconAnchor = new GPoint(9, 34);
	baseIcon.infoWindowAnchor = new GPoint(9, 2);

	// Creates a marker whose info window displays the letter corresponding
	// to the given index.
	function createMarker(point, index) {
	  // Create a lettered icon for this point using our icon class
	  var letter = String.fromCharCode("A".charCodeAt(0) + index);
	  var letteredIcon = new GIcon(baseIcon);
	  letteredIcon.image = "http://www.google.com/mapfiles/marker" + letter + ".png";

	  // Set up our GMarkerOptions object
	  markerOptions = { icon:letteredIcon };
	  var marker = new GMarker(point, markerOptions);

	  GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml(addresses[index]);
	  });
	  return marker;
	}

  
  // ====== Create a Client Geocoder ======
  var geo = new GClientGeocoder(); 

  // ====== Array for decoding the failure codes ======
  var reasons=[];
  reasons[G_GEO_SUCCESS]            = "Success";
  reasons[G_GEO_MISSING_ADDRESS]    = "Missing Address: The address was either missing or had no value.";
  reasons[G_GEO_UNKNOWN_ADDRESS]    = "Unknown Address:  No corresponding geographic location could be found for the specified address.";
  reasons[G_GEO_UNAVAILABLE_ADDRESS]= "Unavailable Address:  The geocode for the given address cannot be returned due to legal or contractual reasons.";
  reasons[G_GEO_BAD_KEY]            = "Bad Key: The API key is either invalid or does not match the domain for which it was given";
  reasons[G_GEO_TOO_MANY_QUERIES]   = "Too Many Queries: The daily geocoding quota for this site has been exceeded.";
  reasons[G_GEO_SERVER_ERROR]       = "Server error: The geocoding request could not be successfully processed.";
  reasons[403]                      = "Error 403: Probably an incorrect error caused by a bug in the handling of invalid JSON.";
  
  var j=0;
  // ====== Geocoding ======
  function getAddress(search, next) {
	geo.getLocations(search, function (result)
	  { 
		// If that was successful
		if (result.Status.code == G_GEO_SUCCESS) {
		  // Lets assume that the first marker is the one we want
		  var p = result.Placemark[0].Point.coordinates;
		  var lat=p[1];
		  var lng=p[0];
		  if(j == 0)
		  {
			map.setCenter(new GLatLng(lat, lng), 15);
		  }

			var latlng = new GLatLng(lat, lng);
			map.addOverlay(createMarker(latlng, j));
		  
		}
		j++;
		next();
	  }
	);
  }


  // ======= An array of locations that we want to Geocode ========
  var addresses = [
	address
  ];

  // ======= Global variable to remind us what to do next
  var nextAddress = 0;

  // ======= Function to call the next Geocode operation when the reply comes back

  function theNext() {
	if (nextAddress < addresses.length) {
	  getAddress(addresses[nextAddress],theNext);
	  nextAddress++;
	}
  }

  // ======= Call that function for the first time =======
  theNext();

}

// display a warning if the browser was not compatible
else {
  alert("Sorry, the Google Maps API is not compatible with this browser");
}