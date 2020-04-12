let entryId;
// let zoneObj = {!! json_encode($zone)!!};
let initUrl = "/manage-zone/" + zoneObj.id;
let actionUrl;

$('.modal').on('hide.bs.modal', function (e) {
    clearAlerts();
});

hideEntryCreateAlert();
hideEntryUpdateAlert();

$('.card-big-clickable').click(populateEntryUpdateForm);
$('.card-big-clickable').click(function () {
    $('#modalUpdateEntry').modal('show')
});
$('#btnUpdate').click(function () {
    $('#formEntryUpdate').attr('action', actionUrl);
});
$('.btn-delete').click(function (e) {
    if (confirm("Are you sure you want to remove this sub-zone?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

function validateZoneUpdateForm() {
    if (document.getElementById("zone_name_update").value.trim() == ""
        || document.getElementById("zone_country_update").value.trim() == ""
        || document.getElementById("zone_county_update").value.trim() == "") {
        if (document.getElementById("zone_name_update").value.trim() == "") {
            $('#alert_name_zone_update').html('<li>Required</li>').show();
            $('#zone_name_update').addClass('alert alert-danger');
        }
        if (document.getElementById("zone_country_update").value.trim() == "") {
            $('#alert_country_zone_update').html('<li>Required</li>').show();
            $('#zone_country_update').addClass('alert alert-danger');
        }

        if (document.getElementById("zone_county_update").value.trim() == "") {
            $('#alert_county_zone_update').html('<li>Required</li>').show();
            $('#zone_county_update').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (document.getElementById("zone_name_update").value.trim().length > 50) {
            $('#alert_name_zone_update').html('<li>Name should contain 50 characters or less</li>').show();
            $('#zone_name_update').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("zone_county_update").value.trim().length > 50) {
            $('#alert_county_zone_update').html('<li>County should contain 50 characters or less</li>').show();
            $('#zone_county_update').addClass('alert alert-danger');
            return false;
        } else if (isNaN(document.getElementById("zone_radius_update").value.trim())) {
            $('#alert_radius_zone_update').html('<li>Radius must be a number</li>').show();
            $('#zone_radius_update').addClass('alert alert-danger');
        } else {
            return true;
        }
    }
}

function validateEntryCreateForm() {
    if (document.getElementById("entry_name_create").value.trim() == ""
        || document.getElementById("entry_role_create").value.trim() == ""
        || document.getElementById("entry_timezone_create").value.trim() == "") {
        if (document.getElementById("entry_name_create").value.trim() == "") {
            $('#alert_name_create').html('<li>Required</li>').show();
            $('#entry_name_create').addClass('alert alert-danger');
        }
        if (document.getElementById("entry_role_create").value.trim() == "") {
            $('#alert_role_create').html('<li>Required</li>').show();
            $('#entry_role_create').addClass('alert alert-danger');
        }
        /**
        if(document.getElementById("entry_lat_create").value.trim()==""){
            $('#alert_lat_create').html('<li>Required</li>').show();
            $('#entry_lat_create').addClass('alert alert-danger');
        }
        if(document.getElementById("entry_lng_create").value.trim()==""){
            $('#alert_lng_create').html('<li>Required</li>').show();
            $('#entry_lng_create').addClass('alert alert-danger');
        }
        if(document.getElementById("entry_radius_create").value.trim()==""){
            $('#alert_radius_update').html('<li>Required</li>').show();
            $('#entry_radius_update').addClass('alert alert-danger');
        }
         */
        if (document.getElementById("entry_timezone_create").value.trim() == "") {
            $('#alert_timezone_create').html('<li>Required</li>').show();
            $('#entry_timezone_create').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (document.getElementById("entry_name_create").value.trim().length > 50) {
            $('#alert_name_create').html('<li>Name should contain 50 characters or less</li>').show();
            $('#entry_name_create').addClass('alert alert-danger');
            return false;
        } else if (isNaN(document.getElementById("entry_radius_update").value.trim())) {
            $('#alert_radius_create').html('<li>Radius must be a number</li>').show();
            $('#entry_radius_create').addClass('alert alert-danger');
        } else {
            return true;
        }
    }
}

function validateEntryUpdateForm() {
    if (document.getElementById("entry_name_update").value.trim() == ""
        || document.getElementById("entry_role_update").value.trim() == ""
        || document.getElementById("entry_timezone_update").value.trim() == "") {
        if (document.getElementById("entry_name_update").value.trim() == "") {
            $('#alert_name_update').html('<li>Required</li>').show();
            $('#entry_name_update').addClass('alert alert-danger');
        }
        if (document.getElementById("entry_role_update").value.trim() == "") {
            $('#alert_role_update').html('<li>Required</li>').show();
            $('#entry_role_update').addClass('alert alert-danger');
        }
        /**
        if(document.getElementById("entry_lat_update").value.trim()==""){
            $('#alert_lat_update').html('<li>Required</li>').show();
            $('#entry_lat_update').addClass('alert alert-danger');
        }
        if(document.getElementById("entry_lng_update").value.trim()==""){
            $('#alert_lng_update').html('<li>Required</li>').show();
            $('#entry_lng_update').addClass('alert alert-danger');
        }
        if(document.getElementById("entry_radius_update").value.trim()==""){
            $('#alert_radius_update').html('<li>Required</li>').show();
            $('#entry_radius_update').addClass('alert alert-danger');
        }
        */
        if (document.getElementById("entry_timezone_update").value.trim() == "") {
            $('#alert_timezone_update').html('<li>Required</li>').show();
            $('#entry_timezone_update').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (document.getElementById("entry_name_update").value.trim().length > 50) {
            $('#alert_name_update').html('<li>Name should contain 50 characters or less</li>').show();
            $('#entry_name_update').addClass('alert alert-danger');
            return false;
        } else if (isNaN(document.getElementById("entry_radius_update").value.trim())) {
            $('#alert_radius_update').html('<li>Radius must be a number</li>').show();
            $('#entry_radius_update').addClass('alert alert-danger');
        } else {
            return true;
        }
    }
}

function hideEntryCreateAlert() {
    $('#entry_name_create').on('input', function () {
        $('#alert_name_create').hide();
        $('#entry_name_create').removeClass('alert alert-danger');
    });
    $('#entry_role_create').on('input', function () {
        $('#alert_role_create').hide();
        $('#entry_role_create').removeClass('alert alert-danger');
    });
    $('#entry_lat_create').on('input', function () {
        $('#alert_lat_create').hide();
        $('#entry_lat_create').removeClass('alert alert-danger');
    });
    $('#entry_lng_create').on('input', function () {
        $('#alert_lng_create').hide();
        $('#entry_lng_create').removeClass('alert alert-danger');
    });
    $('#entry_radius_create').on('input', function () {
        $('#alert_radius_create').hide();
        $('#entry_radius_create').removeClass('alert alert-danger');
    });
    $('#entry_timezone_create').on('input', function () {
        $('#alert_timezone_create').hide();
        $('#entry_timezone_create').removeClass('alert alert-danger');
    });
}

function hideEntryUpdateAlert() {
    $('#entry_name_update').on('input', function () {
        $('#alert_name_update').hide();
        $('#entry_name_update').removeClass('alert alert-danger');
    });
    $('#entry_role_update').on('input', function () {
        $('#alert_role_update').hide();
        $('#entry_role_update').removeClass('alert alert-danger');
    });
    $('#entry_lat_update').on('input', function () {
        $('#alert_lat_update').hide();
        $('#entry_lat_update').removeClass('alert alert-danger');
    });
    $('#entry_lng_update').on('input', function () {
        $('#alert_lng_update').hide();
        $('#entry_lng_update').removeClass('alert alert-danger');
    });
    $('#entry_radius_update').on('input', function () {
        $('#alert_radius_update').hide();
        $('#entry_radius_update').removeClass('alert alert-danger');
    });
    $('#entry_timezone_update').on('input', function () {
        $('#alert_timezone_update').hide();
        $('#entry_timezone_update').removeClass('alert alert-danger');
    });
}

function clearAlerts() {
    // Zone update form
    $('#alert_name_zone_update').hide();
    $('#zone_name_update').removeClass('alert alert-danger');
    $('#alert_country_zone_update').hide();
    $('#zone_country_update').removeClass('alert alert-danger');
    $('#alert_county_zone_update').hide();
    $('#zone_county_update').removeClass('alert alert-danger');
    $('#alert_lat_zone_update').hide();
    $('#zone_lat_update').removeClass('alert alert-danger');
    $('#alert_lng_zone_update').hide();
    $('#zone_lng_update').removeClass('alert alert-danger');
    $('#alert_radius_zone_update').hide();
    $('#zone_radius_update').removeClass('alert alert-danger');
    $('#alert_timezone_zone_update').hide();
    $('#zone_timezone_update').removeClass('alert alert-danger');
    // ZoneEntry create form
    $('#alert_name_create').hide();
    $('#entry_name_create').removeClass('alert alert-danger');
    $('#alert_role_create').hide();
    $('#entry_role_create').removeClass('alert alert-danger');
    $('#alert_lat_create').hide();
    $('#entry_lat_create').removeClass('alert alert-danger');
    $('#alert_lng_create').hide();
    $('#entry_lng_create').removeClass('alert alert-danger');
    $('#alert_radius_create').hide();
    $('#entry_radius_create').removeClass('alert alert-danger');
    $('#alert_timezone_create').hide();
    $('#entry_timezone_create').removeClass('alert alert-danger');
    // ZoneEntry update form
    $('#alert_name_update').hide();
    $('#entry_name_update').removeClass('alert alert-danger');
    $('#alert_role_update').hide();
    $('#entry_role_update').removeClass('alert alert-danger');
    $('#alert_lat_update').hide();
    $('#entry_lat_update').removeClass('alert alert-danger');
    $('#alert_lng_update').hide();
    $('#entry_lng_update').removeClass('alert alert-danger');
    $('#alert_radius_update').hide();
    $('#entry_radius_update').removeClass('alert alert-danger');
    $('#alert_timezone_update').hide();
    $('#entry_timezone_update').removeClass('alert alert-danger');
}

function populateZoneUpdateForm(zn) {
    try {
        let zone = JSON.parse(zn);
        document.getElementById("zone_country_update").value = zone.country;
        document.getElementById("zone_name_update").value = zone.name;
        document.getElementById("zone_county_update").value = zone.county;
        document.getElementById("zone_lat_update").value = zone.lat;
        document.getElementById("zone_lng_update").value = zone.lng;
        document.getElementById("zone_radius_update").value = zone.radius;
        document.getElementById("zone_timezone_update").value = zone.timezone;
        initLatZoneUpdate = zone.lat;
        initLngZoneUpdate = zone.lng;
    } catch (error) {

    }
}

function populateEntryUpdateForm(ent) {
    try {
        let entry = JSON.parse(ent);
        document.getElementById("entry_name_update").value = entry.name;
        document.getElementById("entry_role_update").value = entry.role;
        document.getElementById("entry_lat_update").value = entry.lat;
        document.getElementById("entry_lng_update").value = entry.lng;
        document.getElementById("entry_radius_update").value = entry.radius;
        document.getElementById("entry_timezone_update").value = entry.timezone;
        actionUrl = initUrl + "/" + entry.id + "/edit";
        initLatEntryUpdate = entry.lat;
        initLngEntryUpdate = entry.lng;
    } catch (error) {

    }
}