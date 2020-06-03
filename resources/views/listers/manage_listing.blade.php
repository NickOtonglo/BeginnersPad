@extends('layouts.base_no_panel')

@section('title')
<title>Manage Property - {{$listing->property_name}} | Beginners Pad</title>
@endsection

@section ('content')
<div class="container">
		@if(session()->has('message'))
		<div class="row">
			<div class="alert alert-success alert-dismissible">
				<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Success!</strong> {{ session()->get('message') }}
			</div>
		</div>
		@endif
	<div class="row">
		<div class="pull-right">
			<a class="btn btn-sm btn-info" role="button" data-toggle="modal" data-target="#modalCreateEntry">+ Add Listing Entry</a>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="row">
			<div class="modal fade" id="modalUpdateListing" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="modalLabel">Edit Listing Property</h4>
						</div>
						<form method="post" action="/manage-listings/{{$listing->id}}/manage" enctype="multipart/form-data" onsubmit="return validateListingCreateForm();">
							<div class="modal-body">
								{{csrf_field() }}
								{{method_field('PUT')}}
								<div class="form-group">
									<label for="property_name">Name of property *</label>
									<div class="alert alert-danger" id="alert_name_listing_create" hidden></div>
									<input class="form-control" name="property_name" type="text" id="property_name">
								</div>
								<div class="form-group">
									<label for="description">Description *</label>
									<div class="alert alert-danger" id="alert_desc_listing_create" hidden></div>
									<textarea class="form-control" name="description" type="text" id="description"></textarea>
								</div>
								<div class="form-group">
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
								<div class="form-group">
									<label for="lat">Latitude *</label>
									<div class="alert alert-danger" id="alert_lat_listing_create" hidden></div>
									<input class="form-control" name="lat" type="number" step="any" id="lat">
								</div>
								<div class="form-group">
									<label for="lng">Longitude *</label>
									<div class="alert alert-danger" id="alert_lng_listing_create" hidden></div>
									<input class="form-control" name="lng" type="number" step="any" id="lng">
								</div>
								<div class="form-group" style="height:100%; width:100%;">
									<div id="map" style="clear:both; height:300px;"></div>
								</div>
								<div class="form-group">
									<label for="listing_type">Number of listings to be listed under this property *</label>
									<div class="alert alert-danger" id="alert_type_listing_create" hidden></div>
									<select class="form-control" id="listing_type" name="listing_type">
										<option value="" selected>Select property type</option>
										<option value="single">Just one (single-listing property)</option>
										<option value="multi">More than one one (multiple-listing property)</option>
									</select>
								</div>
								<div class="form-group">
									<label for="stories">Number of stories/floors in property building *</label>
									<div class="alert alert-danger" id="alert_stories_listing_create" hidden></div>
									<input class="form-control" name="stories" type="number" id="stories">
								</div>
								<div class="form-group">
									<input type="checkbox" value="checkbox" id="checkbox"> <strong id="checkbox-tag" data-toggle="tooltip" title="Loading...">Price all listings under this property equally (what's this?)</strong>
								</div>
								<div class="form-group" id="form_price" hidden>
									<label for="price">Price of rent/month for all listings under this property *</label>
									<div class="alert alert-danger" id="alert_price_listing_create" hidden></div>
									<input class="form-control" name="price" type="number" step=".01" id="price">
								</div>
								<div class="form-group">
									<label for="thumbnail">Change thumbnail</label>
									<input class="file-path-wrapper" accept="image/*" name="thumbnail" id="thumbnail" type="file" onchange="loadFile(event)">
									<img id="output" width="250px" style="margin: 15px" />
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<input class="btn btn-primary" id="btnSubmit" type="submit" name="btn_submit" value="Update Property">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modalCreateEntry" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="modalLabel">New Listing</h4>
						</div>
						<form method="post" action="{{route('lister.createListingEntry',['id'=>$listing->id])}}" enctype="multipart/form-data" onsubmit="return validateEntryCreateForm();">
							<div class="modal-body">
								{{csrf_field() }}
								<div class="form-group">
									<label for="listing_name">Name of listing *</label>
									<div class="alert alert-danger" id="alert_name_entry_create" hidden></div>
									<input class="form-control" name="listing_name" type="text" id="listing_name">
								</div>
								<div class="form-group">
									<label for="entry_description">Description</label>
									<div class="alert alert-danger" id="alert_desc_entry_create" hidden></div>
									<br><input type="checkbox" value="checkbox_description" id="checkbox_description"> <strong>Copy from property description</strong>
									<textarea class="form-control" name="entry_description" type="text" id="entry_description"></textarea>
								</div>
								<div class="form-group">
									<label for="floor_area">Floor area of listing in square-metres *</label>
									<div class="alert alert-danger" id="alert_floor_area_entry_create" hidden></div>
									<input class="form-control" name="floor_area" type="number" id="floor_area" min="1">
								</div>
								<div class="form-group">
									<label for="disclaimer">Disclaimer(s) (separate with commas)</label>
									<div class="alert alert-danger" id="alert_disclaimer_entry_create" hidden></div>
									<textarea class="form-control" name="disclaimer" type="text" id="disclaimer" placeholder="e.g. disclaimer 1,disclaimer 2,disclaimer 3...etc"></textarea>
								</div>
								<div class="form-group">
									<label for="features">Feature(s) (separate with commas)</label>
									<div class="alert alert-danger" id="alert_features_entry_create" hidden></div>
									<textarea class="form-control" name="features" type="text" id="features" placeholder="e.g. feature 1,feature 2,feature 3...etc"></textarea>
								</div>
								<div class="form-group">
									<input type="checkbox" value="checkbox_deposit" id="checkbox_deposit"> <strong>Set initial deposit</strong>
								</div>
								<div id="form_deposit" hidden>
									<div class="form-group">
										<label for="initial_deposit">Initial deposit amount</label>
										<div class="alert alert-danger" id="alert_initial_deposit_entry_create" hidden></div>
										<input class="form-control" name="initial_deposit" type="number" step=".01" min="0.1" id="initial_deposit">
									</div>
									<div class="form-group">
										<label for="initial_deposit_period">Initial deposit period in months</label>
										<div class="alert alert-danger" id="alert_deposit_period_entry_create" hidden></div>
										<input class="form-control" name="initial_deposit_period" type="number" min="1" id="initial_deposit_period" placeholder="at least 1 month">
									</div>
								</div>
								<div class="form-group">
									<label for="entry_price">Price of rent/month for this listing (KES) *</label>
									<div class="alert alert-danger" id="alert_price_entry_create" hidden></div>
									@if($listing->price == null)
									<input class="form-control" name="entry_price" type="number" step=".01" min="0.1" id="entry_price">
									@else
									<input class="form-control" name="entry_price" type="number" step=".01" min="0.1" id="entry_price" placeholder="{{$listing->price}} (set at property level)" disabled>
									@endif
								</div>
								<div class="form-group">
									<label for="images">Upload image(s)</label>
									<input class="file-path-wrapper" accept="image/*" name="images[]" id="images" type="file" required multiple />
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<input class="btn btn-primary" id="btnSubmit" type="submit" value="Add Listing">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<small>Property Details</small>
			<div style="border:1px solid lightgrey; padding:16px">
				<h3>{{$listing->property_name}}</h3>
				<hr>
				<img class="img-rounded" id="listing_img_thumb" style="width:375px;height:300px;display:block;margin-left:auto;margin-right:auto;" src="/images/listings/{{$listing->id}}/thumbnails/{{$listing->thumbnail}}" alt="unable to display image">
				<br>
				<form id="listing_thumb_form" method="post" action="{{route('lister.storeListingThumb',['id'=>$listing->id])}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div hidden>
                        <input class="file-path-wrapper" accept="image/*" name="btn_thumb_listing_real" id="btn_thumb_listing_real" type="file" onchange="loadListingThumb(event)" />
                    </div>
                </form>
                <input class="btn btn-sm btn-primary btn-block" style="border-radius:25px;" type="submit" name="btn_submit" id="btn_thumb_listing_faux" value="Change Thumbnail">
				<hr>
				<div class="card-text">
					<p>Status:
						@if($listing->status=='unpublished')
						<strong class="text-default">not submitted for publishing</strong><br>
						@elseif($listing->status=='pending')
						<strong class="text-info">pending approval</strong><br>
						@elseif($listing->status=='approved')
						<strong class="text-success">approved</strong><br>
						@elseif($listing->status=='rejected')
						<strong class="text-danger">rejected</strong><br>
						@elseif($listing->status=='suspended')
						<strong class="text-danger">suspended</strong><br>
						@endif
					</p>
					<p>Location: <i>{{$listing->zoneEntry->name}}, {{$listing->zoneEntry->zone->name}}, {{$listing->zoneEntry->zone->county}}
							@if ($listing->zoneEntry->zone->state != null)
							,{{$listing->zoneEntry->zone->state}}
							@endif
							,{{$listing->zoneEntry->zone->country}}</i>
					</p>
					<p>
						Rent price:
						@if($listing->price != null)
						<strong>KES {{$listing->price}}</strong>
						@else
						<strong>(to be set at listing-entry level)</strong>
						@endif
					</p>
					<p>Stories/Floors: <strong>{{$listing->stories}}</strong></p>
					<hr>
					<p>Description:</p>

					<body>{{$listing->description}}</body>
				</div>
				<hr>
				<div id="map-static" style="clear:both; height:200px;"></div>
			</div>
			<br>
			<input class="btn btn-lg btn-primary btn-block" style="margin-top:5px" type="submit" value="Edit" name="btn_edit" data-toggle="modal" data-target="#modalUpdateListing" onclick="populateListingUpdateForm('{{$listing}}',this);">
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
			<input class="btn btn-lg btn-danger btn-block" style="margin-top:5px" type="submit" value="Delete Property" name="btn_delete" disabled>
		</div>
		<div class="col-md-5 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Listings in {{$listing->property_name}}</div>
				<div class="panel-body">
					<div class="post">
						<div class="row">
							@forelse($entries as $entry)
							<a class="card-big-clickable card-block" style="margin:9px; " role="button" href="{{route('lister.manageListingEntry',['listingId'=>$listing->id,'entryId'=>$entry->id])}}">
								<div class="col-md-8 col-md-offset-0">
									<span style="display: inline-block;width: 210px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
										<h4>{{$entry->listing_name}}</h4>
									</span><br>
									@if($entry->status=='active')
									<span><small><strong class="text-success">active</strong></small></span><br>
									@elseif($entry->status=='inactive')
									<span><small><strong class="text-danger">inactive</strong></small></span><br>
									@elseif($entry->status=='occupied')
									<span><small><strong class="text-primary">occupied</strong></small></span><br>
									@endif
									@if($entry->initial_deposit<=0)
									<span><small>Initial deposit: <strong>Not required</strong></small></span>
									@elseif($entry->initial_deposit>0)
									<span><small>Initial deposit: <strong>Required</strong></small></span>
									@endif
								</div>
								<div class="col-md-4">
									@if($entry->listingFile()->where('category','thumbnail')->first() != null)
									<img class="img-rounded" style="width:125px;height:100px;float:right;" src="/images/listings/{{$listing->id}}/thumbnails/{{$entry->listingFile()->where('category','thumbnail')->first()->file_name}}" alt="unable to display image">
									@else
									<img class="img-rounded" style="width:125px;height:100px;float:right;" src="/images/listings/vector-house-icon.jpg" alt="unable to display image">
									@endif
								</div>
							</a>
							@empty
							<h4 style="text-align:center;">You have no listings in this property</h4>
							@endforelse
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection

@section('bottom_scripts')
<script>
	let listingObj = {!!json_encode($listing) !!};
	let entryObj = '';
</script>
<script src="{{asset('js/listings.js')}}"></script>
<script src="{{asset('js/listing-entries.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{$API_KEY}}&callback=initMap" async defer></script>
<script src="{{asset('js/map-static-listings.js')}}"></script>
<script src="{{asset('js/map-listings.js')}}"></script>
@endsection