let uid;

$('#btn_add_user').on('click',function(){
    $('#modalNewUser').modal('show');
});

$('#btn_generate_password').on('click',function(){
    $('#password').val(generatePassword());
    $('#alert_password').hide();
        $('#password').removeClass('alert alert-danger');
});

$('#modalNewUser').on('hide.bs.modal', function (e) {
    clearAllAlerts();
});

$('#btn_create').on('click',function (e) {
    if(validateCreateUserForm()){
        if (confirm("Are you sure you want to create this user?")) {
            e.stopPropagation();
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    }
});

$('.row-clickable').on('click',function(){
    $('#modalViewUser').modal('show');
});

$('#modalViewUser').on('hide.bs.modal', function (e) {
    hideActions();
});

$('#btn_activate').on('click',function(e){
    if (confirm("Are you sure you want to activate this user?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+uid+"/activate";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_suspend').on('click',function(e){
    if (confirm("Are you sure you want to suspend this user?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+uid+"/suspend";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_restore').on('click',function(e){
    if (confirm("Are you sure you want to restore this user?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+uid+"/activate";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_delete').on('click',function(e){
    if (confirm("Are you sure you want to delete this user?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+uid+"/kick";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

hideCreateUserAlerts();

function validateCreateUserForm(){
    if (document.getElementById("name").value.trim() == ""
        || document.getElementById("email").value.trim() == ""
        || document.getElementById("telephone").value.trim() == ""
        || document.getElementById("user_type").value.trim() == ""
        || document.getElementById("password").value.trim() == "") {
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
        if (document.getElementById("user_type").value.trim() == "") {
            $('#alert_type').html('<li>Required</li>').show();
            $('#user_type').addClass('alert alert-danger');
        }
        if (document.getElementById("password").value.trim() == "") {
            $('#alert_password').html('<li>Required</li>').show();
            $('#password').addClass('alert alert-danger');
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
        } else if (!validatePassword(document.getElementById("password").value.trim())) {
            $('#alert_password').html('<li>Password must be of at least 6 characters, and not consist of spaces entirely"</li>').show();
            $('#password').addClass('alert alert-danger');
            return false;
        } else {
            return true;
        }
    }
}

function hideCreateUserAlerts(){
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
    $('#user_type').on('input', function () {
        $('#alert_type').hide();
        $('#user_type').removeClass('alert alert-danger');
    });
    $('#password').on('input', function () {
        $('#alert_password').hide();
        $('#password').removeClass('alert alert-danger');
    });
}

function clearAllAlerts(){
    $('#alert_name').hide();
    $('#name').removeClass('alert alert-danger');
    $('#alert_email').hide();
    $('#email').removeClass('alert alert-danger');
    $('#alert_phone').hide();
    $('#telephone').removeClass('alert alert-danger');
    $('#alert_type').hide();
    $('#user_type').removeClass('alert alert-danger');
    $('#alert_password').hide();
    $('#password').removeClass('alert alert-danger');
}

function populateActionForm(arg){
    try {
        let user = JSON.parse(arg);
        document.getElementById("act_name").value = user.name;
        document.getElementById("act_email").value = user.email;
        document.getElementById("act_telephone").value = user.telephone;
        let userType = user.user_type;
        if(userType == 1){
            document.getElementById("act_user_type").value = 'System Administrator';
        } else if(userType == 2){
            document.getElementById("act_user_type").value = 'Super Administrator';
        } else if(userType == 3){
            document.getElementById("act_user_type").value = 'Representative';
        } else if(userType == 4){
            document.getElementById("act_user_type").value = 'Lister';
        } else if(userType == 5){
            document.getElementById("act_user_type").value = 'Customer';
        }
        document.getElementById("act_timestamp").value = user.created_at;
        let userStatus = user.status;
        if(userStatus != 'suspended'){
            if(userStatus == 'inactive'){
                $('#btn_activate').show();
                if(authUser.user_type == 1){
                    $('#btn_delete').show();
                }
            } else {
                $('#btn_suspend').show();
                if(authUser.user_type == 1){
                    $('#btn_delete').show();
                }
            }
        } else if(userStatus == 'suspended'){
            $('#btn_restore').show();
        }
        document.getElementById("act_status").value = user.status;
        
        setProfileUrl(user.id);
        uid = user.id;
    } catch (error) {

    }
}

function hideActions(){
    $('.list-action').hide();
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

function generatePassword() {
    var length = 8,
        charset = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ123456789",
        retVal = "";
    for (var i = 0,n = charset.length; i < length;++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

function setProfileUrl(id){
    $('#btn_view_profile').attr("href","/manage-users/all/"+id);
}
