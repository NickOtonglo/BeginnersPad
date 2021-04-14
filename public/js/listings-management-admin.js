// $(document).on('ready',function () {
//     $('.modal').on('hide.bs.modal', function (e) {
//         clearAllAlerts();
//     });
// });

hideActionAlert();

$('.modal').on('hide.bs.modal', function (e) {
    clearAllAlerts();
});

$('#btn_confirm').on('click',function (e){
    checkAction();
});

$('#btn_act').on('click',function (e){
    validateActionForm();
});

$('#btn_remove_bookmark').on('click',function (e){
    if (confirm("Remove bookmark?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#action_form').on('submit', function(e) {
    if ($("#listing_action :selected").val() == '' || $("#listing_action :selected").val() == null){
        return false;
    }
    if (confirm("Are you sure you want to "+$("#listing_action :selected").val()+" this listing?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

function validateActionForm() {
    if (document.getElementById("action_reason").value.trim() == "") {
        $('#alert_action_reason').html('<li>Required</li>').show();
        $('#alert_action_reason').attr("hidden",false);
        $('#action_reason').addClass('bp-input-validation-error');
        return false;
    } else {
        if ($("#listing_action :selected").val() != 'suspend' && $("#listing_action :selected").val() != 'reject') {
            $('#alert_action_reason').html('<li>A reason can only be submitted when issuing a suspension or rejection</li>').show();
            $('#alert_action_reason').attr("hidden",false);
            $('#action_reason').addClass('bp-input-validation-error');
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
    $('#listing_action').on('input',function () {
        if ($('#listing_action :selected').val() != ''){
            $('#listing_action').addClass('text-capitalize');
        } else {
            $('#listing_action').removeClass('text-capitalize');
        }
    });
    $('#action_reason').on('input', function () {
        $('#alert_action_reason').attr("hidden",true);
        $('#action_reason').removeClass('bp-input-validation-error');
    });
}

function clearAllAlerts() {
    $('#alert_action_reason').attr("hidden",true);
    $('#action_reason').removeClass('bp-input-validation-error');
}