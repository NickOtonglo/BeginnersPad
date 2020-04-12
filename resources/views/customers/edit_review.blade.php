@extends('layouts.base_no_panel')

@section('title')
    <title>Edit Review | Beginners Pad</title>
@endsection

@section('content')

	<div class="container">
			
		<section class="flex-sect">
			<form action="/account/manage/my_reviews/{{$review->property_id}}/edit" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
				{{method_field('PUT')}}
			    <div class="container-width">
			        <div class="flex-title">{{$review->property_name}}</div>

			        <div class="flex-desc">Added on {{$review->created_at}}</div>
			    </div>

			    <div class="container-width">
					@if(count($errors)>0)
				        <ul>
				            @foreach($errors->all() as $error)
				            	<li class="alert alert-danger">{{$error}}</li>
				            @endforeach
				        </ul>
				    @endif
				</div>

			    <div class="container-width">
				    <div class="flex-title">Edit Review</div>

				    <div class="card-big card-block">
				        <div class="form-group">
							<label>Edit your review in the text area below.</label>
							<textarea class="form-control" type="text" name="review">{{$review->review}}</textarea>
						</div>

						<div class="form-group">
							<label for="review_rating">Rating (out of 10)</label>
							<select class="form-control" name="review_rating">
								<option value="1">1</option>
		    					<option value="2">2</option>
		    					<option value="3">3</option>
		    					<option value="4">4</option>
		    					<option selected="selected" value="5">5</option>
		    					<option value="6">6</option>
		    					<option value="7">7</option>
		    					<option value="8">8</option>
		    					<option value="9">9</option>
		    					<option value="10">10</option>
							</select>
						</div>

						<input class="btn btn-lg btn-primary pull-xs-right" type="submit" value="Update" name="btn_submit">
		  						                        
		            </div>	
				            
				</div>
			</form>
		    
		</section>

	</div>
	
@endsection