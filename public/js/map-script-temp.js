// https://developers.google.com/maps/documentation/javascript/examples/map-geolocation
// https://stackoverflow.com/questions/16349476/map-isnt-showing-on-google-maps-javascript-api-v3-when-nested-in-a-div-tag

  var map, infoWindow, marker, lat, lng;
  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -34.397, lng: 150.644},
      zoom: 16
    });
    infoWindow = new google.maps.InfoWindow;
    //marker dragend event
    google.maps.event.addListener(marker,'dragend',function(){
      console.log(marker.getPosition().lat());
      console.log(marker.getPosition().long());
    });

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
    }
    google.maps.event.addListener(map, 'click', function(event) {
      placeMarker(event.latLng);
      document.getElementById("lat").innerHTML = event.latLng;
      document.getElementById("lng").innerHTML = event.latLng;
    })
  }
  function placeMarker(location) {
    if (marker == null){
      marker = new google.maps.Marker({
        position: location,
        map: map,
        draggable: true
      });
      lat = marker.getPosition().lat();
      lng = marker.getPosition().lng();
      
    } else {
      marker.setPosition(location);
      lat = marker.getPosition().lat();
      lng = marker.getPosition().lng();
    }
  }
  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                          'Error: The Geolocation service failed.' :
                          'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  }
