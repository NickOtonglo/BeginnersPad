$('.btn-delete').click(function (e){
    if (confirm("Remove bookmark?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});