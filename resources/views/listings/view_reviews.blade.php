@extends('layouts.base_no_panel')

@section('title')
    <title>Reviews - {{$listing->property_name}} | Beginners Pad</title>
@endsection

@section('content')

	<div class="container">
			
		<section class="flex-sect">
			<form action="" method="get" enctype="multipart/form-data">
				{{csrf_field()}}
			    <div class="container-width">
			        <div class="flex-title">{{$propertyDetails->property_name}}</div>

			        <h6 class="card-text">
	                    <small>
	                        Listed on {{$propertyDetails->created_at}}
	                    </small>
	                </h6>
	                <small class="pull-xs-right">
	                    <strong>Lister: {{$propertyDetails->lister_name}}</strong>
	                </small>

	                <div class="flex-title"></div>
			            
			    </div>

			    <div class="container-width">
				    <div class="flex-title">Reviews</div>

				    @foreach($reviews as $review)
		            <div class="card-big card-block">
                        <a>
                            <div class="flex-desc">
                                <strong> Review by {{$review->customer_name}} </strong>
                            </div>
                        </a>
                        <h6 class="card-text">
                            <a class="text-primary">
                                <strong class="text-primary">Rating: {{$review->review_rating}}/10</strong>
                            </a>
                            <small class="pull-xs-right">
                                Posted on {{$review->created_at}}
                            </small>
                            <br><br>
                            <h6>
                                {{$review->review}}
                            </h6>
                        </h6>
                                                        
                    </div>
		            @endforeach
				            
				</div>

			</form>
		    
		</section>

	</div>
	
@endsection