var map, infoWindow, marker, markerListingUpdate, latListingUpdate, lngListingUpdate;

function initMapListingUpdate(){
    mapListingUpdate = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -1.286553, lng: 36.817348},
        zoom: 14
    });
    infoWindow = new google.maps.InfoWindow;
    if(initLatListingUpdate!=0 && initLngListingUpdate!=0){
        var centerPosListingUpdate = new google.maps.LatLng(initLatListingUpdate, initLngListingUpdate);
        placeMarkerListingUpdate(centerPosListingUpdate,mapListingUpdate);
        mapListingUpdate.setCenter(centerPosListingUpdate);
    }
    else {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                infoWindow.setPosition(pos);
                infoWindow.setContent('You are here!');
                infoWindow.open(mapListingUpdate);
                mapListingUpdate.setCenter(pos);
            }, function () {
                handleLocationError(true, infoWindow, mapListingUpdate.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, mapListingUpdate.getCenter());
            alert('Browser does not support Geolocation');
        }
    }
    google.maps.event.addListener(mapListingUpdate, 'click', function (event) {
        placeMarkerListingUpdate(event.latLng, mapListingUpdate);
        $('#lat').val(latListingUpdate);
        $('#lng').val(lngListingUpdate);
    });
}

function placeMarkerListingUpdate(location, map) {
    if (markerListingUpdate == null) {
        markerListingUpdate = new google.maps.Marker({
            position: location,
            map: map
        });
    } else {
        markerListingUpdate.setPosition(location);
    }
    latListingUpdate = markerListingUpdate.getPosition().lat();
    lngListingUpdate = markerListingUpdate.getPosition().lng();
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}