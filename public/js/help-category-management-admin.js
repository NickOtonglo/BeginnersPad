// let entryId;
// // let zoneObj = {!! json_encode($zone)!!};
// let initUrl = "//help/categories/" + entryId.id;
// let actionUrl;

$('.modal').on('hide.bs.modal', function (e) {
    clearAlerts();
});

hideEntryCreateAlert();
hideEntryUpdateAlert();

$('.row-clickable').on('click',function () {
    $('#modalViewCategory').modal('show')
});

$('#btn_add_entry').on('click',function() {
    $('#modalNewCategory').modal('show');
});

$('#btn_create').on('click',function(e){
    if (confirm("Are you sure you want to add this category?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_update').on('click',function(e){
    if (confirm("Are you sure you want to edit this entry?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_delete').on('click',function(e){
    if (confirm("Are you sure you want to delete this entry?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});


function validateEntryCreateForm() {
    if (document.getElementById("name_create").value.trim() == ""
        || document.getElementById("priority_create").value.trim() == "") {
        if (document.getElementById("name_create").value.trim() == "") {
            $('#alert_name_create').html('<li>Required</li>').show();
            $('#name_create').addClass('alert alert-danger');
        }
        if (document.getElementById("priority_create").value.trim() == "") {
            $('#alert_priority_create').html('<li>Required</li>').show();
            $('#priority_create').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (document.getElementById("name_create").value.trim().length > 50) {
            $('#alert_name_create').html('<li>Title should contain 50 characters or less</li>').show();
            $('#name_create').addClass('alert alert-danger');
            return false;
        } if (document.getElementById("description_create").value.trim().length > 1000) {
            $('#alert_description_create').html('<li>Description should contain 1000 characters or less</li>').show();
            $('#description_create').addClass('alert alert-danger');
            return false;
        } else {
            return true;
        }
    }
}

function validateEntryUpdateForm() {
    if (document.getElementById("name_create").value.trim() == ""
        || document.getElementById("priority_create").value.trim() == "") {
        if (document.getElementById("name_create").value.trim() == "") {
            $('#alert_name_create').html('<li>Required</li>').show();
            $('#name_create').addClass('alert alert-danger');
        }
        if (document.getElementById("priority_create").value.trim() == "") {
            $('#alert_priority_create').html('<li>Required</li>').show();
            $('#priority_create').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (document.getElementById("name_create").value.trim().length > 50) {
            $('#alert_name_create').html('<li>Title should contain 50 characters or less</li>').show();
            $('#name_create').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("description_create").value.trim().length > 1000) {
            $('#alert_description_create').html('<li>Description should contain 1000 characters or less</li>').show();
            $('#description_create').addClass('alert alert-danger');
            return false;
        } else {
            return true;
        }
    }
}

function hideEntryCreateAlert() {
    $('#name_create').on('input', function () {
        $('#alert_name_create').hide();
        $('#name_create').removeClass('alert alert-danger');
    });
    // $('#description_create').on('input', function () {
    //     $('#alert_description_create').hide();
    //     $('#description_create').removeClass('alert alert-danger');
    // });
    $('#priority_create').on('input', function () {
        $('#alert_priority_create').hide();
        $('#priority_create').removeClass('alert alert-danger');
    });
}

function hideEntryUpdateAlert() {
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
    // Create form
    $('#alert_name_create').hide();
    $('#name_create').removeClass('alert alert-danger');
    // $('#alert_description_create').hide();
    // $('#description_create').removeClass('alert alert-danger');
    $('#alert_priority_create').hide();
    $('#priority_create').removeClass('alert alert-danger');

    // Update form
    $('#alert_name').hide();
    $('#name').removeClass('alert alert-danger');
    // $('#alert_description').hide();
    // $('#description').removeClass('alert alert-danger');
    $('#alert_priority').hide();
    $('#priority').removeClass('alert alert-danger');
}

function populateEntryUpdateForm(arg) {
    try {
        let entry = JSON.parse(arg);
        document.getElementById("name").value = entry.name;
        document.getElementById("description").value = entry.description;
        document.getElementById("priority").value = entry.priority;
        document.getElementById("timestamp").value = entry.created_at;
        // actionUrl = initUrl + "/" + entry.id + "/edit";
    } catch (error) {

    }
}