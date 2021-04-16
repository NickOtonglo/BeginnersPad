@extends('layouts.base_listing_manage')

@section('title')
<title>Manage Property - {{$listing->property_name}} | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="col-md-6">
	<a class="btn btn-sm btn-outline-primary" role="button" data-bs-toggle="modal" data-bs-target="#modalCreateEntry">+ Add Listing Entry</a>
</div>
<div class="col-md-6 d-grid gap-2 d-md-flex justify-content-md-end">
	<div class="btn-group" role="group" aria-label="...">
		<input class="btn btn-sm btn-outline-secondary" type="button" value="Edit" name="btn_edit" data-bs-toggle="modal" data-bs-target="#modalUpdateListing" onclick="populateListingUpdateForm('{{$listing}}',this);">
		<form method="post" action="{{route('lister.manageListing',['$id'=>$listing->id])}}" enctype="multipart/form-data">
			{{csrf_field()}}
			{{method_field('PUT')}}
			@if(count($entries)>=1)
				@if($listing->status=='unpublished')
				<input class="btn btn-sm btn-outline-secondary" style="border-radius: 0px;" type="submit" value="Submit for Approval" name="btn_submit" id="btn_submit">
				@elseif($listing->status=='pending')
				<input class="btn btn-sm btn-outline-secondary" style="border-radius: 0px;" type="submit" value="Withdraw Submission" name="btn_submit" id="btn_revoke">
				@endif
			@endif
		</form>
		<input class="btn btn-sm btn-outline-secondary" type="butt	on" value="Delete Property" name="btn_delete" disabled>
	</div>
</div>
@endsection

