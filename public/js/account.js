$('#btn_edit_profile').on('click',function (e) {
    $('#div_img').hide();
    $('#modal').modal('show');
});

$('#btn_img_faux').on('click',function (e) {
    $('#btn_img').trigger('click');
});

$('#modal').on('hide.bs.modal',function (e) {
    clearAllAlerts();
});

hideDetailsAlerts();
hidePasswordsAlerts();

var loadAvatar = function (event) {
    try{
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('img_avatar');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);

        setTimeout(function() { 
            if (confirm("Are you sure you want to update your avatar?")) {
                event.stopPropagation();
                return true;
            } else {
                event.stopPropagation();
                return false;
            }
        }, 1000);
    }catch(error){
        console.error();
    }
    
};

function populateModal() {
    
}

function validateDetailsForm(){
    if (document.getElementById("name").value.trim() == ""
        || document.getElementById("email").value.trim() == ""
        || document.getElementById("telephone").value.trim() == ""
        || document.getElementById("username").value.trim() == "") {
        if (document.getElementById("name").value.trim() == "") {
            $('#alert_name').html('<li>Required</li>').show();
            $('#name').addClass('alert alert-danger');
        }
        if (document.getElementById("email").value.trim() == "") {
            $('#alert_email').html('<li>Required</li>').show();
            $('#email').addClass('alert alert-danger');
        }
        if (document.getElementById("telephone").value.trim() == "") {
            $('#alert_phone').html('<li>Required</li>').show();
            $('#telephone').addClass('alert alert-danger');
        }
        if (document.getElementById("username").value.trim() == "") {
            $('#alert_username').html('<li>Required</li>').show();
            $('#username').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (document.getElementById("name").value.trim().length > 255) {
            $('#alert_name').html('<li>Name should contain between 2 and 255 characters</li>').show();
            $('#name').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("email").value.trim().length > 255) {
            $('#alert_email').html('<li>Email must contain not more than 255 characters</li>').show();
            $('#email').addClass('alert alert-danger');
            return false;
        } else if (!validateEmail(document.getElementById("email").value.trim())) {
            $('#alert_email').html('<li>Email must be in the format "name@example.com"</li>').show();
            $('#email').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("telephone").value.trim().length < 10 || document.getElementById("telephone").value.trim().length > 13) {
            $('#alert_phone').html('<li>Phone number must contain between 10 and 13 characters</li>').show();
            $('#telephone').addClass('alert alert-danger');
            return false;
        } else if (!validatePhone(document.getElementById("telephone").value.trim())) {
            $('#alert_phone').html('<li>Phone number must be in the format "+254XXXXXXXXX"</li>').show();
            $('#email').addClass('alert alert-danger');
            return false;
        }  else {
            return true;
        }
    }
}

function validatePasswordForm(){
    if (document.getElementById("password_current").value.trim() == ""
        || document.getElementById("password").value.trim() == ""
        || document.getElementById("password_confirmation").value.trim() == "") {
        if (document.getElementById("password_current").value.trim() == "") {
            $('#alert_password_current').html('<li>Required</li>').show();
            $('#password_current').addClass('alert alert-danger');
        }
        if (document.getElementById("password").value.trim() == "") {
            $('#alert_password').html('<li>Required</li>').show();
            $('#password').addClass('alert alert-danger');
        }
        if (document.getElementById("password_confirmation").value.trim() == "") {
            $('#alert_password_confirmation').html('<li>Required</li>').show();
            $('#password_confirmation').addClass('alert alert-danger');
        }
        return false;
    } else {
        if (!validatePassword(document.getElementById("password").value.trim())) {
            $('#alert_password').html('<li>Password must be of at least 6 characters, and not consist of spaces entirely"</li>').show();
            $('#password').addClass('alert alert-danger');
            return false;
        } else if (document.getElementById("password").value.trim() != document.getElementById("password_confirmation").value.trim()) {
            $('#alert_password').html('<li>These passwords do not match!"</li>').show();
            $('#password').addClass('alert alert-danger');
            $('#password_confirmation').addClass('alert alert-danger');
        }  else {
            return true;
        }
    }
}

function hideDetailsAlerts(){
    $('#name').on('input', function () {
        $('#alert_name').hide();
        $('#name').removeClass('alert alert-danger');
    });
    $('#email').on('input', function () {
        $('#alert_email').hide();
        $('#email').removeClass('alert alert-danger');
    });
    $('#telephone').on('input', function () {
        $('#alert_phone').hide();
        $('#telephone').removeClass('alert alert-danger');
    });
    $('#username').on('input', function () {
        $('#alert_username').hide();
        $('#username').removeClass('alert alert-danger');
    });
}

function hidePasswordsAlerts(){
    $('#password_current').on('input', function () {
        $('#alert_password_current').hide();
        $('#password_current').removeClass('alert alert-danger');
    });
    $('#password').on('input', function () {
        $('#alert_password').hide();
        $('#password').removeClass('alert alert-danger');
    });
    $('#password_confirmation').on('input', function () {
        $('#alert_password_confirmation').hide();
        $('#password_confirmation').removeClass('alert alert-danger');
    });
}

function clearAllAlerts(){
    $('#alert_name').hide();
    $('#name').removeClass('alert alert-danger');
    $('#alert_email').hide();
    $('#email').removeClass('alert alert-danger');
    $('#alert_phone').hide();
    $('#telephone').removeClass('alert alert-danger');
    $('#alert_username').hide();
    $('#username').removeClass('alert alert-danger');
    $('#alert_password_current').hide();
    $('#password_current').removeClass('alert alert-danger');
    $('#alert_password').hide();
    $('#password').removeClass('alert alert-danger');
    $('#alert_password_confirmation').hide();
    $('#password_confirmation').removeClass('alert alert-danger');
}