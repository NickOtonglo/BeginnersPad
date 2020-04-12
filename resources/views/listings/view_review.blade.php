@extends('layouts.base_no_panel')

@section('title')
    <title>View Review - {{$listing->property_name}} | Beginners Pad</title>
@endsection

@section('content')

	<div class="container">
			
		<section class="flex-sect">
			<form action="/listings/{{$review->property_id}}/review/{{$review->id}}" method="get" enctype="multipart/form-data">
				{{csrf_field()}}
			    <div class="container-width">
			        <div class="flex-title">{{$review->property_name}}</div>

			        <div class="card-big card-block">
	                    <h6 class="card-text">
	                        <small>
	                            Posted on {{$review->created_at}} by Customer
	                        </small>
	                    </h6>
	                    <small class="pull-xs-right">
	                        <strong>Lister: {{$review->lister_name}}</strong>
	                    </small>
	                        	                        
	                </div>	
			            
			    </div>

			    <div class="container-width">
				    <div class="flex-title">Review</div>

				    <div class="card-big card-block">
				    	<small class="pull-xs-right">
	                        <strong>Rating: {{$review->review_rating}}/10</strong>
	                    </small>

				        <div class="form-group">
							{{$review->review}}
						</div>
		  						                        
		            </div>	
				            
				</div>
			</form>
		    
		</section>

	</div>
	
@endsection