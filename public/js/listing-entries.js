$(document).ready(function () {
    $('#checkbox_deposit').change(function () {
        if (this.checked) {
            $('#form_deposit').show();
        } else {
            $('#form_deposit').hide();
        }
    });

    $('#checkbox_description').change(function () {
        if (this.checked) {
            $('#entry_description').val(listingObj.description);
            $('#entry_description').prop("readonly", true);
        } else {
            $('#entry_description').prop("readonly", false);
        }
    });

    $('.modal').on('hide.bs.modal', function (e) {
        clearAlerts();
    });

    $('.btn-entry-edit').click(function (e) {
        if (confirm("Are you sure you want to perform this action?")) {
            e.stopPropagation();
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    });

    $('.btn-entry-delete').click(function (e) {
        if (confirm("Are you sure you want to perform this action?")) {
            e.stopPropagation();
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    });
});

hideEntryCreateAlert();
populateLists();

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
        || (document.getElementById("entry_price").value.trim() == "") && listingObj.price == null) {
        if (document.getElementById("listing_name").value.trim() == "") {
            $('#alert_name_entry_create').html('<li>Required</li>').show();
            $('#listing_name').addClass('alert alert-danger');
        }
        if (document.getElementById("floor_area").value.trim() == "") {
            $('#alert_floor_area_entry_create').html('<li>Required</li>').show();
            $('#floor_area').addClass('alert alert-danger');
        }
        if ((document.getElementById("entry_price").value.trim() == "") && listingObj.price == null) {
            $('#alert_price_entry_create').html('<li>Required</li>').show();
            $('#entry_price').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (document.getElementById("checkbox_deposit").checked && document.getElementById("initial_deposit").value.trim() == "") {
            $('#alert_initial_deposit_entry_create').html('<li>Required</li>').show();
            $('#initial_deposit').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("checkbox_deposit").checked && document.getElementById("initial_deposit_period").value.trim() == "") {
            $('#alert_deposit_period_entry_create').html('<li>Required</li>').show();
            $('#initial_deposit_period').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("listing_name").value.trim().length > 50) {
            $('#alert_name_entry_create').html('<li>Name should contain 100 characters or less</li>').show();
            $('#listing_name').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("entry_description").value.trim().length > 5000) {
            $('#alert_desc_entry_create').html('<li>Description should contain 5000 characters or less</li>').show();
            $('#entry_description').addClass('alert alert-danger');
            return false;
        } else {
            if(!document.getElementById("checkbox_deposit").checked){
                document.getElementById("initial_deposit").value = null;
                document.getElementById("initial_deposit_period").value = null;
            }
            if(document.getElementById('checkbox_description').checked){
                document.getElementById('entry_description').value = listingObj.description;
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
    $('#entry_description').on('input', function () {
        $('#alert_desc_entry_create').hide();
        $('#entry_description').removeClass('alert alert-danger');
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
    $('#entry_price').on('input', function () {
        $('#alert_price_entry_create').hide();
        $('#entry_price').removeClass('alert alert-danger');
    });
}

function clearAlerts() {
    $('#alert_name_entry_create').hide();
    $('#listing_name').removeClass('alert alert-danger');
    $('#alert_desc_entry_create').hide();
    $('#entry_description').removeClass('alert alert-danger');
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
    $('#entry_price').removeClass('alert alert-danger');
}

function populateEntryUpdateForm(lst){
    try {
        let listing = JSON.parse(lst);
        document.getElementById("listing_name").value = listing.listing_name;
        document.getElementById("entry_description").value = listing.description;
        document.getElementById("floor_area").value = listing.floor_area;
        document.getElementById("disclaimer").value = listing.disclaimer;
        document.getElementById("features").value = listing.features;
        document.getElementById("entry_price").value = listing.price;
        if((listing.initial_deposit != null || listing.initial_deposit_period != null) && (listing.initial_deposit != 0 || listing.initial_deposit_period != 0)){
            document.getElementById("checkbox_deposit").checked = true;
            document.getElementById("initial_deposit").value = listing.initial_deposit;
            document.getElementById("initial_deposit_period").value = listing.initial_deposit_period;
            $('#form_deposit').show();
        }
        // document.getElementById('output').src = '/images/listings/'+listing.id+'/thumbnails/'+listing.thumbnail;
    } catch (error) {

    }
}

function populateLists(){
    if (entryObj.disclaimer != null){
        var list = entryObj.disclaimer;
        list = list.split(';');
        // list.sort(function() { return 0.5 - Math.random() });
        var ul = document.getElementById("disclaimer_list");

        for(var i=0; i<list.length; i++) {
            var li = document.createElement("li");
            li.appendChild(document.createTextNode(list[i]));
            ul.appendChild(li);
        }
    }
    if (entryObj.features != null){
        var list = entryObj.features;
        list = list.split(';');
        // list.sort(function() { return 0.5 - Math.random() });
        var ul = document.getElementById("features_list");

        for(var i=0; i<list.length; i++) {
            var li = document.createElement("li");
            li.appendChild(document.createTextNode(list[i]));
            ul.appendChild(li);
        }
    }
}