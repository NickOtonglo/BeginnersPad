@extends('layouts.base_beginner_info')

@section('title')
	<title>My Reviews | Beginners Pad</title>
@endsection

@section('beginner_panel_title')
	My Reviews
@endsection

@section('beginner_panel_body')
	@forelse($reviews as $review)
	<div class="card-big-clickable card-block" style="margin:9px;" role="button" onclick="location.href='/listings/{{$review->property_id}}/view#review';">
		<div>
			<form action="/account/manage/my_reviews/{{$review->property_id}}/remove" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
				{{method_field('DELETE')}}
				<input class="btn btn-xs btn-danger pull-xs-right" type="submit" value="x" name="btn_delete" data-toggle="tooltip" title="Delete"></input>
			</form>
		</div>
		<br>
		<div class="row">
			<div class="col-md-7">
				<span style="display: inline-block;width: 210px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"><h4>{{$review->listing->property_name}} <small>({{$review->listing->lister_name}})</small></h4></span><br>
				<span><small>Lister: <strong>{{$review->listing->lister_name}}</strong></small></span><br>
				<span><small>Reviewed on <strong>{{$review->updated_at}}</strong> sq M</small></span><br>
				<span><h6 class="card-title">Rating: <strong>{{$review->review_rating}}/5</strong></h6></span>
			</div>
			<div class="col-md-5">
				@if($review->listing->images != null)
	            <img class="img-rounded" style="width:150px;height:120px;" src="/images/listings/{{$review->listing->user_id}}/thumbnails/{{$review->listing->images}}" alt="unable to display image">
	            @elseif($review->listing->images == null)
	            <img class="img-rounded" style="width:150px;height:120px;" src="/images/listings/vector-house-icon.jpg" alt="unable to display image">
	            @endif
			</div>
		</div>
	</div>
	@empty
	<h4 style="text-align:center;">No reviews</h4>
	@endforelse
@endsection