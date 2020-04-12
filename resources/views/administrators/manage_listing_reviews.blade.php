@extends('layouts.base_no_panel')

@section('title')
    <title>Manage Listing Reviews | Beginners Pad</title>
@endsection

@section('content')

	<div class="container">
			
		<section class="flex-sect">
			<div class="container-width">
			    <h1><strong>{{$propertyDetails->property_name}}</strong></h1>

			    <div class="column card-text">
					<div>
						<small>
							Listed on {{$propertyDetails->created_at}}
						</small>
					</div>
					<div>
						<h6 class="pull-xs-right">
							Lister: <strong>{{$propertyDetails->lister_name}}</strong>
						</h6>
					</div>
				</div>
			</div>

			<div class="container-width">
				@if($mean == null)
				<h4 class="card-text">(Not rated)</h4>
				@elseif($mean == 5)
				<h4 class="card-text">Rating: <strong style=" color:green">{{$rating}}%</strong></h4>
				@elseif($mean >= 3 && $mean < 5)
				<h4 class="card-text">Rating: <strong>{{$rating}}%</strong></h4>
				@elseif($mean < 3)
				<h4 class="card-text">Rating: <strong style=" color:red">{{$rating}}%</strong></h4>
				@endif
			</div>

			<div class="container-width">
				<div class="flex-title">Reviews</div>
				    
				@forelse($reviews as $review)
		        <div style="border-top:1px dashed grey; padding:10px; background-color:whitesmoke;">
		        	<form action="{{route('deleteReview',['listing'=>$propertyDetails->id,'review'=>$review->id])}}" method="post" enctype="multipform-data">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input class="btn btn-sm btn-danger pull-xs-right" type="submit" value="x" name="btn_delete">
                    </form>
                    <a>
                        <div class="flex-desc">
                            <strong> Review by {{$review->customer_name}} </strong>
                        </div>
                    </a>
                    <h6 class="card-text">
                        <a class="text-primary">
                            <strong class="text-primary">Rating: {{$review->review_rating}}/5</strong>
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
                @empty
					<h4 style="text-align:center;">No reviews available</h4>
		        @endforelse
				<div style="border-top:1px dashed grey; padding:10px;"></div>            
			</div>
		    
		</section>

	</div>
	
@endsection