@section('lister_forms')
<div class="row">
	<div class="modal fade" id="modalUpdateListing" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="modalLabel">Edit Listing Property</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="post" action="/manage-listings/{{$listing->id}}/manage" enctype="multipart/form-data" onsubmit="return validateListingCreateForm();">
					<div class="modal-body">
						{{csrf_field() }}
						{{method_field('PUT')}}
						<div class="mb-3">
							<label for="property_name">Name of property *</label>
							<div class="alert alert-danger" id="alert_name_listing_create" hidden></div>
							<input class="form-control" name="property_name" type="text" id="property_name">
						</div>
						<div class="mb-3">
							<label for="description">Description *</label>
							<div class="alert alert-danger" id="alert_desc_listing_create" hidden></div>
							<textarea class="form-control" name="description" type="text" id="description"></textarea>
						</div>
						<div class="mb-3">
							<label for="zone_entry_id">Sub-Zone *</label>
							<div class="alert alert-danger" id="alert_subzone_listing_create" hidden></div>
							<select class="form-control" id="zone_entry_id" name="zone_entry_id">
								<option value="" selected>Select sub-zone</option>
								@forelse($subZonesList as $subZoneItem)
								<option value="{{$subZoneItem->id}}">{{$subZoneItem->name}} ({{$subZoneItem->zone->name}}, {{$subZoneItem->zone->county}})</option>
								@empty
								<option value="" selected>(no sub-zones available)</option>
								@endforelse
							</select>
						</div>
						<div class="mb-3">
							<label for="lat">Latitude *</label>
							<div class="alert alert-danger" id="alert_lat_listing_create" hidden></div>
							<input class="form-control" name="lat" type="number" step="any" id="lat">
						</div>
						<div class="mb-3">
							<label for="lng">Longitude *</label>
							<div class="alert alert-danger" id="alert_lng_listing_create" hidden></div>
							<input class="form-control" name="lng" type="number" step="any" id="lng">
						</div>
						<div class="mb-3" style="height:100%; width:100%;">
							<div id="map" style="clear:both; height:300px;"></div>
						</div>
						<div class="mb-3">
							<label for="listing_type">Number of listings to be listed under this property *</label>
							<div class="alert alert-danger" id="alert_type_listing_create" hidden></div>
							<select class="form-control" id="listing_type" name="listing_type">
								<option value="" selected>Select property type</option>
								<option value="single">Just one (single-listing property)</option>
								<option value="multi">More than one one (multiple-listing property)</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="stories">Number of stories/floors in property building *</label>
							<div class="alert alert-danger" id="alert_stories_listing_create" hidden></div>
							<input class="form-control" name="stories" type="number" id="stories">
						</div>
						<div class="mb-3">
							<input type="checkbox" value="checkbox" id="checkbox"> <strong id="checkbox-tag" data-toggle="tooltip" title="Loading...">Price all listings under this property equally (what's this?)</strong>
						</div>
						<div class="mb-3" id="form_price" hidden>
							<label for="price">Price of rent/month for all listings under this property *</label>
							<div class="alert alert-danger" id="alert_price_listing_create" hidden></div>
							<input class="form-control" name="price" type="number" step=".01" id="price">
						</div>
						<div class="mb-3">
							<label for="thumbnail">Change thumbnail</label>
							<input class="file-path-wrapper" accept="image/*" name="thumbnail" id="thumbnail" type="file" onchange="loadFile(event)">
							<img id="output" width="250px" style="margin: 15px" />
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
						<input class="btn btn-outline-primary" id="btnSubmit" type="submit" name="btn_submit" value="Update Property">
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modalCreateEntry" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="modalLabel">New Listing</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="post" action="{{route('lister.createListingEntry',['id'=>$listing->id])}}" enctype="multipart/form-data" onsubmit="return validateEntryCreateForm();">
					<div class="modal-body">
						{{csrf_field() }}
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
							@if($listing->price == null)
							<input class="form-control" name="entry_price" type="number" step=".01" min="0.1" id="entry_price">
							@else
							<input class="form-control" name="entry_price" type="number" step=".01" min="0.1" id="entry_price" placeholder="{{$listing->price}} (set at property level)" disabled>
							@endif
						</div>
						<div class="mb-3">
							<label for="images">Upload image(s)</label>
							<input class="file-path-wrapper" accept="image/*" name="images[]" id="images" type="file" required multiple />
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
						<input class="btn btn-outline-primary" id="btn_create" type="submit" value="Add Listing">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('thumbnail_button')
<form id="listing_thumb_form" method="post" action="{{route('lister.storeListingThumb',['id'=>$listing->id])}}" enctype="multipart/form-data">
    {{csrf_field()}}
    <div hidden>
        <input class="file-path-wrapper" accept="image/*" name="btn_thumb_listing_real" id="btn_thumb_listing_real" type="file" onchange="loadListingThumb(event)" />
    </div>
</form>
<input class="btn btn-sm btn-outline-primary btn-block" style="border-radius: 25px;display: block;margin: auto;" type="submit" name="btn_submit" id="btn_thumb_listing_faux" value="Change Thumbnail">
@endsection

@section('action_controls')
<!-- <input class="btn btn-lg btn-primary btn-block" style="margin-top:5px" type="button" value="Edit" name="btn_edit" data-bs-toggle="modal" data-bs-target="#modalUpdateListing" onclick="populateListingUpdateForm('{{$listing}}',this);">
<form method="post" action="{{route('lister.manageListing',['$id'=>$listing->id])}}" enctype="multipart/form-data">
	{{csrf_field()}}
	{{method_field('PUT')}}
	@if(count($entries)>=1)
		@if($listing->status=='unpublished')
		<input class="btn btn-lg btn-info btn-block" style="margin-top:5px" type="submit" value="Submit for Approval" name="btn_submit" id="btn_submit">
		@elseif($listing->status=='pending')
		<input class="btn btn-lg btn-warning btn-block" style="margin-top:5px" type="submit" value="Withdraw Submission for Approval" name="btn_submit" id="btn_revoke">
		@endif
	@endif
</form>
<input class="btn btn-lg btn-danger btn-block" style="margin-top:5px" type="submit" value="Delete Property" name="btn_delete" disabled> -->
@endsection

@section('management_script')
<script src="{{asset('js/listings-management.js')}}"></script>
<script src="{{asset('js/listing-entries.js')}}"></script>
@endsection