@extends('layouts.base_listing_entry_view')

@section('title')
<title>Manage Listing - {{$entry->listing_name}} | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="pull-right">
    <button class="btn btn-sm btn-outline-primary" role="button" data-toggle="modal" data-target="#modalUpdateEntry" onclick="populateEntryUpdateForm('{{$entry}}',this);">Edit Listing Entry</button>
</div>
@endsection

@section('thumbnail_button')
    @if(Auth::user()->user_type === 4)
    <form id="thumb_form" method="post" action="{{route('lister.storeListingEntryThumb',['listingId'=>$entry->listing->id,'entryId'=>$entry->id])}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div hidden>
            <input class="file-path-wrapper" accept="image/*" name="thumb" id="btn_thumb_real" type="file" onchange="loadFileThumb(event)" />
        </div>
    </form>
    <input class="btn btn-sm btn-outline-primary btn-block" style="border-radius: 25px;display: block;margin: auto;" type="submit" name="btn_submit" id="btn_thumb_faux" value="Change Thumbnail">
    <hr>
    @endif
@endsection

@section('lister_controls')
@if(Auth::user()->user_type === 4)
<br>
<form method="post" action="{{route('lister.updateListingEntry',['listingId'=>$entry->listing->id,'entryId'=>$entry->id])}}" enctype="multipart/form-data">
    {{csrf_field()}}
    {{method_field('PUT')}}
    @if($entry->status == 'active')
    <input class="btn btn-lg btn-danger btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Make Inactive (hide)" name="btn_submit">
    @elseif($entry->status == 'inactive')
    <input class="btn btn-lg btn-success btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Activate" name="btn_submit">
    @elseif($entry->status == 'occupied')
    <input class="btn btn-lg btn-danger btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Declare Vacant" name="btn_submit">
    @endif
</form>
<input class="btn btn-lg btn-danger btn-block btn-entry-delete" style="margin-top:5px" type="submit" value="Delete Listing" name="btn_submit" disabled>
@endif
@endsection

@section('img_control')
<div class="row">
    <div class="responsive" style="padding: 10px;width:150px;height:150px;" id="images_upload">
        <div class="gallery">
            <img id="images_virtual" src="/images/btn-add.png" alt="unable to display image">
            <form id="image_form" method="post" action="{{route('lister.storeListingEntryImage',['listingId'=>$entry->listing->id,'entryId'=>$entry->id])}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div hidden>
                    <input class="file-path-wrapper" accept="image/*" name="images[]" id="images_solo" type="file" multiple onchange="loadFileCustom(event)" />
                </div>
            </form>
            <input class="btn btn-sm btn-primary" style="width:100%;border-radius:0px" type="submit" name="btn_submit" id="btn_add_img" value="Add Image">
        </div>
    </div>
</div>
@endsection

@section('entries_scripts')
<script src="{{asset('js/listings.js')}}"></script>
<script src="{{asset('js/listing-entries.js')}}"></script>
@endsection