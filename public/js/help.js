$('#btn_submit').on('click', function(e) {
    if(validateSubmitForm()){
        if (confirm("Are you sure you want to submit your ticket?")) {
            e.stopPropagation();
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    } else {
        return false
    }
});

hideEntrySubmitAlert();

function validateSubmitForm() {
    if (document.getElementById("email").value.trim() == ""
        || document.getElementById("category").value.trim() == ""
        || document.getElementById("description").value.trim() == "") {
        if (document.getElementById("email").value.trim() == "") {
            $('#alert_email').html('<li>Required</li>').show();
            $('#email').addClass('alert alert-danger');
        }
        if (document.getElementById("category").value.trim() == "") {
            $('#alert_category').html('<li>Required</li>').show();
            $('#category').addClass('alert alert-danger');
        }
        if (document.getElementById("description").value.trim() == "") {
            $('#alert_description').html('<li>Required</li>').show();
            $('#description').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (!validateEmail(document.getElementById("email").value.trim())) {
            $('#alert_email').html('<li>Email must be in the format "name@example.com"</li>').show();
            $('#email').addClass('alert alert-danger');
            return false;
        } if (document.getElementById("description").value.trim().length > 15000) {
            $('#alert_description').html('<li>Description should contain 15000 characters or less</li>').show();
            $('#description').addClass('alert alert-danger');
            return false;
        } else {
            return true;
        }
    }
}

function validateEmail(mail){
    var mailFormat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (mail.match(mailFormat)){
        return true;
    } else {
        return false;
    } 
}

function hideEntrySubmitAlert() {
    $('#email').on('input', function () {
        $('#alert_email').hide();
        $('#email').removeClass('alert alert-danger');
    });
    $('#category').on('input', function () {
        $('#alert_category').hide();
        $('#category').removeClass('alert alert-danger');
    });
    $('#description').on('input', function () {
        $('#alert_description').hide();
        $('#description').removeClass('alert alert-danger');
    });
}