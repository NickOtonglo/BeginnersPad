var map, infoWindow, marker, lat, lng, initLat, initLng;
function initMap() {
    map = new google.maps.Map(document.getElementById('map-static'), {
        center: { lat: -1.286553, lng: 36.817348 },
        zoom: 14,
        disableDefaultUI: false
    });
    infoWindow = new google.maps.InfoWindow;
    initLat = listingObj.lat;
    initLng = listingObj.lng;
    if (initLat != 0 && initLng != 0) {
        var centerPos = new google.maps.LatLng(initLat, initLng);
        placeMarker(centerPos);
        map.setCenter(centerPos);
    }
}
function placeMarker(location) {
    if (marker == null) {
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