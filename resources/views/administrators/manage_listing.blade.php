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
			<form method="post" action="{{route('admin.addListingBookmark',['listingId'=>$listing->id])}}" enctype="multipart/form-data">
			{{csrf_field()}}
				@if($bookmark != '')
				<input class="btn btn-sm btn-primary" type="submit" name="btn_bookmark" value="- Remove Bookmark" id="btn_remove_bookmark">
				@else
				<input class="btn btn-sm btn-info" type="submit" name="btn_bookmark" value="+ Add Bookmark">
				@endif
			</form>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<small>Property Details</small>
			<div style="border:1px solid lightgrey; padding:16px">
				<h3>{{$listing->property_name}}</h3>
				<hr>
				<img class="img-rounded" id="listing_img_thumb" style="width:375px;height:300px;display:block;margin-left:auto;margin-right:auto;" src="/images/listings/{{$listing->id}}/thumbnails/{{$listing->thumbnail}}" alt="unable to display image">
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
						<strong>Reason for rejection: </strong>{reason}<hr>
						@elseif($listing->status=='suspended')
						<strong class="text-danger">suspended</strong><br>
						<strong>Reason for suspension: </strong>{reason}<br>
						@else
                        <strong>invalid</strong><br>
						@endif
					</p>
					<p>Location: <i>{{$listing->zoneEntry->name}}, {{$listing->zoneEntry->zone->name}}, {{$listing->zoneEntry->zone->county}}
							@if ($listing->zoneEntry->zone->state != null)
							,{{$listing->zoneEntry->zone->state}}
							@endif
							{{$listing->zoneEntry->zone->country}}</i>
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
			@if (Auth::user()->user_type === 3 || Auth::user()->user_type === 2 || Auth::user()->user_type === 1)
			<form method="post" action="{{route('admin.performListingAction',['id'=>$listing->id])}}" enctype="multipart/form-data" id="action_form">
                {{csrf_field()}}
				{{method_field('PUT')}}
				<div class="form-group">
    				<div class="alert alert-danger" id="alert_subzone_listing_create" hidden></div>
    				<select class="form-control" id="listing_action" name="listing_action">
    					<option value="" selected>-select action to perform-</option>
    					@if(count($entries)>=1)
							@if($listing->status=='pending' || $listing->status=='suspended')
								@forelse($actions->where('action','!=','suspend')->where('action','!=','delete') as $action)
								<option class="text-capitalize" value="{{$action->action}}">{{$action->action}} listing</option>
								@empty
								<option value="" selected>(-no actions available-)</option>
								@endforelse
							@elseif($listing->status=='approved')
								@forelse($actions->where('action','suspend')->where('action','!=','delete') as $action)
								<option class="text-capitalize" value="{{$action->action}}">{{$action->action}} listing</option>
								@empty
								<option value="" selected>(-no actions available-)</option>
								@endforelse
							@elseif($listing->status=='rejected')
								@forelse($actions->where('action','!=','suspend') as $action)
								<option class="text-capitalize" value="{{$action->action}}">{{$action->action}} listing</option>
								@empty
								<option value="" selected>(-no actions available-)</option>
								@endforelse
							@endif
						@endif
					</select>
					<div class="modal fade" id="modalAction" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="modalLabel">Respond to Application</h4>
								</div>
								<div class="modal-body">
									<div class="form-group">
										<label for="action_reason">Give a brief but detailed reason for this action</label>
										<div class="alert alert-danger" id="alert_action_reason" hidden></div>
										<textarea class="form-control" name="action_reason" type="text" id="action_reason"></textarea>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-primary" id="btn_act">Confirm Action</button>
								</div>
							</div>
						</div>
					</div>
    			</div>
			</form>
			<input class="btn btn-lg btn-primary btn-block" style="margin-top:5px" type="submit" value="Confirm Action" name="btn_submit" id="btn_confirm">
			@endif
		</div>
		<div class="col-md-5 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Listings in {{$listing->property_name}}</div>
				<div class="panel-body">
					<div class="post">
						<div class="row">
							@forelse($entries as $entry)
							<a class="card-big-clickable card-block" style="margin:9px; " role="button" href="{{route('admin.manageListingEntry',['listingId'=>$listing->id,'entryId'=>$entry->id])}}">
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
<script src="{{asset('js/listings-management-admin.js')}}"></script>
<script src="{{asset('js/listing-entries.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{$API_KEY}}&callback=initMap" async defer></script>
<script src="{{asset('js/map-static-listings.js')}}"></script>
<script src="{{asset('js/map-listings.js')}}"></script>
@endsection