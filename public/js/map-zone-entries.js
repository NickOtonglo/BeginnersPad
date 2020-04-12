
var map, infoWindow, markerZoneUpdate, markerEntryCreate, markerEntryUpdate,
                            latZoneUpdate, lngZoneUpdate,
                            latEntryCreate, lngEntryCreate, initLatEntryCreate, initLngEntryCreate,
                            latEntryUpdate, lngEntryUpdate;

function initMapZoneUpdate(){
    mapZoneUpdate = new google.maps.Map(document.getElementById('zone_map_update'), {
        center: {lat: -1.286553, lng: 36.817348},
        zoom: 14
    });
    infoWindow = new google.maps.InfoWindow;
    if(initLatZoneUpdate!=0 && initLngZoneUpdate!=0){
        var centerPosZoneUpdate = new google.maps.LatLng(initLatZoneUpdate, initLngZoneUpdate);
        placeMarkerZoneUpdate(centerPosZoneUpdate,mapZoneUpdate);
        mapZoneUpdate.setCenter(centerPosZoneUpdate);
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
                infoWindow.open(mapZoneUpdate);
                mapZoneUpdate.setCenter(pos);
            }, function () {
                handleLocationError(true, infoWindow, mapZoneUpdate.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, mapZoneUpdate.getCenter());
            alert('Browser does not support Geolocation');
        }
    }
    google.maps.event.addListener(mapZoneUpdate, 'click', function (event) {
        placeMarkerZoneUpdate(event.latLng, mapZoneUpdate);
        $('#zone_lat_update').val(latZoneUpdate);
        $('#zone_lng_update').val(lngZoneUpdate);
    });
}

function initMapEntryCreate(){
    mapEntryCreate = new google.maps.Map(document.getElementById('entry_map_create'), {
        center: { lat: -1.286553, lng: 36.817348 },
        zoom: 14
    });
    infoWindow = new google.maps.InfoWindow;
    initLatEntryCreate = document.getElementById('entry_lat_create').value;
    initLngEntryCreate = document.getElementById('entry_lng_create').value;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            infoWindow.setPosition(pos);
            infoWindow.setContent('You are here!');
            infoWindow.open(mapEntryCreate);
            mapEntryCreate.setCenter(pos);
        }, function () {
            handleLocationError(true, infoWindow, mapEntryCreate.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, mapEntryCreate.getCenter());
        alert('Browser does not support Geolocation');
    }
    google.maps.event.addListener(mapEntryCreate, 'click', function (event) {
        placeMarkerEntryCreate(event.latLng, mapEntryCreate);
        $('#entry_lat_create').val(latEntryCreate);
        $('#entry_lng_create').val(lngEntryCreate);
    });
}

function initMapEntryUpdate(){
    mapEntryUpdate = new google.maps.Map(document.getElementById('entry_map_update'), {
        center: { lat: -1.286553, lng: 36.817348 },
        zoom: 14
    });
    infoWindow = new google.maps.InfoWindow;
    if(initLatEntryUpdate!=0 && initLngEntryUpdate!=0){
        var centerPosEntryUpdate = new google.maps.LatLng(initLatEntryUpdate, initLngEntryUpdate);
        placeMarkerEntryUpdate(centerPosEntryUpdate,mapEntryUpdate);
        mapEntryUpdate.setCenter(centerPosEntryUpdate);
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
                infoWindow.open(mapEntryUpdate);
                mapEntryUpdate.setCenter(pos);
            }, function () {
                handleLocationError(true, infoWindow, mapEntryUpdate.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, mapEntryUpdate.getCenter());
            alert('Browser does not support Geolocation');
        }
    }
    google.maps.event.addListener(mapEntryUpdate, 'click', function (event) {
        placeMarkerEntryUpdate(event.latLng, mapEntryUpdate);
        $('#entry_lat_update').val(latEntryUpdate);
        $('#entry_lng_update').val(lngEntryUpdate);
    });
}

function placeMarkerZoneUpdate(location, map) {
    if (markerZoneUpdate == null) {
        markerZoneUpdate = new google.maps.Marker({
            position: location,
            map: map
        });
    } else {
        markerZoneUpdate.setPosition(location);
    }
    latZoneUpdate = markerZoneUpdate.getPosition().lat();
    lngZoneUpdate = markerZoneUpdate.getPosition().lng();
}

function placeMarkerEntryCreate(location, map) {
    if (markerEntryCreate == null) {
        markerEntryCreate = new google.maps.Marker({
            position: location,
            map: map
        });
    } else {
        markerEntryCreate.setPosition(location);
    }
    latEntryCreate = markerEntryCreate.getPosition().lat();
    lngEntryCreate = markerEntryCreate.getPosition().lng();
}

function placeMarkerEntryUpdate(location, map) {
    if (markerEntryUpdate == null) {
        markerEntryUpdate = new google.maps.Marker({
            position: location,
            map: map
        });
    } else {
        markerEntryUpdate.setPosition(location);
    }
    latEntryUpdate = markerEntryUpdate.getPosition().lat();
    lngEntryUpdate = markerEntryUpdate.getPosition().lng();
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}