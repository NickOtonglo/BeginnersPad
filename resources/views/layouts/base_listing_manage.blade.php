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
		@yield('top_buttons')
	</div>
	<br>
    @yield('lister_forms')
	<div class="row">
		<div class="col-md-6">
			<small>Property Details</small>
			<div style="border:1px solid lightgrey; padding:16px">
				<h3>{{$listing->property_name}}</h3>
				<hr>
				<img class="img-rounded" id="listing_img_thumb" style="width:375px;height:300px;display:block;margin-left:auto;margin-right:auto;" src="/images/listings/{{$listing->id}}/thumbnails/{{$listing->thumbnail}}" alt="unable to display image">
				@yield('thumbnail_button')
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
			@yield('action_controls')
		</div>
		<div class="col-md-5 col-md-offset-1">
			<div class="card">
				<div class="card-header">Listings in {{$listing->property_name}}</div>
				<div class="card-body">
					<div class="post">
						<div class="row">
							@forelse($entries as $entry)
							<a role="button" href="{{route('admin.manageListingEntry',['listingId'=>$listing->id,'entryId'=>$entry->id])}}">
                                <div class="card mb-3" style="max-width: 540px;margin: auto">
                                    <div class="row g-0">
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <span style="display: inline-block;width: calc(95%);white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                                    <h5 class="card-title">{{$entry->listing_name}}</h5>
                                                </span>
                                                @if($entry->status=='active')
                                                <p class="card-text text-success"><small>active</small></p>
                                                @elseif($entry->status=='inactive')
                                                <p class="card-text text-danger"><small>inactive</small></p>
                                                @elseif($entry->status=='occupied')
                                                <p class="card-text"><small>occupied</small></p>
                                                @endif
                                                @if($entry->initial_deposit<=0)
                                                <p><small class="card-text">Initial deposit: <strong>Not required</strong></small></p>
                                                @elseif($entry->initial_deposit>0)
                                                <p><small class="card-text">Initial deposit: <strong>Required</strong></small></p>
                                                @endif
                                            </div>
                                        </div>
                                        @if($entry->listingFile()->where('category','thumbnail')->first() != null)
                                        <div class="col-md-4" style="background-image: url('/images/listings/{{$listing->id}}/thumbnails/{{$data[$entry->id]}}');background-position: center;"></div>
                                        @elseif($listing->thumbnail == null)
                                        <div class="col-md-4" style="background-image: url('/images/listings/vector-house-icon.jpg');background-position: center;"></div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            @empty
                                <h4 style="text-align:center;">No listings in this property</h4>
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
@yield('management_script')
<script src="{{asset('js/listing-entries.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{$API_KEY}}&callback=initMap" async defer></script>
<script src="{{asset('js/map-static-listings.js')}}"></script>
<script src="{{asset('js/map-listings.js')}}"></script>
@endsection