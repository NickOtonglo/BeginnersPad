// $('.btn-filter').on("click",function(){
//     if (targetObj == 'me'){
//         loadAllLogs();
//     } else if (targetObj == 'all'){
//         loadMyLogs();
//     }
// });

// console.log(logsMeObj);

// function loadMyLogs(){
//     populateTable();
//     targetObj = 'me';
// }

// function loadAllLogs(){
//     populateTable();
//     targetObj = 'all';
// }

// function populateTable(){
//     if(targetObj == 'me'){
        
//         document.getElementById("t_body_id").value = logsMeObj.id;
//         document.getElementById("t_body_name").value = logsMeObj.property_id;
//         document.getElementById("t_body_entry_name").value = logsMeObj.listing_entry_id;
//         document.getElementById("t_body_action").value = logsMeObj.action;
//         document.getElementById("t_body_reason").value = logsMeObj.reason;
//         document.getElementById("t_body_time").value = logsMeObj.created_at;

//     } else if (targetObj == 'all'){
        

//         document.getElementById("t_body_id").value = logsMeObj.id;
//         document.getElementById("t_body_name").value = logsMeObj.property_id;
//         document.getElementById("t_body_entry_name").value = logsMeObj.listing_entry_id;
//         document.getElementById("t_body_action").value = logsMeObj.action;
//         document.getElementById("t_body_admin").value = logsMeObj.admin_id;
//         document.getElementById("t_body_reason").value = logsMeObj.reason;
//         document.getElementById("t_body_time").value = logsMeObj.created_at;
//     }
// }

$('.row-clickable').on("click",function(){
    $('#modalViewLog').modal('toggle');
});

function populateLogModal(arg){
    try {
        let logObj = JSON.parse(arg);
        document.getElementById("log_id").value = logObj.id;
        // document.getElementById("property_name").value = entry.role;
        // document.getElementById("listing_name").value = entry.lat;
        // document.getElementById("admin_name").value = entry.lng;
        document.getElementById("action").value = logObj.action;
        if(logObj.reason != null){
            document.getElementById("reason").value = logObj.reason;
        } else {
            document.getElementById("reason").value = "none given";
        }
        // document.getElementById("timestamp").value = entry.timezone;
    } catch (error) {

    }
}