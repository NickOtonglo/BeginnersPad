const realBtn = document.getElementById('images_solo');
const newBtn = document.getElementById('images_virtual');
// const newText = document.getElementById('images_text');
const newText = document.getElementById('btn_add_img');

$('#checkbox_deposit').on('change',function () {
    if (this.checked) {
        $('#form_deposit').attr("hidden",false);
    } else {
        $('#form_deposit').attr("hidden",true);
    }
});

$('#checkbox_description').on('change',function () {
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

// $('#btn_create').on('click',function (e) {
//     if (validateEntryCreateForm()){
//         if (confirm("Are you sure you want to create this listing entry?")) {
//             e.stopPropagation();
//             return true;
//         } else {
//             e.stopPropagation();
//             return false;
//         }
//     }
// });

$('.btn-entry-edit').on('click',function (e) {
    if (confirm("Are you sure you want to perform this action?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('.btn-entry-delete').on('click',function (e) {
    if (confirm("Are you sure you want to delete this entry?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#images_virtual').on('click',function (e){
    customImageUploadButton();
});

$('#btn_add_img').on('click',function (){
    // if($("input:file")[0].files.length === 0)
    if(!realBtn.value){
        customImageUploadButton();
    } else {
        $('#image_form').trigger('submit');
    }
});

$('#image_form').on('submit', function(e) {
    if (confirm("Are you sure you want to proceed with the upload?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#images_solo').on('change',function (){
    if(realBtn.value){
        // newText.innerHTML = 'Upload '+realBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
        $("#btn_add_img").prop('value', 'Upload');
        var numFiles = $("input:file")[0].files.length;
        if(numFiles>1){
            // newText.innerHTML = 'Upload '+numFiles+' images';
            $("#btn_add_img").prop('value', 'Upload');
        }
    } else {
        newText.innerHTML = 'No image selected';
    }
});

$('#btn_thumb_faux').on('click',function (){
    if($('#btn_thumb_real').val()){
        $('#thumb_form').trigger('submit');
    } else {
        $('#btn_thumb_real').trigger('click',);
    }
});

$('#btn_thumb_real').on('change',function (){
    if($('#btn_thumb_real').val()){
        // newText.innerHTML = 'Upload '+realBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
        $("#btn_thumb_faux").prop('value', 'Save');
        var numFiles = $("input:file")[0].files.length;
    }
});

$('#thumb_form').on('submit', function(e) {
    if (confirm("Are you sure you want to change the thumbnail?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
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

var loadFileCustom = function (event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('images_virtual');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

var loadFileThumb = function (event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('img_thumb');
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
            $('#alert_name_entry_create').attr("hidden",false);
            $('#listing_name').addClass('bp-input-validation-error');
        }
        if (document.getElementById("floor_area").value.trim() == "") {
            $('#alert_floor_area_entry_create').html('<li>Required</li>').show();
            $('#alert_floor_area_entry_create').attr("hidden",false);
            $('#floor_area').addClass('bp-input-validation-error');
        }
        if ((document.getElementById("entry_price").value.trim() == "") && listingObj.price == null) {
            $('#alert_price_entry_create').html('<li>Required</li>').show();
            $('#alert_price_entry_create').attr("hidden",false);
            $('#entry_price').addClass('bp-input-validation-error');
        }
        return false;
    } else {
        if (document.getElementById("checkbox_deposit").checked && document.getElementById("initial_deposit").value.trim() == "") {
            $('#alert_initial_deposit_entry_create').html('<li>Required</li>').show();
            $('#alert_initial_deposit_entry_create').attr("hidden",false);
            $('#initial_deposit').addClass('bp-input-validation-error');
            return false;
        } else if (document.getElementById("checkbox_deposit").checked && document.getElementById("initial_deposit_period").value.trim() == "") {
            $('#alert_deposit_period_entry_create').html('<li>Required</li>').show();
            $('#alert_deposit_period_entry_create').attr("hidden",false);
            $('#initial_deposit_period').addClass('bp-input-validation-error');
            return false;
        } else if (document.getElementById("listing_name").value.trim().length > 50) {
            $('#alert_name_entry_create').html('<li>Name should contain 100 characters or less</li>').show();
            $('#alert_name_entry_create').attr("hidden",false);
            $('#listing_name').addClass('bp-input-validation-error');
            return false;
        } else if (document.getElementById("entry_description").value.trim().length > 5000) {
            $('#alert_desc_entry_create').html('<li>Description should contain 5000 characters or less</li>').show();
            $('#alert_desc_entry_create').attr("hidden",false);
            $('#entry_description').addClass('bp-input-validation-error');
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
        $('#alert_name_entry_create').attr("hidden",true);
        $('#alert_name_entry_create').attr("hidden",true);
        $('#listing_name').removeClass('bp-input-validation-error');
    });
    $('#entry_description').on('input', function () {
        $('#alert_desc_entry_create').attr("hidden",true);
        $('#alert_desc_entry_create').attr("hidden",true);
        $('#entry_description').removeClass('bp-input-validation-error');
    });
    $('#floor_area').on('input', function () {
        $('#alert_floor_area_entry_create').attr("hidden",true);
        $('#alert_floor_area_entry_create').attr("hidden",true);
        $('#floor_area').removeClass('bp-input-validation-error');
    });
    $('#disclaimer').on('input', function () {
        $('#alert_disclaimer_entry_create').attr("hidden",true);
        $('#alert_disclaimer_entry_create').attr("hidden",true);
        $('#disclaimer').removeClass('bp-input-validation-error');
    });
    $('#features').on('input', function () {
        $('#alert_features_entry_create').attr("hidden",true);
        $('#alert_features_entry_create').attr("hidden",true);
        $('#features').removeClass('bp-input-validation-error');
    });
    $('#initial_deposit').on('input', function () {
        $('#alert_initial_deposit_entry_create').attr("hidden",true);
        $('#alert_initial_deposit_entry_create').attr("hidden",true);
        $('#initial_deposit').removeClass('bp-input-validation-error');
    });
    $('#initial_deposit_period').on('input', function () {
        $('#alert_deposit_period_entry_create').attr("hidden",true);
        $('#alert_deposit_period_entry_create').attr("hidden",true);
        $('#initial_deposit_period').removeClass('bp-input-validation-error');
    });
    $('#entry_price').on('input', function () {
        $('#alert_price_entry_create').attr("hidden",true);
        $('#alert_price_entry_create').attr("hidden",true);
        $('#entry_price').removeClass('bp-input-validation-error');
    });
}

function clearAlerts() {
    $('#alert_name_entry_create').attr("hidden",true);
    $('#alert_name_entry_create').attr("hidden",true);
    $('#listing_name').removeClass('bp-input-validation-error');
    $('#alert_desc_entry_create').attr("hidden",true);
    $('#alert_desc_entry_create').attr("hidden",true);
    $('#entry_description').removeClass('bp-input-validation-error');
    $('#alert_floor_area_entry_create').attr("hidden",true);
    $('#alert_floor_area_entry_create').attr("hidden",true);
    $('#floor_area').removeClass('bp-input-validation-error');
    $('#alert_disclaimer_entry_create').attr("hidden",true);
    $('#alert_disclaimer_entry_create').attr("hidden",true);
    $('#disclaimer').removeClass('bp-input-validation-error');
    $('#alert_features_entry_create').attr("hidden",true);
    $('#alert_features_entry_create').attr("hidden",true);
    $('#features').removeClass('bp-input-validation-error');
    $('#alert_initial_deposit_entry_create').attr("hidden",true);
    $('#alert_initial_deposit_entry_create').attr("hidden",true);
    $('#initial_deposit').removeClass('bp-input-validation-error');
    $('#alert_deposit_period_entry_create').attr("hidden",true);
    $('#alert_deposit_period_entry_create').attr("hidden",true);
    $('#initial_deposit_period').removeClass('bp-input-validation-error');
    $('#alert_price_entry_create').attr("hidden",true);
    $('#alert_price_entry_create').attr("hidden",true);
    $('#entry_price').removeClass('bp-input-validation-error');
}

function populateEntryUpdateForm(ent){
    try {
        let entry = JSON.parse(ent);
        document.getElementById("listing_name").value = entry.listing_name;
        document.getElementById("entry_description").value = entry.description;
        document.getElementById("floor_area").value = entry.floor_area;
        document.getElementById("disclaimer").value = entry.disclaimer;
        document.getElementById("features").value = entry.features;
        document.getElementById("entry_price").value = entry.price;
        if((entry.initial_deposit != null || entry.initial_deposit_period != null) && (entry.initial_deposit != 0 || entry.initial_deposit_period != 0)){
            document.getElementById("checkbox_deposit").checked = true;
            document.getElementById("initial_deposit").value = entry.initial_deposit;
            document.getElementById("initial_deposit_period").value = entry.initial_deposit_period;
            $('#form_deposit').attr("hidden",false);
        }
        // document.getElementById('output').src = '/images/listings/'+listing.id+'/thumbnails/'+entry.thumbnail;
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

function customImageUploadButton(){
    realBtn.click();
}