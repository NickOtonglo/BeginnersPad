$('#btn_activate').on('click',function(e){
    if (confirm("Are you sure you want to activate this user?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+user.id+"/activate";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_suspend').on('click',function(e){
    if (confirm("Are you sure you want to suspend this user?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+user.id+"/suspend";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_restore').on('click',function(e){
    if (confirm("Are you sure you want to restore this user?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+user.id+"/activate";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_delete').on('click',function(e){
    if (confirm("Are you sure you want to delete this user?")) {
        e.stopPropagation();
        window.location.href = "/manage-users/all/"+user.id+"/kick";
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});