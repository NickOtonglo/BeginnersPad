var map, infoWindow, marker, lat, lng, initLat, initLng;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -1.286553, lng: 36.817348},
    zoom: 14
  });
  infoWindow = new google.maps.InfoWindow;
  initLat = document.getElementById('lat').value;
  initLng = document.getElementById('lng').value;
  if (initLat!=0 && initLng!=0) {
    var centerPos = new google.maps.LatLng(initLat, initLng);
    placeMarker(centerPos);
    // infoWindow.setPosition(centerPos);
    // infoWindow.setContent(document.getElementById('property_name').value);
    map.setCenter(centerPos);
  }
  else {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        infoWindow.setPosition(pos);
        infoWindow.setContent('You are here!');
        infoWindow.open(map);
        map.setCenter(pos);
      }, function() {
        handleLocationError(true, infoWindow, map.getCenter());
      });
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
      alert('Browser does not support Geolocation');
    }
  }
  google.maps.event.addListener(map, 'click', function(event) {
    placeMarker(event.latLng);
    $('#lat').val(lat);
    $('#lng').val(lng);
  })
}
function placeMarker(location) {
  if (marker == null){
    marker = new google.maps.Marker({
      position: location,
      map: map
    });
  } else {
    marker.setPosition(location);
  }
  lat = marker.getPosition().lat();
  lng = marker.getPosition().lng();
}
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
  infoWindow.open(map);
}