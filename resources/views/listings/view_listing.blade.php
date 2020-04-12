@extends('layouts.base_view_listing')

@section('title')
    <title>{{$listing->property_name}} | Beginners Pad</title>
@endsection

@section('view_listing_ad_top')
	<div class="container-width" style="padding:10px; background-color:whitesmoke;">
		<h6 style="text-align:center;">Ad zone</h6>
	</div>
	<br>
@endsection

@section('upper_buttons')
	@if(Auth::check())
		@if (Auth::user()->user_type === 3 || Auth::user()->user_type === 2 || Auth::user()->user_type === 1)
			<div class="pull-xs-right">
				<a class="btn btn-mid btn-info" href="{{route('admin.manageListing',$listing->id)}}" role="button">Manage this Listing</a>
			</div>
		@endif
		@if (Auth::user()->user_type === 4 && Auth::user()->id === $listing->user_id)
			<div class="pull-xs-right">
				<a class="btn btn-mid btn-info" href="{{route('listing.manage',$listing->id)}}" role="button">Manage this Listing</a>
			</div>
		@endif
	@endif
@endsection

@section('action_buttons')
	<form action="/listings/{{$listing->id}}/view" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		@if(Auth::check())
			@if (Auth::user()->user_type === 5)
				@if ($listing->status == "approved")
					@if($favourite != null)
					<input class="btn btn-lg btn-primary btn-block" type="submit" value="Remove from Favourites" name="btn_submit"></input>
					@else
					<input class="btn btn-lg btn-primary btn-block" type="submit" value="Add to Favourites" name="btn_submit"></input>
					@endif
					@if($appl == null)
					<input class="btn btn-lg btn-info btn-block" type="submit" value="Apply" name="btn_submit"></input>
					@else
					<input class="btn btn-lg btn-info btn-block" type="submit" value="End Stay" name="btn_submit"></input>
					@endif
				@endif
			@endif
		@else
			@if ($listing->status == "approved")
			<input class="btn btn-lg btn-primary btn-block" type="submit" value="Add to Favourites" name="btn_submit" disabled></input>
			<input class="btn btn-lg btn-primary btn-block" type="submit" value="Login to apply" name="btn_submit"></input>
			@endif
		@endif
	</form>
@endsection

@section('view_listing_ad_right')
	<div style="padding:10px; background-color:whitesmoke;">
		<h6 style="text-align:center;">Ad zone</h6>
	</div>
@endsection

@section('reviews')
	<div>
		<h3>Reviews</h3>
		@forelse($reviews as $review)
		<div style="border:1px dashed lightgrey; padding:10px; background-color:whitesmoke;" id="review">
			<div class="row">
				@if(Auth::check())
					@if($review->customer_id == Auth::user()->id)
					<div class="col-md-9">
						<h6><strong>{{$review->customer_name}}</strong></h6>
					</div>
					<div class="col-md-3">
						<small class="pull-xs-right">Posted {{$review->created_at->diffForHumans()}}</small>
						<div style="float: right">
							<form action="/account/manage/my_reviews/{{$review->property_id}}/remove" method="post" enctype="multipart/form-data">
								{{csrf_field()}}
								{{method_field('DELETE')}}
								<input class="btn btn-xs btn-danger pull-xs-right" type="submit" value="x" name="btn_delete" data-toggle="tooltip" title="Delete"></input>
							</form>
						</div>
					</div>
					@else
					<div class="col-md-9">
						<h6><strong>{{$review->customer_name}}</strong></h6>
					</div>
					<div class="col-md-3">
						<small class="pull-xs-right">Posted {{$review->created_at->diffForHumans()}}</small>
					</div>
					@endif
				@else
				<div class="col-md-9">
					<h6><strong>{{$review->customer_name}}</strong></h6>
				</div>
				<div class="col-md-3">
					<small class="pull-xs-right">Posted {{$review->created_at->diffForHumans()}}</small>
				</div>
				@endif
			</div>
			<div class="row">
				<div class="col-md-1 col-md-offset-9">
					@if(Auth::check())
						@if($review->customer_id == Auth::user()->id)
						<a class="btn btn-primary btn-sm pull-xs-right" href="/account/manage/my_reviews/{{$review->property_id}}/edit">Edit</a>
						@endif
					@endif
				</div>
				<div class="col-md-2">
					<p><small class="pull-xs-right">
						<strong>Rating: {{$review->review_rating}}/5</strong>
					</small></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12"><p>{{$review->review}}</p></div>
			</div>
		</div>
		@empty
		<h6 style="text-align:center;">No reviews available</h6>
		@endforelse
	</div>
@endsection

@section('other_listings')
	<div class="panel panel-default">
		<div class="panel-heading">Other listings in {{$listing->location}} area</div>
		<div class="panel-body">
			<div class="post">
				<div class="row">
				@if($listingsList->count()>1)
					@forelse($listingsList as $listingSingle)
						@if(($listingSingle->id != $listing->id))
						<div class="card-big-clickable card-block" style="margin:9px; " role="button" onclick="location.href='/listings/{{$listingSingle->id}}/view';">
							<div class="col-md-5">
								@if($listingSingle->images != null)
								<img class="img-rounded" style="width:110px;height:100px;" src="/images/listings/{{$listingSingle->user_id}}/thumbnails/{{$listingSingle->images}}" alt="unable to display image">
								@elseif($listingSingle->images == null)
								<img class="img-rounded" style="width:110px;height:100px;" src="/images/listings/vector-house-icon.jpg" alt="unable to display image">
								@endif
							</div>
							<div class="col-md-6 col-md-offset-1">
								<span style="display: inline-block;width: 150px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"><strong>{{$listingSingle->property_name}}</strong></span>
								<span><small>{{$listingSingle->available_units}} unit(s) left</small></span><br>
								<span><small>{{$listingSingle->unit_area}} sq M</small></span><br>
								<span><small>KES {{number_format($listingSingle->cost, 2)}}</small></span><br>
							</div>
						</div>
						@endif
					@empty
					<p style="text-align:center;">No entries found</p>
					@endforelse
				@else
					<div class="col-md-12">
						<p style="text-align:center;">No entries found</p>
					</div>
				@endif
				</div>
			</div>
		</div>
	</div>
@endsection