function populateModal(arg){
    try{
        for(let i=0;i<=logsObj.length-1;i++){
            if(logsObj[i].id == arg){
                let log = logsObj[i];
                document.getElementById('parent').innerHTML = log.entry_id;
                document.getElementById('question').innerHTML = log.question;
                document.getElementById('answer').innerHTML = log.answer;
                document.getElementById('category').innerHTML = log.category;
                document.getElementById('action').innerHTML = log.action;
                if(log.action_by != null){
                    document.getElementById('admin').innerHTML = log.action_by.name;
                } else {
                    document.getElementById('admin').innerHTML = '[deleted]';
                }
                document.getElementById('timestamp').innerHTML = log.created_at;
            }
        }
    }catch(error){
        
    }
}