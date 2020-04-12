@extends('layouts.base_new_listing')

@section('title')
    <title>Manage - {{$listing->property_name}} | Beginners Pad</title>
@endsection

@section('listing-form')
	<div class="container-width">
		<div class="flex-title">Manage Listing</div>
		<div class="flex-desc">You can edit the details of your listing <strong>"{{$listing->property_name}}"</strong> below:</div>
		<div class="container">
			<form action="/manage_listings/{{$listing->id}}/manage" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
				{{method_field('PUT')}}
				<div class="form-group">
					<label for="property_name">Property name</label>
					<input class="form-control" type="text" name="property_name" id="property_name" value="{{$listing->property_name}}">
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<textarea class="form-control" type="text" name="description">{{$listing->description}}</textarea>
				</div>
				<div class="form-group">
					<label for="location">Location (Area)</label>
					<input class="form-control" type="text" name="location" value="{{$listing->location}}">
				</div>
				<div class="column">
					<div class="form-group">
						<label for="lat">Latitude</label>
						<input class="form-control" type="text" name="lat" id="lat" value="{{$listing->lat}}">
					</div>
					<div class="form-group">
						<label for="lng">Longitude</label>
						<input class="form-control" type="text" name="lng" id="lng" value="{{$listing->lng}}">
					</div>
				</div>
				<div class="form-group" style="height:100%; width:100%;">
					<div id="map" style="clear:both; height:400px;"></div>
				</div>
				<div class="form-group">
					<label for="available_units">Number of units available</label>
					<input class="form-control" type="text" name="available_units" value="{{$listing->available_units}}">
				</div>
				<div class="form-group">
					<label for="units_sum">Total number of units</label>
					<input class="form-control" type="text" name="units_sum" value="{{$listing->units_sum}}">
				</div>
				<div class="form-group">
					<label for="unit_area">Unit area (sq. M)</label>
					<input class="form-control" type="text" name="unit_area" value="{{$listing->unit_area}}">
				</div>
				<div class="form-group">
					<label for="cost">Rent cost per unit</label>
					<input class="form-control" type="text" name="cost" value="{{$listing->cost}}">
				</div>
				<div class="form-group">
					{{ Form::label('post_images','Upload image(s)') }}
				<br>
					{{ Form::file('post_images[]', ['class'=>'file-path-wrapper','style'=>'visibility:visible','accept'=>"image/*",'multiple']) }}
				</div>
				<div class="container">
					<div class="flex-desc">Images</div>
					<div class="home__slider center">
						<div class="bxslider">
							@forelse($images as $image)
								<img src="/images/listings/{{$listing->user_id}}/{{$image->file_name}}" alt="unable to display image">
								@empty
								<h2 style="text-align:center;">No images to display</h2>
							@endforelse
						</div>
					</div>
					<div class="container-width">
						@forelse($images as $image)
						<div class="cards">
							<div class="card" style="width:150px;height:178px;">
								{{csrf_field()}}
                        		<img style="width:150px;height:150px;" src="/images/listings/{{$listing->user_id}}/{{$image->file_name}}" alt="unable to display image">
                        		<a class="card-body btn btn-sm btn-danger" style="width:150px" href="{{route('deleteImage',['listing'=>$listing->id,'image'=>$image->id])}}">Delete</a>
							</div>
						</div>
						@empty
							<h2 style="text-align:center;">No images to display</h2>
						@endforelse
					</div>
				</div>
				<br>
				<input class="btn btn-primary pull-xs-right" type="submit" value="Save"></input>
			</form>
			<form action="/manage_listings/{{$listing->id}}/manage" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
				{{method_field('DELETE')}}
				<input class="btn btn-danger pull-xs-left" type="submit" value="Delete this listing"></input>
			</form>
		</div> 
	</div>

<script>
	$(function(){
		$('.bxslider').bxSlider({
			captions: false,
			slideWidth: 800
		});
	});
</script>
	
@endsection