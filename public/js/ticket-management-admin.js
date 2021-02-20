let uid;

$('.row-clickable').on('click',function(){
    $('#modalViewTicket').modal('show');
});

$('#modalViewUser').on('hide.bs.modal', function (e) {
    hideActions();
});

$('#btn_pick').on('click',function(e){
    if (confirm("Are you sure you want to assign this ticket to yourself?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+uid+"/activate";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_release').on('click',function(e){
    if (confirm("Are you sure you want to release this ticket?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+uid+"/suspend";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_close_resolved').on('click',function(e){
    if (confirm("Are you sure you want to mark this ticket as resolved?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+uid+"/activate";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_close').on('click',function(e){
    if (confirm("Are you sure you want to close this ticket without a resolution?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+uid+"/kick";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

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

function setProfileUrl(id){
    $('#btn_view_profile').attr("href","/manage-users/all/"+id);
}
