$('#btn_remove_bookmark').on("click",function (e){
    if (confirm("Remove bookmark?")) {
        e.stopPropagation();
        return true;
    } else {
        e.stopPropagation();
        return false;
    }
});

populateLists();

function populateLists(){
    if (entryObj.disclaimer != null){
        var list = entryObj.disclaimer;
        list = list.split(';');
        // list.sort(function() { return 0.5 - Math.random() });
        var ul = document.getElementById("disclaimer_list");

        for(var i=0; i<list.length; i++) {
            var li = document.createElement("li");
            li.appendChild(document.createTextNode(list[i]));
            ul.appendChild(li);
        }
    }
    if (entryObj.features != null){
        var list = entryObj.features;
        list = list.split(';');
        // list.sort(function() { return 0.5 - Math.random() });
        var ul = document.getElementById("features_list");

        for(var i=0; i<list.length; i++) {
            var li = document.createElement("li");
            li.appendChild(document.createTextNode(list[i]));
            ul.appendChild(li);
        }
    }
}