$('.modal').on('hide.bs.modal', function (e) {
    clearAlerts();
});

hideZoneCreateAlert();

function validateZoneCreateForm() {
    if (document.getElementById("name").value.trim() == ""
        || document.getElementById("country").value.trim() == ""
        || document.getElementById("county").value.trim() == "") {
        if (document.getElementById("name").value.trim() == "") {
            $('#alert_name_zone_create').html('<li>Required</li>').attr("hidden",false);;
            $('#name').addClass('bp-input-validation-error');
        }
        if (document.getElementById("country").value.trim() == "") {
            $('#alert_country_zone_create').html('<li>Required</li>').attr("hidden",false);;
            $('#country').addClass('bp-input-validation-error');
        }

        if (document.getElementById("county").value.trim() == "") {
            $('#alert_county_zone_create').html('<li>Required</li>').attr("hidden",false);;
            $('#county').addClass('bp-input-validation-error');
        }
        return false;
    } else {
        if (document.getElementById("name").value.trim().length > 50) {
            $('#alert_name_zone_create').html('<li>Name should contain 50 characters or less</li>').attr("hidden",false);;
            $('#name').addClass('bp-input-validation-error');
            return false;
        } else if (document.getElementById("county").value.trim().length > 50) {
            $('#alert_county_zone_create').html('<li>County should contain 50 characters or less</li>').attr("hidden",false);;
            $('#county').addClass('bp-input-validation-error');
            return false;
        } else if (isNaN(document.getElementById("radius").value.trim())) {
            $('#alert_radius_zone_create').html('<li>Radius must be a number</li>').attr("hidden",false);;
            $('#radius').addClass('bp-input-validation-error');
        } else {
            return true;
        }
    }
}

function hideZoneCreateAlert() {
    $('#name').on('input', function () {
        $('#alert_name_zone_create').attr("hidden",true);;
        $('#name').removeClass('bp-input-validation-error');
    });
    $('#country').on('input', function () {
        $('#alert_country_zone_create').attr("hidden",true);;
        $('#country').removeClass('bp-input-validation-error');
    });
    $('#county').on('input', function () {
        $('#alert_county_zone_create').attr("hidden",true);;
        $('#county').removeClass('bp-input-validation-error');
    });
    $('#lat').on('input', function () {
        $('#alert_lng_create').attr("hidden",true);;
        $('#lat').removeClass('bp-input-validation-error');
    });
    $('#lng').on('input', function () {
        $('#alert_radius_create').attr("hidden",true);;
        $('#lng').removeClass('bp-input-validation-error');
    });
    $('#radius').on('input', function () {
        $('#alert_radius_zone_create').attr("hidden",true);;
        $('#radius').removeClass('bp-input-validation-error');
    });
    $('#timezone').on('input', function () {
        $('#alert_timezone_zone_create').attr("hidden",true);;
        $('#timezone').removeClass('bp-input-validation-error');
    });
}

function clearAlerts() {
    // Zone create form
    $('#alert_name_zone_create').attr("hidden",true);;
    $('#name').removeClass('bp-input-validation-error');
    $('#alert_country_zone_create').attr("hidden",true);;
    $('#country').removeClass('bp-input-validation-error');
    $('#alert_county_zone_create').attr("hidden",true);;
    $('#county').removeClass('bp-input-validation-error');
    $('#alert_lat_zone_create').attr("hidden",true);;
    $('#lat').removeClass('bp-input-validation-error');
    $('#alert_lng_zone_create').attr("hidden",true);;
    $('#lng').removeClass('bp-input-validation-error');
    $('#alert_radius_zone_create').attr("hidden",true);;
    $('#radius').removeClass('bp-input-validation-error');
    $('#alert_timezone_zone_create').attr("hidden",true);;
    $('#timezone').removeClass('bp-input-validation-error');
}