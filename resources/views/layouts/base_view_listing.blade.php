@extends('layouts.base_no_panel')

@section('stylesheets')
	<link rel="shortcut icon" href="/assets/images/icon-star.png?v=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endsection

@section('top_scripts')
	<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
@endsection

@section('active_listings')
active
@endsection

@section('content')
@yield('view_listing_ad_top')
<div class="container">
	<div class="row">
		@yield('upper_buttons')
	</div>
	<div class="row">
		<div class="col-md-7">
			<div>
				<h1><strong>{{$listing->property_name}}</strong></h1>
				@if($mean == null)
				<h5 class="card-text" style="text-align:left;">(Not rated)</h5>
				@elseif($mean == 5)
				<h5 class="card-text" style="text-align:left;">Rating: <strong style=" color:green">{{$rating}}%</strong></h5>
				@elseif($mean >= 3 && $mean < 5)
				<h5 class="card-text" style="text-align:left;">Rating: <strong>{{$rating}}%</strong></h5>
				@elseif($mean < 3)
				<h5 class="card-text" style="text-align:left;">Rating: <strong style=" color:red">{{$rating}}%</strong></h5>
				@endif
				<div class="card-text">
					<h5>Price: <strong>KES {{number_format($listing->cost, 2)}}</strong>/month</h5>
				</div>
				<div class="card-text">
					<small>Added on {{$listing->created_at}}</small>
				</div>
			</div>
			<hr>
			<p class="jumbotron text-primary" >
				{{$listing->description}}
			</p>
			<div class="form-group" style="height:100%; width:100%;">
				<div class="column" hidden>
					<div class="form-group">
						<label for="lat">Latitude</label>
						<input class="form-control" type="text" name="lat" id="lat" value="{{$listing->lat}}">
					</div>
					<div class="form-group">
						<label for="lng">Longitude</label>
						<input class="form-control" type="text" name="lng" id="lng" value="{{$listing->lng}}">
					</div>
				</div>
				<div id="map" style="clear:both; height:400px;"></div>
			</div>
		</div>
		<div class="col-md-4 col-md-offset-1">
			<br>
			<div class="panel panel-default">
				<div class="panel-heading">Details</div>
				<div class="panel-body">
					<dl>
						<dt>Name:</dt>
						<dd>{{$listing->property_name}}</dd>
						<dt>Added on:</dt>
						<dd>{{$listing->created_at}}</dd>
						<dt>Lister:</dt>
						<dd>{{$listing->lister_name}}</dd>
						<dt>Location:</dt>
						<dd>{{$listing->location}}</dd>
						<dt>Available units:</dt>
						<dd>{{$listing->available_units}}</dd>
						<dt>Total units:</dt>
						<dd>{{$listing->units_sum}}</dd>
						<dt>Unit size:</dt>
						<dd>{{$listing->unit_area}} sq M</dd>
						<dt>Price:</dt>
						<dd>{{$listing->cost}}</dd>
					</dl>
					<hr>
					<div>
						<sup>Lister's profile</sup>
						<br>
						<a href="">
							<div class="card-big-clickable center" style=" border-radius: 50px 50px 50px 0px;width:260px;height:80px;">
								<div class="row">
									<div class="col-md-1" style="margin:10px;">
										@if ($lister->avatar != null)
											<img style="width:50px;height:50px; float:left; border-radius:50%; " src="/images/avatar/{{$lister->id}}/{{$lister->avatar}}" alt="unable to display image">
										@elseif ($lister->avatar == null)
											<img style="width:50px;height:50px; float:left; border-radius:50%" src="/images/avatar/avatar.png" alt="unable to display image">
										@endif
									</div>
									<div class="col-md-8 col-md-offset-1">
										<div style="float:center;margin:15px;">
											<span class="pull-xs-right" style="display: inline-block;width: 120px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis; text-align:center;"><strong>{{$lister->name}}</strong></span>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div>
						@yield('action_buttons')
					</div>
				</div>
			</div>
			<div class="row">
				@yield('view_listing_ad_right')
			</div>
		</div>
	</div>
	<hr>
	<section>
		<div class="container-fluid flex-desc">
			@forelse($images as $image)
				<div class="cards">
					<a href="/images/listings/{{$listing->user_id}}/{{$image->file_name}}" target="_blank">
						<div class="card img-rounded" style="width:130px;height:120px;">
							<img class="img-rounded" style="width:130px;height:120px;" src="/images/listings/{{$listing->user_id}}/{{$image->file_name}}" alt="unable to display image">
						</div>
					</a>
				</div>
			@empty
				<h2 style="text-align:center;">No images to display</h2>
			@endforelse
		</div>
	</section>
	<hr>
	<section>
		<div class="row">
			<div class="col-md-7">
				@yield('reviews')
			</div>
			<div class="col-md-4 col-md-offset-1" style="border-left:1px solid lightgrey; padding:10px;">
				@yield('other_listings')
			</div>
		</div>
	</section>
</div>
@endsection

@section('bottom_scripts')
  <script src="https://maps.googleapis.com/maps/api/js?key={{$API_KEY}}&callback=initMap"async defer></script>
  <script src="{{asset('js/map-script.js')}}"></script>
@endsection
