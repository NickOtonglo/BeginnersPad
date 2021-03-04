$('#btn_pick').on('click',function(e){
    if (confirm("Are you sure you want to assign this ticket to yourself?")) {
        e.stopPropagation();
        $('#formAction').trigger('submit');
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_release').on('click',function(e){
    if (confirm("Are you sure you want to release this ticket?")) {
        e.stopPropagation();
        $('#formAction').trigger('submit');
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_close_resolved').on('click',function(e){
    if (confirm("Are you sure you want to mark this ticket as resolved?")) {
        e.stopPropagation();
        $('#formAction').trigger('submit');
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

$('#btn_close').on('click',function(e){
    if (confirm("Are you sure you want to close this ticket without a resolution?")) {
        e.stopPropagation();
        $('#formAction').trigger('submit');
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