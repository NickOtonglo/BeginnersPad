let id;

$('.modal').on('hide.bs.modal',function(e){
    clearAlerts();
});

$('.card-big-clickable').on('click',function(e){
    
});

hideCreateAlerts();
hideUpdateAlerts();

$('#btn_create').on('click',function(e){
    if(validateEntryCreateForm()){
        if(confirm("Are you sure you want to publish this entry?")){
            e.stopPropagation();
            $('#formEntryCreate').trigger('submit');
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    }
});
$('#btn_update').on('click',function(e){
    if(validateEntryUpdateForm()){
        if(confirm("Are you sure you want to update this entry?")){
            e.stopPropagation();
            $('#formEntryUpdate').attr('action',setUpdateAction());
            $('#formEntryUpdate').trigger('submit');
            return true;
        } else {
            e.stopPropagation();
            return false;
        }
    }
});
$('.btn-delete').on('click',function(e){
    if(confirm("Are you sure you want to delete this entry?")){
        e.stopPropagation();
        $('#formEntryDelete').trigger('submit');
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

function validateEntryCreateForm(){
    if(document.getElementById('qn_create').value.trim() == ''
     || document.getElementById('ans_create').value.trim() == ''
     || document.getElementById('cat_create').value.trim() == ''){
        if(document.getElementById('qn_create').value.trim() == ''){
            $('#alert_qn_create').html('<li>Required</li>').show();
            $('#qn_create').addClass('alert alert-danger');
        }
        if(document.getElementById('ans_create').value.trim() == ''){
            $('#alert_ans_create').html('<li>Required</li>').show();
            $('#ans_create').addClass('alert alert-danger');
        }
        if(document.getElementById('cat_create').value.trim() == ''){
            $('#alert_cat_create').html('<li>Required</li>').show();
            $('#cat_create').addClass('alert alert-danger');
        }
        return false;
    } else {
        return true
    }
}

function validateEntryUpdateForm(){
    if(document.getElementById('question').value.trim() == ''
     || document.getElementById('answer').value.trim() == ''
     || document.getElementById('category').value.trim() == ''){
        if(document.getElementById('question').value.trim() == ''){
            $('#alert_qn').html('<li>Required</li>').show();
            $('#question').addClass('alert alert-danger');
        }
        if(document.getElementById('answer').value.trim() == ''){
            $('#alert_ans').html('<li>Required</li>').show();
            $('#answer').addClass('alert alert-danger');
        }
        if(document.getElementById('category').value.trim() == ''){
            $('#alert_cat').html('<li>Required</li>').show();
            $('#category').addClass('alert alert-danger');
        }
        return false;
    } else {
        return true
    }
}

function hideCreateAlerts(){
    $('#qn_create').on('input',function(){
        $('#alert_qn_create').hide();
        $('#qn_create').removeClass('alert alert-danger');
    });
    $('#ans_create').on('input',function(){
        $('#alert_ans_create').hide();
        $('#ans_create').removeClass('alert alert-danger');
    });
    $('#cat_create').on('input',function(){
        $('#alert_cat_create').hide();
        $('#cat_create').removeClass('alert alert-danger');
    });
}

function hideUpdateAlerts(){
    $('#question').on('input',function(){
        $('#alert_qn').hide();
        $('#question').removeClass('alert alert-danger');
    });
    $('#answer').on('input',function(){
        $('#alert_ans').hide();
        $('#answer').removeClass('alert alert-danger');
    });
    $('#category').on('input',function(){
        $('#alert_cat').hide();
        $('#category').removeClass('alert alert-danger');
    });
}

function clearAlerts(){
    $('#alert_qn_create').hide();
    $('#qn_create').removeClass('alert alert-danger');
    $('#alert_ans_create').hide();
    $('#ans_create').removeClass('alert alert-danger');
    $('#alert_cat_create').hide();
    $('#cat_create').removeClass('alert alert-danger');

    $('#alert_qn').hide();
    $('#question').removeClass('alert alert-danger');
    $('#alert_ans').hide();
    $('#answer').removeClass('alert alert-danger');
    $('#alert_cat').hide();
    $('#category').removeClass('alert alert-danger');
}

function populateEntryUpdateForm(arg){
    try{
        for(let i=0;i<=entriesObj.length-1;i++){
            if(entriesObj[i].id == arg){
                let entry = entriesObj[i];
                document.getElementById('question').value = entry.question;
                document.getElementById('answer').value = entry.answer;
                document.getElementById('category').value = entry.category;
                document.getElementById('time').value = entry.created_at;
                id = entry.id;
                setUpdateAction();
            }
        }
    }catch(error){

    }
}

function setUpdateAction(){
    return '/help/faq/manage/'+id;
}