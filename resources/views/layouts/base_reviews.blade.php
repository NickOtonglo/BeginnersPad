@extends('layouts.base_no_panel')

@section('content')

	<div class="container">
			
		<section class="flex-sect">
			<form action="" method="get" enctype="multipart/form-data">
				{{csrf_field()}}
			    <div class="container-width">
			        <div class="flex-title">{{$reviews->property_name}}</div>

			        <div class="card-big card-block">
	                    <h6 class="card-text">
	                        <small>
	                            Posted on {{$reviews->created_at}} by Customer
	                        </small>
	                    </h6>
	                    <small class="pull-xs-right">
	                        <strong>Lister: {{$reviews->lister_name}}</strong>
	                    </small>
	                        	                        
	                </div>

	                @yield('review_content')
			            
			    </div>

			</form>
		    
		</section>

	</div>
	
@endsection