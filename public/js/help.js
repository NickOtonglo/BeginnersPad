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
            $('#alert_email').html('<li>Required</li>').attr("hidden",false);
            $('#email').addClass('bp-input-validation-error');
        }
        if (document.getElementById("category").value.trim() == "") {
            $('#alert_category').html('<li>Required</li>').attr("hidden",false);
            $('#category').addClass('bp-input-validation-error');
        }
        if (document.getElementById("description").value.trim() == "") {
            $('#alert_description').html('<li>Required</li>').attr("hidden",false);
            $('#description').addClass('bp-input-validation-error');
        }
        return false;
    } else {
        if (!validateEmail(document.getElementById("email").value.trim())) {
            $('#alert_email').html('<li>Email must be in the format "name@example.com"</li>').attr("hidden",false);
            $('#email').addClass('bp-input-validation-error');
            return false;
        } if (document.getElementById("description").value.trim().length > 15000) {
            $('#alert_description').html('<li>Description should contain 15000 characters or less</li>').attr("hidden",false);
            $('#description').addClass('bp-input-validation-error');
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
        $('#alert_email').attr("hidden",true);
        $('#email').removeClass('bp-input-validation-error');
    });
    $('#category').on('input', function () {
        $('#alert_category').attr("hidden",true);
        $('#category').removeClass('bp-input-validation-error');
    });
    $('#description').on('input', function () {
        $('#alert_description').attr("hidden",true);
        $('#description').removeClass('bp-input-validation-error');
    });
}