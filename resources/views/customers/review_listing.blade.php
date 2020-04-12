@extends('layouts.base_no_panel')

@section('title')
    <title>Review Listings | Beginners Pad</title>
@endsection

@section('content')

	<div class="container">
			
		<section class="flex-sect">
			<form action="/account/manage/my_applications/listings/{{$listing->id}}/review" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
			    <div class="container-width">
			        <div class="flex-title">{{$listing->property_name}}</div>

			        <div class="card-big card-block">
	                        <h6 class="card-text">
	                            <small>
	                                Added on {{$listing->created_at}}
	                            </small>
	                            <small class="pull-xs-right">
	                                <strong>Price: {{$listing->cost}}</strong>
	                            </small>
	                        </h6>
	                        <a class='text-primary'>
	                        	<p class="card-text">
	                            	<div class="flex-desc">Description</div>
	                        	</p>
	                            <h6 class="card-title pull-xs-left text-primary">
	                                {{$listing->description}}
	                            </h6>
	                        </a>
	                        
	                    </div>	
			            
			    </div>

			    <div class="container-width">
			        <div class="flex-desc">Specific details</div>

			        <div class="column">
			        	<div class="card-big card-block">
	                        <h6 class="card-text">
	                            Name: {{$listing->property_name}}
	                        </h6>
	                        <h6 class="card-text">
	                            For {rent/purchase}
	                        </h6>
	                        <h6 class="card-text">
	                            Added on: {{$listing->created_at}}
	                        </h6>
	                        <h6 class="card-text">
	                            Lister: {{$listing->lister_name}}
	                        </h6>
	                        <h6 class="card-text">
	                            Location: {{$listing->location}}
	                        </h6>
	                	</div>

	                	<div class="card-big card-block">
	                        <h6 class="card-text">
	                            Type of residence: {type}
	                        </h6>
	                        <h6 class="card-text">
	                            Available units: {{$listing->available_units}}
	                        </h6>
	                        <h6 class="card-text">
	                            Total units: {{$listing->units_sum}}
	                        </h6>
	                        <h6 class="card-text">
	                            Unit size: {{$listing->unit_area}} sq M
	                        </h6>
	                        <h6 class="card-text">
	                            Price: {{$listing->cost}}
	                        </h6>
	                	</div>
			        </div>

			        <div class="container-width">
			        	<div class="flex-desc">Images</div>
				        <div class="card-big card-block">
		                   images (in development)                            
		                </div>
			    	</div>

			    	<!-- <input class="btn btn-lg btn-primary" type="submit" value="Add to Favourites" name="btn_submit"></input>
			    	<input class="btn btn-lg btn-primary pull-xs-right" type="submit" value="Apply" name="btn_submit"></input> -->

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
				    <div class="flex-title">Review</div>

				    <div class="card-big card-block">
				        <div class="form-group">
							<label for="review">Write your review in the text area below.</label>
							<textarea class="form-control" type="text" name="review"></textarea>
						</div>

						<div class="form-group">
							<label for="review_rating">Rating (out of 5)</label>
							<select class="form-control" name="review_rating">
								<option value="1">1</option>
		    					<option value="2">2</option>
		    					<option value="3">3</option>
		    					<option value="4">4</option>
		    					<option selected="selected" value="5">5</option>
							</select>
						</div>

						<input class="btn btn-lg btn-primary pull-xs-right" type="submit" value="Submit" name="btn_submit">
		  						                        
		            </div>	
				            
				</div>
			</form>
		    
		</section>

	</div>
	
@endsection