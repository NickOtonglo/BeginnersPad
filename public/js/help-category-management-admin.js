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
    if(validateEntrySubmitForm){
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
            $('#alert_name').html('<li>Required</li>').show();
            $('#name').addClass('alert alert-danger');
        }
        if (document.getElementById("priority").value.trim() == "") {
            $('#alert_priority').html('<li>Required</li>').show();
            $('#priority').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (document.getElementById("name").value.trim().length > 50) {
            $('#alert_name').html('<li>Title should contain 50 characters or less</li>').show();
            $('#name').addClass('alert alert-danger');
            return false;
        } if (document.getElementById("description").value.trim().length > 1000) {
            $('#alert_description').html('<li>Description should contain 1000 characters or less</li>').show();
            $('#description').addClass('alert alert-danger');
            return false;
        } else {
            return true;
        }
    }
}

function hideEntrySubmitAlert() {
    $('#name').on('input', function () {
        $('#alert_name').hide();
        $('#name').removeClass('alert alert-danger');
    });
    // $('#description').on('input', function () {
    //     $('#alert_description').hide();
    //     $('#description').removeClass('alert alert-danger');
    // });
    $('#priority').on('input', function () {
        $('#alert_priority').hide();
        $('#priority').removeClass('alert alert-danger');
    });
}

function clearAlerts() {
    $('#alert_name').hide();
    $('#name').removeClass('alert alert-danger');
    // $('#alert_description').hide();
    // $('#description').removeClass('alert alert-danger');
    $('#alert_priority').hide();
    $('#priority').removeClass('alert alert-danger');
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
    $('#btn_create').removeClass('hidden');
    $('#btn_delete').addClass('hidden');
    $('#btn_update').addClass('hidden');
}

function setUpdateReady(){
    $('#modalLabel').text('View Entry');
    $('#btn_create').addClass('hidden');
    $('#btn_delete').removeClass('hidden');
    $('#btn_update').removeClass('hidden');
}

function setUpdateAction(){
    return '/help/categories/'+obj;
}