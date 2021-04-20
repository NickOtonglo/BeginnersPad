@extends('layouts.base_listing_entry_view')

@section('title')
<title>Manage Listing - {{$entry->listing_name}} | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="col-md-3">
    <button class="btn btn-sm btn-outline-primary" role="button" data-bs-toggle="modal" data-bs-target="#modalUpdateEntry" onclick="populateEntryUpdateForm('{{$entry}}',this);">Edit Listing Entry</button>
</div>
<br>
<div class="col-md-9 d-grid gap-2 d-md-flex justify-content-md-end">
	<div class="btn-group" role="group" aria-label="...">
        @if($entry->status == 'active')
		<button type="button" class="btn btn-sm btn-outline-secondary" onclick="$('#btn_inactivate').trigger('click');">Make Inactive (hide)</button>
        @elseif($entry->status == 'inactive')
		<button type="button" class="btn btn-sm btn-outline-secondary" onclick="$('#btn_activate').trigger('click');">Activate</button>
        @elseif($entry->status == 'occupied')
		<button type="button" class="btn btn-sm btn-outline-secondary" onclick="$('#btn_vacate').trigger('click');">Declare Vacant</button>
        @endif
		<button type="button" class="btn btn-sm btn-outline-secondary" onclick="$('#btn_delete').trigger('click');" disabled>Delete Listing</button>
	</div>
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
<div hidden>
    <form method="post" action="{{route('lister.updateListingEntry',['listingId'=>$entry->listing->id,'entryId'=>$entry->id])}}" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        @if($entry->status == 'active')
        <input class="btn btn-lg btn-danger btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Make Inactive (hide)" name="btn_submit" id="btn_inactivate">
        @elseif($entry->status == 'inactive')
        <input class="btn btn-lg btn-success btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Activate" name="btn_submit" id="btn_activate">
        @elseif($entry->status == 'occupied')
        <input class="btn btn-lg btn-danger btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Declare Vacant" name="btn_submit" id="btn_vacate">
        @endif
    </form>
    <input class="btn btn-lg btn-danger btn-block btn-entry-delete" style="margin-top:5px" type="submit" value="Delete Listing" name="btn_submit" id="btn_delete" disabled>
</div>
@endif
@endsection

@section('lister_forms')
<div class="row">
    <div class="modal fade" id="modalUpdateEntry" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Edit Listing</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{route('lister.updateListingEntry',['listingId'=>$entry->listing->id,'entryId'=>$entry->id])}}" enctype="multipart/form-data" onsubmit="return validateEntryCreateForm();">
                    <div class="modal-body">
                        {{csrf_field() }}
                        {{method_field('PUT')}}
                        <div class="mb-3">
                            <label for="listing_name">Name of listing *</label>
                            <div class="alert alert-danger" id="alert_name_entry_create" hidden></div>
                            <input class="form-control" name="listing_name" type="text" id="listing_name">
                        </div>
                        <div class="mb-3">
                            <label for="entry_description">Description</label>
                            <div class="alert alert-danger" id="alert_desc_entry_create" hidden></div>
                            <br><input type="checkbox" value="checkbox_description" id="checkbox_description"> <strong>Copy from property description</strong>
                            <textarea class="form-control" name="entry_description" type="text" id="entry_description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="floor_area">Floor area of listing in square-metres *</label>
                            <div class="alert alert-danger" id="alert_floor_area_entry_create" hidden></div>
                            <input class="form-control" name="floor_area" type="number" id="floor_area" min="1">
                        </div>
                        <div class="mb-3">
                            <label for="disclaimer">Disclaimer(s) (separate with semicolon ';')</label>
                            <div class="alert alert-danger" id="alert_disclaimer_entry_create" hidden></div>
                            <textarea class="form-control" name="disclaimer" type="text" id="disclaimer" placeholder="e.g. disclaimer 1;disclaimer 2;disclaimer 3...etc"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="features">Feature(s) (separate with semicolon ';')</label>
                            <div class="alert alert-danger" id="alert_features_entry_create" hidden></div>
                            <textarea class="form-control" name="features" type="text" id="features" placeholder="e.g. feature 1;feature 2;feature 3...etc"></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="checkbox" value="checkbox_deposit" id="checkbox_deposit"> <strong>Set initial deposit</strong>
                        </div>
                        <div id="form_deposit" hidden>
                            <div class="mb-3">
                                <label for="initial_deposit">Initial deposit amount</label>
                                <div class="alert alert-danger" id="alert_initial_deposit_entry_create" hidden></div>
                                <input class="form-control" name="initial_deposit" type="number" step=".01" min="0.1" id="initial_deposit">
                            </div>
                            <div class="mb-3">
                                <label for="initial_deposit_period">Initial deposit period in months</label>
                                <div class="alert alert-danger" id="alert_deposit_period_entry_create" hidden></div>
                                <input class="form-control" name="initial_deposit_period" type="number" min="1" id="initial_deposit_period" placeholder="at least 1 month">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="entry_price">Price of rent/month for this listing (KES) *</label>
                            <div class="alert alert-danger" id="alert_price_entry_create" hidden></div>
                            @if($entry->listing->price == null)
                            <input class="form-control" name="entry_price" type="number" step=".01" min="0.1" id="entry_price">
                            @else
                            <input class="form-control" name="entry_price" type="number" step=".01" min="0.1" id="entry_price" placeholder="{{$entry->listing->price}} (set at property level)" disabled>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <input class="btn btn-outline-primary" id="btnSubmit" name="btn_submit" type="submit" value="Update Listing">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('img_control')
<div class="row">
    <div class="responsive" style="padding: 10px;width:150px;height:150px;" id="images_upload">
        <div class="gallery">
            <img id="images_virtual" type="button" src="/images/btn-add.png" alt="unable to display image">
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
<script src="{{asset('js/listings-management.js')}}"></script>
<script src="{{asset('js/listing-entries-management.js')}}"></script>
@endsection