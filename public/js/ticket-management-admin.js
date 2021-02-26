let uid;
let ticketPriority;

$('.row-clickable').on('click',function(){
    $('#modalViewTicket').modal('show');

});

$('#modalViewTicket').on('hide.bs.modal', function (e) {
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
        let ticket = JSON.parse(arg);
        document.getElementById("mod_id").innerHTML = ticket.id;
        document.getElementById("mod_email").innerHTML = ticket.email;
        document.getElementById("mod_reg").innerHTML = ticket.is_registered;
        document.getElementById("mod_category").innerHTML = ticket.topic;
        if(ticketPriority == 1){
            document.getElementById("mod_priority").innerHTML = ticketPriority+' (Lowest)';
        } else if(ticketPriority == 2){
            document.getElementById("mod_priority").innerHTML = ticketPriority+' (Low)';
        } else if(ticketPriority == 3){
            document.getElementById("mod_priority").innerHTML = ticketPriority+' (Moderate)';
        } else if(ticketPriority == 4){
            document.getElementById("mod_priority").innerHTML = ticketPriority+' (High)';
        } else if(ticketPriority == 5){
            document.getElementById("mod_priority").innerHTML = ticketPriority+' (Highest)';
        }
        document.getElementById("mod_description").innerHTML = ticket.description;
        document.getElementById("mod_status").innerHTML = ticket.status;
        if(ticket.assigned_to == null){
            document.getElementById("mod_assign").innerHTML = '(not assigned)';
        } else {
            document.getElementById("mod_assign").innerHTML = ticket.assigned_to;
        }
        document.getElementById("mod_time").innerHTML = ticket.created_at;
        let ticketStatus = ticket.status;
        switch (ticketStatus){
            case 'open':
                $('#btn_pick').show();
                $('#btn_close_resolved').show();
                $('#btn_close').show();
                $('#btn_release').hide();
                break;
            case 'pending':
                if(authUser.id == ticket.assigned_to || authUser.user_type == 1){
                    $('#btn_release').show();
                    $('#btn_close_resolved').show();
                    $('#btn_close').show();
                }
                $('#btn_pick').hide();
                break;
            case 'resolved':
                $('#btn_pick').hide();
                $('#btn_release').hide();
                $('#btn_close_resolved').hide();
                $('#btn_close').hide();
                break;
            case 'closed':
                $('#btn_pick').hide();
                $('#btn_release').hide();
                $('#btn_close_resolved').hide();
                $('#btn_close').hide();
                break;
            case 'reopened':
                $('#btn_pick').show();
                $('#btn_close_resolved').show();
                $('#btn_close').show();
                $('#btn_release').hide();
                break;
        }
        
        // setProfileUrl(user.id);
        // uid = user.id;
    } catch (error) {

    }
}

function hideActions(){
    $('.list-action').hide();
}

function setPriority(args){
    try{
        ticketPriority = JSON.parse(args);
    }catch(error){

    }
}