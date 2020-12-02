$('#nav_zone_id').on('change',function (e){
    if($('#nav_zone_id').val()){
        sortByZone();
    }
});

$('#nav_zone_entry_id').on('change',function (e){
    if($('#nav_zone_entry_id').val()){
        sortBySubzone();
    }
});

$('#nav_lister_id').on('change',function (e){
    if($('#nav_lister_id').val()){
        sortByLister();
    }
});

function sortByZone() {
    //window.location.href = "{!! route('admin.filterListings',['category'=>'zone','value'=>$('#nav_zone_id').val()]) !!}";
    window.location.href = "/manage-listings/all/zone/"+$('#nav_zone_id').val();
}

function sortBySubzone() {
    //window.location.href = "{!! route('admin.filterListings',['category'=>'subzone','value'=>$('#nav_zone_entry_id').val()]) !!}";
    window.location.href = "/manage-listings/all/subzone/"+$('#nav_zone_entry_id').val();
}

function sortByLister() {
    //window.location.href = "{!! route('admin.filterListings',['category'=>'lister','value'=>$('#nav_lister_id').val()]) !!}";
    window.location.href = "/manage-listings/all/lister/"+$('#nav_lister_id').val();
}