$(document).ready(function () {
    $('#checkbox').change(function () {
        if (this.checked) {
            $('#form_deposit').show();
        } else {
            $('#form_deposit').hide();
        }
    });

    $('#checkbox_description').change(function () {
        if (this.checked) {
            $('#description').val(listingObj.description);
            $('#description').prop("readonly", true);
        } else {
            $('#description').prop("readonly", false);
        }
    });

    $('.modal').on('hide.bs.modal', function (e) {
        clearAlerts();
    });
});

hideEntryCreateAlert();

var loadFile = function (event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('output');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

function validateEntryCreateForm() {
    if (document.getElementById("listing_name").value.trim() == ""
        || document.getElementById("floor_area").value.trim() == ""
        || document.getElementById("price").value.trim() == "") {
        if (document.getElementById("listing_name").value.trim() == "") {
            $('#alert_name_entry_create').html('<li>Required</li>').show();
            $('#listing_name').addClass('alert alert-danger');
        }
        if (document.getElementById("floor_area").value.trim() == "") {
            $('#alert_floor_area_entry_create').html('<li>Required</li>').show();
            $('#floor_area').addClass('alert alert-danger');
        }
        if (document.getElementById("price").value.trim() == "") {
            $('#alert_price_entry_create').html('<li>Required</li>').show();
            $('#price').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (document.getElementById("checkbox").checked && document.getElementById("initial_deposit").value.trim() == "") {
            $('#alert_initial_deposit_entry_create').html('<li>Required</li>').show();
            $('#initial_deposit').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("checkbox").checked && document.getElementById("initial_deposit_period").value.trim() == "") {
            $('#alert_deposit_period_entry_create').html('<li>Required</li>').show();
            $('#initial_deposit_period').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("listing_name").value.trim().length > 50) {
            $('#alert_name_entry_create').html('<li>Name should contain 100 characters or less</li>').show();
            $('#listing_name').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("description").value.trim().length > 5000) {
            $('#alert_desc_entry_create').html('<li>Description should contain 5000 characters or less</li>').show();
            $('#description').addClass('alert alert-danger');
            return false;
        } else {
            if(!document.getElementById("checkbox").checked){
                document.getElementById("initial_deposit").value = null;
                document.getElementById("initial_deposit_period").value = null;
            }
            if(document.getElementById('checkbox_description').checked){
                document.getElementById('description').value = listingObj.description;
            }
            return true;
        }
    }
}

function hideEntryCreateAlert() {
    $('#listing_name').on('input', function () {
        $('#alert_name_entry_create').hide();
        $('#listing_name').removeClass('alert alert-danger');
    });
    $('#description').on('input', function () {
        $('#alert_desc_entry_create').hide();
        $('#description').removeClass('alert alert-danger');
    });
    $('#floor_area').on('input', function () {
        $('#alert_floor_area_entry_create').hide();
        $('#floor_area').removeClass('alert alert-danger');
    });
    $('#disclaimer').on('input', function () {
        $('#alert_disclaimer_entry_create').hide();
        $('#disclaimer').removeClass('alert alert-danger');
    });
    $('#features').on('input', function () {
        $('#alert_features_entry_create').hide();
        $('#features').removeClass('alert alert-danger');
    });
    $('#initial_deposit').on('input', function () {
        $('#alert_initial_deposit_entry_create').hide();
        $('#initial_deposit').removeClass('alert alert-danger');
    });
    $('#initial_deposit_period').on('input', function () {
        $('#alert_deposit_period_entry_create').hide();
        $('#initial_deposit_period').removeClass('alert alert-danger');
    });
    $('#price').on('input', function () {
        $('#alert_price_entry_create').hide();
        $('#price').removeClass('alert alert-danger');
    });
}

function clearAlerts() {
    $('#alert_name_entry_create').hide();
    $('#listing_name').removeClass('alert alert-danger');
    $('#alert_desc_entry_create').hide();
    $('#description').removeClass('alert alert-danger');
    $('#alert_floor_area_entry_create').hide();
    $('#floor_area').removeClass('alert alert-danger');
    $('#alert_disclaimer_entry_create').hide();
    $('#disclaimer').removeClass('alert alert-danger');
    $('#alert_features_entry_create').hide();
    $('#features').removeClass('alert alert-danger');
    $('#alert_initial_deposit_entry_create').hide();
    $('#initial_deposit').removeClass('alert alert-danger');
    $('#alert_deposit_period_entry_create').hide();
    $('#initial_deposit_period').removeClass('alert alert-danger');
    $('#alert_price_entry_create').hide();
    $('#price').removeClass('alert alert-danger');
}

function populateEntryUpdateForm(lst){
    try {
        let listing = JSON.parse(lst);
        document.getElementById("listing_name").value = listing.listing_name;
        document.getElementById("description").value = listing.description;
        document.getElementById("floor_area").value = listing.floor_area;
        document.getElementById("disclaimer").value = listing.disclaimer;
        document.getElementById("features").value = listing.features;
        document.getElementById("price").value = listing.price;
        if(listing.initial_deposit != null || listing.initial_deposit_period != null){
            document.getElementById("checkbox").checked = true;
            document.getElementById("initial_deposit").value = listing.initial_deposit;
            document.getElementById("initial_deposit_period").value = listing.initial_deposit_period;
            $('#form_deposit').show();
        }
        // document.getElementById('output').src = '/images/listings/'+listing.id+'/thumbnails/'+listing.thumbnail;
    } catch (error) {

    }
}