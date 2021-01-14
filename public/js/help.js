$('#help_form').on('submit', function(e) {
    if (confirm("Are you sure you want to submit your ticket?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});