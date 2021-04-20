let entryId;
// let zoneObj = {!! json_encode($zone)!!};
let initUrl = "/manage-zone/" + zoneObj.id;
let actionUrl;

$('.modal').on('hide.bs.modal', function (e) {
    clearAlerts();
});

hideEntryCreateAlert();
hideEntryUpdateAlert();
hideZoneUpdateAlert();

$('.card-big-clickable').on('click',function () {
    $('#modalUpdateEntry').modal('show')
});

$('#btn_update').on('click',function (e) {
    if(validateEntryUpdateForm()){
        if (confirm("Are you sure you want to update this sub-zone?")) {
            $('#formEntryUpdate').attr('action', actionUrl);
            e.stopPropagation();
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    }
});

$('#btn_update_zone').on('click',function (e) {
    if(validateZoneUpdateForm()){
        if (confirm("Are you sure you want to update this zone?")) {
            e.stopPropagation();
            return false;
        } else {
            e.stopPropagation();
            return false;
        }
    }
});

$('#btn_save').on('click',function (e) {
    if(validateEntryCreateForm()){
        if (confirm("Are you sure you want to create this sub-zone?")) {
            e.stopPropagation();
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    }
});

$('.btn-delete').on('click',function (e) {
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
            $('#alert_name_zone_update').html('<li>Required</li>').attr("hidden",false);
            $('#zone_name_update').addClass('bp-input-validation-error');
        }
        if (document.getElementById("zone_country_update").value.trim() == "") {
            $('#alert_country_zone_update').html('<li>Required</li>').attr("hidden",false);
            $('#zone_country_update').addClass('bp-input-validation-error');
        }

        if (document.getElementById("zone_county_update").value.trim() == "") {
            $('#alert_county_zone_update').html('<li>Required</li>').attr("hidden",false);
            $('#zone_county_update').addClass('bp-input-validation-error');
        }
        return false;
    } else {
        if (document.getElementById("zone_name_update").value.trim().length > 50) {
            $('#alert_name_zone_update').html('<li>Name should contain 50 characters or less</li>').attr("hidden",false);
            $('#zone_name_update').addClass('bp-input-validation-error');
            return false;
        } else if (document.getElementById("zone_county_update").value.trim().length > 50) {
            $('#alert_county_zone_update').html('<li>County should contain 50 characters or less</li>').attr("hidden",false);
            $('#zone_county_update').addClass('bp-input-validation-error');
            return false;
        } else if (isNaN(document.getElementById("zone_radius_update").value.trim())) {
            $('#alert_radius_zone_update').html('<li>Radius must be a number</li>').attr("hidden",false);
            $('#zone_radius_update').addClass('bp-input-validation-error');
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
            $('#alert_name_create').html('<li>Required</li>').attr("hidden",false);
            $('#entry_name_create').addClass('bp-input-validation-error');
        }
        if (document.getElementById("entry_role_create").value.trim() == "") {
            $('#alert_role_create').html('<li>Required</li>').attr("hidden",false);
            $('#entry_role_create').addClass('bp-input-validation-error');
        }
        /**
        if(document.getElementById("entry_lat_create").value.trim()==""){
            $('#alert_lat_create').html('<li>Required</li>').attr("hidden",false);
            $('#entry_lat_create').addClass('bp-input-validation-error');
        }
        if(document.getElementById("entry_lng_create").value.trim()==""){
            $('#alert_lng_create').html('<li>Required</li>').attr("hidden",false);
            $('#entry_lng_create').addClass('bp-input-validation-error');
        }
        if(document.getElementById("entry_radius_create").value.trim()==""){
            $('#alert_radius_update').html('<li>Required</li>').attr("hidden",false);
            $('#entry_radius_update').addClass('bp-input-validation-error');
        }
         */
        if (document.getElementById("entry_timezone_create").value.trim() == "") {
            $('#alert_timezone_create').html('<li>Required</li>').attr("hidden",false);
            $('#entry_timezone_create').addClass('bp-input-validation-error');
        }
        return false;
    } else {
        if (document.getElementById("entry_name_create").value.trim().length > 50) {
            $('#alert_name_create').html('<li>Name should contain 50 characters or less</li>').attr("hidden",false);
            $('#entry_name_create').addClass('bp-input-validation-error');
            return false;
        } else if (isNaN(document.getElementById("entry_radius_update").value.trim())) {
            $('#alert_radius_create').html('<li>Radius must be a number</li>').attr("hidden",false);
            $('#entry_radius_create').addClass('bp-input-validation-error');
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
            $('#alert_name_update').html('<li>Required</li>').attr("hidden",false);
            $('#entry_name_update').addClass('bp-input-validation-error');
        }
        if (document.getElementById("entry_role_update").value.trim() == "") {
            $('#alert_role_update').html('<li>Required</li>').attr("hidden",false);
            $('#entry_role_update').addClass('bp-input-validation-error');
        }
        /**
        if(document.getElementById("entry_lat_update").value.trim()==""){
            $('#alert_lat_update').html('<li>Required</li>').attr("hidden",false);
            $('#entry_lat_update').addClass('bp-input-validation-error');
        }
        if(document.getElementById("entry_lng_update").value.trim()==""){
            $('#alert_lng_update').html('<li>Required</li>').attr("hidden",false);
            $('#entry_lng_update').addClass('bp-input-validation-error');
        }
        if(document.getElementById("entry_radius_update").value.trim()==""){
            $('#alert_radius_update').html('<li>Required</li>').attr("hidden",false);
            $('#entry_radius_update').addClass('bp-input-validation-error');
        }
        */
        if (document.getElementById("entry_timezone_update").value.trim() == "") {
            $('#alert_timezone_update').html('<li>Required</li>').attr("hidden",false);
            $('#entry_timezone_update').addClass('bp-input-validation-error');
        }
        return false;
    } else {
        if (document.getElementById("entry_name_update").value.trim().length > 50) {
            $('#alert_name_update').html('<li>Name should contain 50 characters or less</li>').attr("hidden",false);
            $('#entry_name_update').addClass('bp-input-validation-error');
            return false;
        } else if (isNaN(document.getElementById("entry_radius_update").value.trim())) {
            $('#alert_radius_update').html('<li>Radius must be a number</li>').attr("hidden",false);
            $('#entry_radius_update').addClass('bp-input-validation-error');
        } else {
            return true;
        }
    }
}

function hideZoneUpdateAlert() {
    $('#zone_name_update').on('input', function () {
        $('#alert_name_zone_update').attr("hidden",true);;
        $('#zone_name_update').removeClass('bp-input-validation-error');
    });
    $('#zone_country_update').on('input', function () {
        $('#alert_country_zone_update').attr("hidden",true);;
        $('#zone_country_update').removeClass('bp-input-validation-error');
    });
    $('#zone_county_update').on('input', function () {
        $('#alert_county_zone_update').attr("hidden",true);;
        $('#zone_county_update').removeClass('bp-input-validation-error');
    });
    $('#zone_lat_update').on('input', function () {
        $('#alert_lat_zone_update').attr("hidden",true);;
        $('#zone_lat_update').removeClass('bp-input-validation-error');
    });
    $('#zone_lng_update').on('input', function () {
        $('#alert_lng_zone_update').attr("hidden",true);;
        $('#zone_lng_update').removeClass('bp-input-validation-error');
    });
    $('#zone_radius_update').on('input', function () {
        $('#alert_radius_zone_update').attr("hidden",true);;
        $('#zone_radius_update').removeClass('bp-input-validation-error');
    });
    $('#zone_timezone_update').on('input', function () {
        $('#alert_timezone_zone_update').attr("hidden",true);;
        $('#zone_timezone_update').removeClass('bp-input-validation-error');
    });
}

function hideEntryCreateAlert() {
    $('#entry_name_create').on('input', function () {
        $('#alert_name_create').attr("hidden",true);
        $('#entry_name_create').removeClass('bp-input-validation-error');
    });
    $('#entry_role_create').on('input', function () {
        $('#alert_role_create').attr("hidden",true);
        $('#entry_role_create').removeClass('bp-input-validation-error');
    });
    $('#entry_lat_create').on('input', function () {
        $('#alert_lat_create').attr("hidden",true);
        $('#entry_lat_create').removeClass('bp-input-validation-error');
    });
    $('#entry_lng_create').on('input', function () {
        $('#alert_lng_create').attr("hidden",true);
        $('#entry_lng_create').removeClass('bp-input-validation-error');
    });
    $('#entry_radius_create').on('input', function () {
        $('#alert_radius_create').attr("hidden",true);
        $('#entry_radius_create').removeClass('bp-input-validation-error');
    });
    $('#entry_timezone_create').on('input', function () {
        $('#alert_timezone_create').attr("hidden",true);
        $('#entry_timezone_create').removeClass('bp-input-validation-error');
    });
}

function hideEntryUpdateAlert() {
    $('#entry_name_update').on('input', function () {
        $('#alert_name_update').attr("hidden",true);
        $('#entry_name_update').removeClass('bp-input-validation-error');
    });
    $('#entry_role_update').on('input', function () {
        $('#alert_role_update').attr("hidden",true);
        $('#entry_role_update').removeClass('bp-input-validation-error');
    });
    $('#entry_lat_update').on('input', function () {
        $('#alert_lat_update').attr("hidden",true);
        $('#entry_lat_update').removeClass('bp-input-validation-error');
    });
    $('#entry_lng_update').on('input', function () {
        $('#alert_lng_update').attr("hidden",true);
        $('#entry_lng_update').removeClass('bp-input-validation-error');
    });
    $('#entry_radius_update').on('input', function () {
        $('#alert_radius_update').attr("hidden",true);
        $('#entry_radius_update').removeClass('bp-input-validation-error');
    });
    $('#entry_timezone_update').on('input', function () {
        $('#alert_timezone_update').attr("hidden",true);
        $('#entry_timezone_update').removeClass('bp-input-validation-error');
    });
}

function clearAlerts() {
    // Zone update form
    $('#alert_name_zone_update').attr("hidden",true);
    $('#zone_name_update').removeClass('bp-input-validation-error');
    $('#alert_country_zone_update').attr("hidden",true);
    $('#zone_country_update').removeClass('bp-input-validation-error');
    $('#alert_county_zone_update').attr("hidden",true);
    $('#zone_county_update').removeClass('bp-input-validation-error');
    $('#alert_lat_zone_update').attr("hidden",true);
    $('#zone_lat_update').removeClass('bp-input-validation-error');
    $('#alert_lng_zone_update').attr("hidden",true);
    $('#zone_lng_update').removeClass('bp-input-validation-error');
    $('#alert_radius_zone_update').attr("hidden",true);
    $('#zone_radius_update').removeClass('bp-input-validation-error');
    $('#alert_timezone_zone_update').attr("hidden",true);
    $('#zone_timezone_update').removeClass('bp-input-validation-error');
    // ZoneEntry create form
    $('#alert_name_create').attr("hidden",true);
    $('#entry_name_create').removeClass('bp-input-validation-error');
    $('#alert_role_create').attr("hidden",true);
    $('#entry_role_create').removeClass('bp-input-validation-error');
    $('#alert_lat_create').attr("hidden",true);
    $('#entry_lat_create').removeClass('bp-input-validation-error');
    $('#alert_lng_create').attr("hidden",true);
    $('#entry_lng_create').removeClass('bp-input-validation-error');
    $('#alert_radius_create').attr("hidden",true);
    $('#entry_radius_create').removeClass('bp-input-validation-error');
    $('#alert_timezone_create').attr("hidden",true);
    $('#entry_timezone_create').removeClass('bp-input-validation-error');
    // ZoneEntry update form
    $('#alert_name_update').attr("hidden",true);
    $('#entry_name_update').removeClass('bp-input-validation-error');
    $('#alert_role_update').attr("hidden",true);
    $('#entry_role_update').removeClass('bp-input-validation-error');
    $('#alert_lat_update').attr("hidden",true);
    $('#entry_lat_update').removeClass('bp-input-validation-error');
    $('#alert_lng_update').attr("hidden",true);
    $('#entry_lng_update').removeClass('bp-input-validation-error');
    $('#alert_radius_update').attr("hidden",true);
    $('#entry_radius_update').removeClass('bp-input-validation-error');
    $('#alert_timezone_update').attr("hidden",true);
    $('#entry_timezone_update').removeClass('bp-input-validation-error');
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