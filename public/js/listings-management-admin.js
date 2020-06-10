$(document).ready(function () {
    $('.modal').on('hide.bs.modal', function (e) {
        clearAlerts();
    });
});

hideActionAlert();

$('#btn_confirm').click(function (e){
    checkAction();
});

$('#btn_act').click(function (e){
    validateActionForm();
});

$('#btn_remove_bookmark').click(function (e){
    if (confirm("Remove bookmark?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#action_form').on('submit', function(e) {
    if (confirm("Are you sure you want to "+$("#listing_action :selected").val()+" this listing?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

// $('#btn_confirm').click(function (e) {
//     if (confirm("This action will submit this property to representatives and/or administrators for approval. This means that they might reach out to you to request extra information about your listing that may be necessary for your property to be approved on the platform.\nThe property may also be rejected for one or various reasons, and you will be notified with valid reason if this is the case. Are you sure you want to proceed?")) {
//         e.stopPropagation();
//         return true;
//     } else {
//         e.stopPropagation();
//         return false;
//     }
// });

// $('#btn_revoke').click(function (e) {
//     if (confirm("Are you sure you want to withdraw submission of this property for approval?")) {
//         e.stopPropagation();
//         return true;
//     } else {
//         e.stopPropagation();
//         return false;
//     }
// });

function validateActionForm() {
    if (document.getElementById("action_reason").value.trim() == "") {
        $('#alert_action_reason').html('<li>Required</li>').show();
        $('#action_reason').addClass('alert alert-danger');
        return false;
    } else {
        if ($("#listing_action :selected").val() != 'suspend' && $("#listing_action :selected").val() != 'reject') {
            $('#alert_action_reason').html('<li>A reason can be submitted only with a suspension or rejection</li>').show();
            $('#action_reason').addClass('alert alert-danger');
            return false;
        } else {
            $('#action_form').trigger('submit');
        }
    }
}

function checkAction() {
    if($('#listing_action :selected').val() == 'approve' || $('#listing_action :selected').val() == 'delete'){
        $('#action_form').trigger('submit');
    } else if ($('#listing_action :selected').val() == '') {
        alert('No action selected. Select an action to perform.');
    } else {
        $('#modalAction').modal('show');
    }
}

function hideActionAlert() {
    $('#action_reason').on('input', function () {
        $('#alert_action_reason').hide();
        $('#action_reason').removeClass('alert alert-danger');
    });
}

function clearAlerts() {
    $('#alert_action_reason').hide();
    $('#action_reason').removeClass('alert alert-danger');
}