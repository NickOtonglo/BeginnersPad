// let entryId;
// // let zoneObj = {!! json_encode($zone)!!};
// let initUrl = "//help/categories/" + entryId.id;
// let actionUrl;

let obj;

$('.modal').on('hide.bs.modal', function (e) {
    clearAlerts();
});

hideEntrySubmitAlert();

$('.row-clickable').on('click',function () {
    setUpdateReady();
    $('#modal').modal('show');
});

$('#btn_add_entry').on('click',function() {
    clearEntrySubmitForm();
    setCreateReady();
    $('#modal').modal('show');
});

$('#btn_create').on('click',function(e){
    if(validateEntrySubmitForm()){
        if (confirm("Are you sure you want to add this category?")) {
            e.stopPropagation();
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    }
});

$('#btn_update').on('click',function(e){
    if(validateEntrySubmitForm()){
        if (confirm("Are you sure you want to update this entry?")) {
            $('#entryForm').attr('action',setUpdateAction());
            e.stopPropagation();
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    }
});

$('#btn_delete').on('click',function(e){
    if (confirm("Are you sure you want to delete this entry?")) {
        $('#entryForm').attr('action',setUpdateAction());
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});


function validateEntrySubmitForm() {
    if (document.getElementById("name").value.trim() == ""
        || document.getElementById("priority").value.trim() == "") {
        if (document.getElementById("name").value.trim() == "") {
            $('#alert_name').html('<li>Required</li>').attr("hidden",false);
            $('#name').addClass('bp-input-validation-error');
        }
        if (document.getElementById("priority").value.trim() == "") {
            $('#alert_priority').html('<li>Required</li>').attr("hidden",false);
            $('#priority').addClass('bp-input-validation-error');
        }
        return false;
    } else {
        if (document.getElementById("name").value.trim().length > 50) {
            $('#alert_name').html('<li>Title should contain 50 characters or less</li>').attr("hidden",false);
            $('#name').addClass('bp-input-validation-error');
            return false;
        } if (document.getElementById("description").value.trim().length > 1000) {
            $('#alert_description').html('<li>Description should contain 1000 characters or less</li>').attr("hidden",false);
            $('#description').addClass('bp-input-validation-error');
            return false;
        } else {
            return true;
        }
    }
}

function hideEntrySubmitAlert() {
    $('#name').on('input', function () {
        $('#alert_name').attr("hidden",true);
        $('#name').removeClass('bp-input-validation-error');
    });
    // $('#description').on('input', function () {
    //     $('#alert_description').attr("hidden",true);
    //     $('#description').removeClass('bp-input-validation-error');
    // });
    $('#priority').on('input', function () {
        $('#alert_priority').attr("hidden",true);
        $('#priority').removeClass('bp-input-validation-error');
    });
}

function clearAlerts() {
    $('#alert_name').attr("hidden",true);
    $('#name').removeClass('bp-input-validation-error');
    // $('#alert_description').attr("hidden",true);
    // $('#description').removeClass('bp-input-validation-error');
    $('#alert_priority').attr("hidden",true);
    $('#priority').removeClass('bp-input-validation-error');
}

function populateEntrySubmitForm(arg) {
    try {
        let entry = JSON.parse(arg);
        document.getElementById("name").value = entry.name;
        document.getElementById("description").value = entry.description;
        document.getElementById("priority").value = entry.priority;
        document.getElementById("timestamp").value = entry.created_at;
        // actionUrl = initUrl + "/" + entry.id + "/edit";
        obj = entry.id;
    } catch (error) {

    }
}

function clearEntrySubmitForm(){
    $('#entryForm').trigger('reset');
}

function setCreateReady(){
    $('#modalLabel').text('Add Entry');
    $('#btn_create').attr("hidden",false);;
    $('#btn_delete').attr("hidden",true);
    $('#btn_update').attr("hidden",true);
}

function setUpdateReady(){
    $('#modalLabel').text('View Entry');
    $('#btn_create').attr("hidden",true);
    $('#btn_delete').attr("hidden",false);;
    $('#btn_update').attr("hidden",false);;
}

function setUpdateAction(){
    return '/help/categories/'+obj;
}