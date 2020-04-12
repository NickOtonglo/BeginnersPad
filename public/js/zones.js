$('.modal').on('hide.bs.modal', function (e) {
    clearAlerts();
});

hideZoneCreateAlert();

function validateZoneCreateForm() {
    if (document.getElementById("name").value.trim() == ""
        || document.getElementById("country").value.trim() == ""
        || document.getElementById("county").value.trim() == "") {
        if (document.getElementById("name").value.trim() == "") {
            $('#alert_name_zone_create').html('<li>Required</li>').show();
            $('#name').addClass('alert alert-danger');
        }
        if (document.getElementById("country").value.trim() == "") {
            $('#alert_country_zone_create').html('<li>Required</li>').show();
            $('#country').addClass('alert alert-danger');
        }

        if (document.getElementById("county").value.trim() == "") {
            $('#alert_county_zone_create').html('<li>Required</li>').show();
            $('#county').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (document.getElementById("name").value.trim().length > 50) {
            $('#alert_name_zone_create').html('<li>Name should contain 50 characters or less</li>').show();
            $('#name').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("county").value.trim().length > 50) {
            $('#alert_county_zone_create').html('<li>County should contain 50 characters or less</li>').show();
            $('#county').addClass('alert alert-danger');
            return false;
        } else if (isNaN(document.getElementById("radius").value.trim())) {
            $('#alert_radius_zone_create').html('<li>Radius must be a number</li>').show();
            $('#radius').addClass('alert alert-danger');
        } else {
            return true;
        }
    }
}

function hideZoneCreateAlert() {
    $('#name').on('input', function () {
        $('#alert_name_zone_create').hide();
        $('#name').removeClass('alert alert-danger');
    });
    $('#country').on('input', function () {
        $('#alert_country_zone_create').hide();
        $('#country').removeClass('alert alert-danger');
    });
    $('#county').on('input', function () {
        $('#alert_county_zone_create').hide();
        $('#county').removeClass('alert alert-danger');
    });
    $('#lat').on('input', function () {
        $('#alert_lng_create').hide();
        $('#lat').removeClass('alert alert-danger');
    });
    $('#lng').on('input', function () {
        $('#alert_radius_create').hide();
        $('#lng').removeClass('alert alert-danger');
    });
    $('#radius').on('input', function () {
        $('#alert_radius_zone_create').hide();
        $('#radius').removeClass('alert alert-danger');
    });
    $('#timezone').on('input', function () {
        $('#alert_timezone_zone_create').hide();
        $('#timezone').removeClass('alert alert-danger');
    });
}

function clearAlerts() {
    // Zone create form
    $('#alert_name_zone_create').hide();
    $('#name').removeClass('alert alert-danger');
    $('#alert_country_zone_create').hide();
    $('#country').removeClass('alert alert-danger');
    $('#alert_county_zone_create').hide();
    $('#county').removeClass('alert alert-danger');
    $('#alert_lat_zone_create').hide();
    $('#lat').removeClass('alert alert-danger');
    $('#alert_lng_zone_create').hide();
    $('#lng').removeClass('alert alert-danger');
    $('#alert_radius_zone_create').hide();
    $('#radius').removeClass('alert alert-danger');
    $('#alert_timezone_zone_create').hide();
    $('#timezone').removeClass('alert alert-danger');
}