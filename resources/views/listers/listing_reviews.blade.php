 @extends('layouts.base')

 @section('title')
    <title>Listing Reviews | Beginners Pad</title>
@endsection

 @section('content')

			<section class="flex-sect">
				<div class="container">
					<div class="flex-title">Listing Reviews</div>
					
					<div class="clearfix">
					</div>
					
					<div class="list-group notes-group">

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
				</div>
			
			</section>
@endsection