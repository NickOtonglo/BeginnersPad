if (authUser.avatar == null){
    $('#btn_remove_avatar').attr("hidden",true);
}

$('#btn_edit_profile').on('click',function (e) {
    $('#div_img').attr("hidden",true);
    $('#modal').modal('show');
});

$('#btn_img_faux').on('click',function (e) {
    $('#btn_img').trigger('click');
});

$('#modal').on('hide.bs.modal',function (e) {
    clearAllAlerts();
});

$('#modal').on('show.bs.modal',function (e) {
    populateModal();
    toggleUpdateButton();
    togglePasswordButton();
});

$('#username').on('keydown', function(e) {
    if (e.key === ' '){
        return false; 
    } 
});

$('#btn_update').on('click',function (e) {
    if (validateDetailsForm()) {
        if (confirm("Are you sure you want to update your account information?")) {
            e.stopPropagation();
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    }
});

$('#btn_password').on('click',function (e) {
    if (validatePasswordForm()) {
        if (confirm("Are you sure you want to update your account password?")) {
            e.stopPropagation();
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    }
});

$('#btn_remove_avatar').on('click',function (e) {
    if (confirm("Are you sure you want to remove your avatar?")) {
        e.stopPropagation();
        $('#formNoAvatar').trigger('submit');
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
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
                $('#formAvatar').trigger('submit');
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
    $('#name').val(authUser.name);
    $('#email').val(authUser.email);
    $('#telephone').val(authUser.telephone);
}

function validateDetailsForm(){
    if (document.getElementById("name").value.trim() == ""
        || document.getElementById("email").value.trim() == ""
        || document.getElementById("telephone").value.trim() == ""
        || document.getElementById("username").value.trim() == "") {
        if (document.getElementById("name").value.trim() == "") {
            $('#alert_name').html('<li>Required</li>').attr("hidden",false);
            $('#name').addClass('bp-input-validation-error');
        }
        if (document.getElementById("email").value.trim() == "") {
            $('#alert_email').html('<li>Required</li>').attr("hidden",false);
            $('#email').addClass('bp-input-validation-error');
        }
        if (document.getElementById("telephone").value.trim() == "") {
            $('#alert_phone').html('<li>Required</li>').attr("hidden",false);
            $('#telephone').addClass('bp-input-validation-error');
        }
        if (document.getElementById("username").value.trim() == "") {
            $('#alert_username').html('<li>Required</li>').attr("hidden",false);
            $('#username').addClass('bp-input-validation-error');
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

function validatePasswordForm(){
    if (document.getElementById("password_current").value.trim() == ""
        || document.getElementById("password").value.trim() == ""
        || document.getElementById("password_confirmation").value.trim() == "") {
        if (document.getElementById("password_current").value.trim() == "") {
            $('#alert_password_current').html('<li>Required</li>').attr("hidden",false);
            $('#password_current').addClass('bp-input-validation-error');
        }
        if (document.getElementById("password").value.trim() == "") {
            $('#alert_password').html('<li>Required</li>').attr("hidden",false);
            $('#password').addClass('bp-input-validation-error');
        }
        if (document.getElementById("password_confirmation").value.trim() == "") {
            $('#alert_password_confirmation').html('<li>Required</li>').attr("hidden",false);
            $('#password_confirmation').addClass('bp-input-validation-error');
        }
        return false;
    } else {
        if (!validatePassword(document.getElementById("password").value.trim())) {
            $('#alert_password').html('<li>Password must be of at least 6 characters, and consist of no spaces</li>').attr("hidden",false);
            $('#password').addClass('bp-input-validation-error');
            return false;
        } else if (document.getElementById("password").value.trim() != document.getElementById("password_confirmation").value.trim()) {
            $('#alert_password').html('<li>These passwords do not match!</li>').attr("hidden",false);
            $('#password').addClass('bp-input-validation-error');
            $('#password_confirmation').addClass('bp-input-validation-error');
            return false;
        }  else {
            return true;
        }
    }
}

function hideDetailsAlerts(){
    $('#name').on('input', function () {
        $('#alert_name').attr("hidden",true);
        $('#name').removeClass('bp-input-validation-error');
        toggleUpdateButton();
    });
    $('#email').on('input', function () {
        $('#alert_email').attr("hidden",true);
        $('#email').removeClass('bp-input-validation-error');
        toggleUpdateButton();
    });
    $('#telephone').on('input', function () {
        $('#alert_phone').attr("hidden",true);
        $('#telephone').removeClass('bp-input-validation-error');
        toggleUpdateButton();
    });
    $('#username').on('input', function (e) {
        $('#alert_username').attr("hidden",true);
        $('#username').removeClass('bp-input-validation-error');
        // $(this).val($(this).val().replace(/\s+/g, ''));
        $(this).val($(this).val().replace(/[|&;$%@"<>(){},]/g, ''));
        //toggleUpdateButton();
    });
}

function hidePasswordsAlerts(){
    $('#password_current').on('input', function () {
        $('#alert_password_current').attr("hidden",true);
        $('#password_current').removeClass('bp-input-validation-error');
        togglePasswordButton();
    });
    $('#password').on('input', function () {
        $('#alert_password').attr("hidden",true);
        $('#password').removeClass('bp-input-validation-error');
        togglePasswordButton();
    });
    $('#password_confirmation').on('input', function () {
        $('#alert_password_confirmation').attr("hidden",true);
        $('#password_confirmation').removeClass('bp-input-validation-error');
        togglePasswordButton();
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
}

function toggleUpdateButton() {
    if($('#name').val() == authUser.name && $('#email').val() == authUser.email && $('#telephone').val() == authUser.telephone){
        $('#btn_update').prop('disabled','true');
    } else {
        $('#btn_update').prop('disabled',null);
    }
}

function togglePasswordButton() {
    if($('#password_current').val() == '' && $('#password').val() == '' && $('#password_confirmation').val() == ''){
        $('#btn_password').prop('disabled','true');
    } else {
        $('#btn_password').prop('disabled',null);
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