let uid,email;
let ticketPriority;
let ticketId;
let assignedTo;

$('.row-clickable').on('click',function(){
    $('#modalViewTicket').modal('show');

});

$('#btn_view_user').on('click',function(e){
    window.location.href = "/manage-users/all/"+uid;
});

$('#btn_view_tickets').on('click',function(e){
    window.location.href = "/help/tickets/user/"+email+"/logs";
});

$('#btn_open_ticket').on('click',function(e){
    window.location.href = "/help/tickets/"+ticketId;
});

$('#modalViewTicket').on('hide.bs.modal', function (e) {
    hideActions();
    removeAssignedTo();
    $('#btn_view_user').addClass('hidden');
});

$('#btn_pick').on('click',function(e){
    if (confirm("Are you sure you want to assign this ticket to yourself?")) {
        e.stopPropagation();
        $('#formAction').attr('action',setFormAction());
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_release').on('click',function(e){
    if (confirm("Are you sure you want to release this ticket?")) {
        e.stopPropagation();
        $('#formAction').attr('action',setFormAction());
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_close_resolved').on('click',function(e){
    if (confirm("Are you sure you want to mark this ticket as resolved?")) {
        e.stopPropagation();
        $('#formAction').attr('action',setFormAction());
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_close').on('click',function(e){
    if (confirm("Are you sure you want to close this ticket without a resolution?")) {
        e.stopPropagation();
        $('#formAction').attr('action',setFormAction());
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#pick_ticket').on('click',function(e){
    $('#btn_pick').trigger('click');
});

$('#release_ticket').on('click',function(e){
    $('#btn_release').trigger('click');
});

$('#close_resolved_ticket').on('click',function(e){
    $('#btn_close_resolved').trigger('click');
});

$('#close_ticket').on('click',function(e){
    $('#btn_close').trigger('click');
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
        if(assignedTo == null){
            document.getElementById("mod_assign").innerHTML = '(not assigned)';
        } else {
            if(authUser.id == ticket.assigned_to){
                document.getElementById("mod_assign").innerHTML = assignedTo+' (ME)';
            } else {
                document.getElementById("mod_assign").innerHTML = assignedTo;
            } 
        }
        document.getElementById("mod_time").innerHTML = ticket.created_at;
        let ticketStatus = ticket.status;
        switch (ticketStatus){
            case 'open':
                $('#pick_ticket').show();
                $('#close_resolved_ticket').show();
                $('#close_ticket').show();
                $('#release_ticket').hide();
                break;
            case 'pending':
                if(authUser.id == ticket.assigned_to || authUser.user_type == 1){
                    $('#release_ticket').show();
                    $('#close_resolved_ticket').show();
                    $('#close_ticket').show();
                }
                $('#pick_ticket').hide();
                break;
            case 'resolved':
                $('#pick_ticket').hide();
                $('#release_ticket').hide();
                $('#close_resolved_ticket').hide();
                $('#close_ticket').hide();
                break;
            case 'closed':
                $('#pick_ticket').hide();
                $('#release_ticket').hide();
                $('#close_resolved_ticket').hide();
                $('#close_ticket').hide();
                break;
            case 'reopened':
                $('#pick_ticket').show();
                $('#close_resolved_ticket').show();
                $('#close_ticket').show();
                $('#release_ticket').hide();
                break;
        }

        ticketId = ticket.id;
        email = ticket.email;
        
        setProfileUrl(uid);
        setTicketsUrl(email);
        setGoToTicketUrl(ticketId);
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

function setAssignedTo(args){
    try{
        assignedTo = args;
    }catch(error){
        
    }
}

function removeAssignedTo(){
    assignedTo = null;
    uid = null;
}

function setFormAction(){
    return '/help/tickets/'+ticketId+'/action';
}

function showViewUser(args){
    try{
        uid = JSON.parse(args).id;
    }catch(error){

    }
    if(args != ''){
        $('#btn_view_user').removeClass('hidden');
    }
}

function setProfileUrl(id){
    $('#btn_view_user').attr("href","/manage-users/all/"+id);
}

function setTicketsUrl(email){
    $('#btn_view_tickets').attr("href","/help/tickets/user/"+email+"/logs");
}

function setGoToTicketUrl(ticket){
    $('#btn_open_ticket').attr("href","/help/tickets/"+ticket);
}