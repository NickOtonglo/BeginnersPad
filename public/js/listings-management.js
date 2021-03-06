tooltip = 'If this option is checked, you will be required to set the rent price only once for all the listings that will fall under this property.';
$('#checkbox-tag').attr('title',tooltip);

$('#checkbox').on('change',function () {
    if (this.checked) {
        $('#form_price').attr("hidden",false);
        tooltip = 'If this option is unchecked, you will be required to set the rent price for each individual listing that will fall under this property seperately.';
    } else {
        $('#form_price').attr("hidden",true);
        tooltip = 'If this option is checked, you will be required to set the rent price only once for all the listings that will fall under this property.';
    }
    $('#checkbox-tag').attr('title',tooltip);
});
$('#checkbox-tag').on('mouseenter',function () {
    $('#checkbox-tag').tooltip('show');
});

$('#checkbox-tag').on('click',function () {
    $('#checkbox-tag').tooltip('show');
});

$('.modal').on('hide.bs.modal', function (e) {
    clearAlerts();
});
// $('.modal').on('shown.bs.modal', function (e){
//     populateListingUpdateForm();
// });

hideListingCreateAlert();

$('#btn_submit').on('click',function (e) {
    if (confirm("This action will submit this property to representatives and/or administrators for approval. This means that they might reach out to you to request extra information about your listing that may be necessary for your property to be approved on the platform.\nThe property may also be rejected for one or various reasons, and you will be notified with valid reason if this is the case. Are you sure you want to proceed?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_revoke').on('click',function (e) {
    if (confirm("Are you sure you want to withdraw submission of this property for approval?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_thumb_listing_faux').on('click',function (e) {
    if($('#btn_thumb_listing_real').val()){
        $('#listing_thumb_form').trigger('submit');
    } else {
        $('#btn_thumb_listing_real').click();
    }
});

$('#btn_thumb_listing_real').on('change',function(e){
    if($('#btn_thumb_listing_real').val()){
        // newText.innerHTML = 'Upload '+realBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
        $("#btn_thumb_listing_faux").prop('value', 'Save');
        var numFiles = $("input:file")[0].files.length;
    }
});

$('#listing_thumb_form').on('submit', function(e) {
    if (confirm("Are you sure you want to change the thumbnail?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

var loadFile = function (event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('output');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

var loadListingThumb = function (event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('listing_img_thumb');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

function validateListingCreateForm() {
    if (document.getElementById("property_name").value.trim() == ""
        || document.getElementById("description").value.trim() == ""
        || document.getElementById("zone_entry_id").value.trim() == ""
        || document.getElementById("lat").value.trim() == ""
        || document.getElementById("lng").value.trim() == ""
        || document.getElementById("listing_type").value.trim() == ""
        || document.getElementById("stories").value.trim() == "") {
        if (document.getElementById("property_name").value.trim() == "") {
            $('#alert_name_listing_create').html('<li>Required</li>').show();
            $('#alert_name_listing_create').attr("hidden",false);
            $('#property_name').addClass('bp-input-validation-error');
        }
        if (document.getElementById("description").value.trim() == "") {
            $('#alert_desc_listing_create').html('<li>Required</li>').show();
            $('#alert_desc_listing_create').attr("hidden",false);
            $('#description').addClass('bp-input-validation-error');
        }
        if (document.getElementById("zone_entry_id").value.trim() == "") {
            $('#alert_subzone_listing_create').html('<li>Required</li>').show();
            $('#alert_subzone_listing_create').attr("hidden",false);
            $('#zone_entry_id').addClass('bp-input-validation-error');
        }
        if (document.getElementById("lat").value.trim() == "") {
            $('#alert_lat_listing_create').html('<li>Required</li>').show();
            $('#alert_lat_listing_create').attr("hidden",false);
            $('#lat').addClass('bp-input-validation-error');
        }
        if (document.getElementById("lng").value.trim() == "") {
            $('#alert_lng_listing_create').html('<li>Required</li>').show();
            $('#alert_lng_listing_create').attr("hidden",false);
            $('#lng').addClass('bp-input-validation-error');
        }
        if (document.getElementById("listing_type").value.trim() == "") {
            $('#alert_type_listing_create').html('<li>Required</li>').show();
            $('#alert_type_listing_create').attr("hidden",false);
            $('#listing_type').addClass('bp-input-validation-error');
        }
        if (document.getElementById("stories").value.trim() == "") {
            $('#alert_stories_listing_create').html('<li>Required</li>').show();
            $('#alert_stories_listing_create').attr("hidden",false);
            $('#stories').addClass('bp-input-validation-error');
        }
        return false;
    } else {
        if (document.getElementById("checkbox").checked && document.getElementById("price").value.trim() == "") {
            $('#alert_price_listing_create').html('<li>Required</li>').show();
            $('#alert_price_listing_create').attr("hidden",false);
            $('#price').addClass('bp-input-validation-error');
            return false;
        } else if (document.getElementById("property_name").value.trim().length > 50) {
            $('#alert_name_listing_create').html('<li>Name should contain 100 characters or less</li>').show();
            $('#alert_name_listing_create').attr("hidden",false);
            $('#property_name').addClass('bp-input-validation-error');
            return false;
        } else if (document.getElementById("description").value.trim().length > 5000) {
            $('#alert_desc_listing_create').html('<li>Description should contain 5000 characters or less</li>').show();
            $('#alert_desc_listing_create').attr("hidden",false);
            $('#description').addClass('bp-input-validation-error');
            return false;
        } else {
            if(!document.getElementById("checkbox").checked){
                document.getElementById("price").value = null;
            }
            return true;
        }
    }
}

function hideListingCreateAlert() {
    $('#property_name').on('input', function () {
        $('#alert_name_listing_create').attr("hidden",true);
        $('#property_name').removeClass('bp-input-validation-error');
    });
    $('#description').on('input', function () {
        $('#alert_desc_listing_create').attr("hidden",true);
        $('#description').removeClass('bp-input-validation-error');
    });
    $('#zone_entry_id').on('input', function () {
        $('#alert_subzone_listing_create').attr("hidden",true);
        $('#zone_entry_id').removeClass('bp-input-validation-error');
    });
    $('#lat').on('input', function () {
        $('#alert_lat_listing_create').attr("hidden",true);
        $('#lat').removeClass('bp-input-validation-error');
    });
    $('#lng').on('input', function () {
        $('#alert_lng_listing_create').attr("hidden",true);
        $('#lng').removeClass('bp-input-validation-error');
    });
    $('#listing_type').on('input', function () {
        $('#alert_type_listing_create').attr("hidden",true);
        $('#listing_type').removeClass('bp-input-validation-error');
    });
    $('#stories').on('input', function () {
        $('#alert_stories_listing_create').attr("hidden",true);
        $('#stories').removeClass('bp-input-validation-error');
    });
    $('#price').on('input', function () {
        $('#alert_price_listing_create').attr("hidden",true);
        $('#price').removeClass('bp-input-validation-error');
    });
}

function clearAlerts() {
    $('#alert_name_listing_create').attr("hidden",true);
    $('#property_name').removeClass('bp-input-validation-error');
    $('#alert_desc_listing_create').attr("hidden",true);
    $('#description').removeClass('bp-input-validation-error');
    $('#alert_subzone_listing_create').attr("hidden",true);
    $('#zone_entry_id').removeClass('bp-input-validation-error');
    $('#alert_lat_listing_create').attr("hidden",true);
    $('#lat').removeClass('bp-input-validation-error');
    $('#alert_lng_listing_create').attr("hidden",true);
    $('#lng').removeClass('bp-input-validation-error');
    $('#alert_type_listing_create').attr("hidden",true);
    $('#listing_type').removeClass('bp-input-validation-error');
    $('#alert_stories_listing_create').attr("hidden",true);
    $('#stories').removeClass('bp-input-validation-error');
    $('#alert_price_listing_create').attr("hidden",true);
    $('#price').removeClass('bp-input-validation-error');
}

function populateListingUpdateForm(lst){
    try {
        let listing = JSON.parse(removeInvalidChars(lst));
        document.getElementById("property_name").value = listing.property_name;
        document.getElementById("description").value = listing.description;
        document.getElementById("zone_entry_id").value = listing.zone_entry_id;
        document.getElementById("lat").value = listing.lat;
        document.getElementById("lng").value = listing.lng;
        document.getElementById("listing_type").value = listing.listing_type;
        document.getElementById("stories").value = listing.stories;
        if(listing.price != null){
            document.getElementById("checkbox").checked = true;
            document.getElementById("price").value = listing.price;
            $('#form_price').show();
        }
        document.getElementById('output').src = '/images/listings/'+listing.id+'/thumbnails/'+listing.thumbnail;
        
        initLatListingUpdate = listing.lat;
        initLngListingUpdate = listing.lng;
        initMapListingUpdate();
    } catch (error) {
        // console.log(error+'\n'+lst);
    }
}

function removeInvalidChars(collection){
    // preserve newlines, etc - use valid JSON
    collection = collection.replace(/\\n/g, "\\n")  
                            .replace(/\\'/g, "\\'")
                            .replace(/\\"/g, '\\"')
                            .replace(/\\&/g, "\\&")
                            .replace(/\\r/g, "\\r")
                            .replace(/\\t/g, "\\t")
                            .replace(/\\b/g, "\\b")
                            .replace(/\\f/g, "\\f");
    // remove non-printable and other non-valid JSON chars
    collection = collection.replace(/[\u0000-\u0019]+/g,"");
    // console.log(collection);
    return collection;
}