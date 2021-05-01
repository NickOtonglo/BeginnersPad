$('#username').on('keydown', function(e) {
    if (e.key === ' '){
        return false; 
    }
});

$('#btn_submit').on('click', function (e) {
    if(validateForm()){
        if(confirm('Are you sure you want to create your account?')){
            e.stopPropagation();
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    }
});

hideAlerts();

function validateForm(){
    if (document.getElementById("name").value.trim() == ""
        || document.getElementById("email").value.trim() == ""
        || document.getElementById("password").value.trim() == ""
        || document.getElementById("password_confirmation").value.trim() == ""
        || document.getElementById("telephone").value.trim() == ""
        || document.getElementById("username").value.trim() == ""
        || !document.getElementById("terms").checked) {
        if (document.getElementById("name").value.trim() == "") {
            $('#alert_name').html('<li>Required</li>').attr("hidden",false);
            $('#name').addClass('bp-input-validation-error');
        }
        if (document.getElementById("email").value.trim() == "") {
            $('#alert_email').html('<li>Required</li>').attr("hidden",false);
            $('#email').addClass('bp-input-validation-error');
        }
        if (document.getElementById("password").value.trim() == "") {
            $('#alert_password').html('<li>Required</li>').attr("hidden",false);
            $('#password').addClass('bp-input-validation-error');
        }
        if (document.getElementById("password_confirmation").value.trim() == "") {
            $('#alert_password_confirmation').html('<li>Required</li>').attr("hidden",false);
            $('#password_confirmation').addClass('bp-input-validation-error');
        }
        if (document.getElementById("telephone").value.trim() == "") {
            $('#alert_phone').html('<li>Required</li>').attr("hidden",false);
            $('#telephone').addClass('bp-input-validation-error');
        }
        if (document.getElementById("username").value.trim() == "") {
            $('#alert_username').html('<li>Required</li>').attr("hidden",false);
            $('#username').addClass('bp-input-validation-error');
        }
        if (!document.getElementById("terms".checked)){
            $('#alert_terms').html('<li>Terms and Conditions must be agreed to</li>').attr("hidden",false);
        }
        return false;
    } else {
        if (document.getElementById("name").value.trim().length > 255) {
            $('#alert_name').html('<li>Name should contain between 2 and 255 characters</li>').attr("hidden",false);
            $('#name').addClass('bp-input-validation-error');
            return false;
        } else if (document.getElementById("email").value.trim().length > 255) {
            $('#alert_email').html('<li>Email must contain not more than 255 characters</li>').attr("hidden",false);
            $('#email').addClass('bp-input-validation-error');
            return false;
        } else if (!validateEmail(document.getElementById("email").value.trim())) {
            $('#alert_email').html('<li>Email must be in the format "name@example.com"</li>').attr("hidden",false);
            $('#email').addClass('bp-input-validation-error');
            return false;
        } else if (!validatePassword(document.getElementById("password").value.trim())) {
            $('#alert_password').html('<li>Password must be of at least 6 characters, and consist of no spaces</li>').attr("hidden",false);
            $('#password').addClass('bp-input-validation-error');
            return false;
        } else if (document.getElementById("password").value.trim() != document.getElementById("password_confirmation").value.trim()) {
            $('#alert_password').html('<li>These passwords do not match!</li>').attr("hidden",false);
            $('#password').addClass('bp-input-validation-error');
            $('#password_confirmation').addClass('bp-input-validation-error');
            return false;
        } else if (document.getElementById("telephone").value.trim().length < 10 || document.getElementById("telephone").value.trim().length > 13) {
            $('#alert_phone').html('<li>Phone number must contain between 10 and 13 characters</li>').attr("hidden",false);
            $('#telephone').addClass('bp-input-validation-error');
            return false;
        } else if (!validatePhone(document.getElementById("telephone").value.trim())) {
            $('#alert_phone').html('<li>Phone number must be in the format "+254XXXXXXXXX"</li>').attr("hidden",false);
            $('#telephone').addClass('bp-input-validation-error');
            return false;
        }  else {
            return true;
        }
    }
}

function hideAlerts(){
    $('#name').on('input', function () {
        $('#alert_name').attr("hidden",true);
        $('#name').removeClass('bp-input-validation-error');
    });
    $('#email').on('input', function () {
        $('#alert_email').attr("hidden",true);
        $('#email').removeClass('bp-input-validation-error');
    });
    $('#telephone').on('input', function () {
        $('#alert_phone').attr("hidden",true);
        $('#telephone').removeClass('bp-input-validation-error');
    });
    $('#username').on('input', function (e) {
        $('#alert_username').attr("hidden",true);
        $('#username').removeClass('bp-input-validation-error');
        $(this).val($(this).val().replace(/[|&;$%@"<>(){},]/g, ''));
    });
    $('#password').on('input', function () {
        $('#alert_password').attr("hidden",true);
        $('#password').removeClass('bp-input-validation-error');
    });
    $('#password_confirmation').on('input', function () {
        $('#alert_password_confirmation').attr("hidden",true);
        $('#password_confirmation').removeClass('bp-input-validation-error');
    });
    $('#terms').on('change',function () {
        if (this.checked) {
            $('#alert_terms').attr("hidden",true);
        }
    });
}

function clearAllAlerts(){
    $('#alert_name').attr("hidden",true);
    $('#name').removeClass('bp-input-validation-error');
    $('#alert_email').attr("hidden",true);
    $('#email').removeClass('bp-input-validation-error');
    $('#alert_phone').attr("hidden",true);
    $('#telephone').removeClass('bp-input-validation-error');
    $('#alert_username').attr("hidden",true);
    $('#username').removeClass('bp-input-validation-error');
    $('#alert_password_current').attr("hidden",true);
    $('#password_current').removeClass('bp-input-validation-error');
    $('#alert_password').attr("hidden",true);
    $('#password').removeClass('bp-input-validation-error');
    $('#alert_password_confirmation').attr("hidden",true);
    $('#password_confirmation').removeClass('bp-input-validation-error');
    $('#alert_terms').attr("hidden",true);
}

function validateEmail(mail){
    var mailFormat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (mail.match(mailFormat)){
        return true;
    } else {
        return false;
    } 
}

function validatePhone(phone){
    var phoneFormat = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,7}$/im;
    if (phone.match(phoneFormat)){
        return true;
    } else {
        return false;
    } 
}

function validatePassword(pass){
    var password = pass;
    if (password.length >= 6){
        return true;
    } else {
        return false;
    }
}