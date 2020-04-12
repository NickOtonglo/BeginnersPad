@extends('layouts.base_no_panel')

@section('title')
    <title>Manage User | Beginners Pad</title>
@endsection

@section('content')

<!-- <div class="container">
	<section class="flex-sect center">
		<div class="col-md-10 col-md-offset-1 card-big">
	        <div class="column" style="padding:30px;">
	            @if ($targetUser->avatar != null)
	                <img style="width:150px;height:150px; float:left; border-radius:50%" src="/imaavatar/{{$targetUser->id}}/{{$targetUser->avatar}}" alt="unable to display image">
	            @elseif ($targetUser->avatar == null)
	                <img style="width:150px;height:150px; float:left; border-radius:50%" src="/images/avatar/avatar.png" alt="unabledisplay image">
	            @endif
	            <div style="float:left;">
	                <strong>{{$targetUser->name}},</strong>
	                <br>
	                <i>{{$targetUser->email}}</i>
	                <br>
	                @if ($targetUser->telephone != null)
	                    {{$targetUser->telephone}}
	                @endif
	                <br>
	            </div>
	        </div>
	    </div>
	</section>
</div> -->

<div class="container">
	<div class="container-width card-big center" style="border-radius: 15px 50px 30px;">
		<div class="column" style="padding:30px;">
			@if ($targetUser->avatar != null)
				<img style="width:150px;height:150px; float:left; border-radius:50%" src="/images/avatar/{{$targetUser->id}}/{{$targetUser->avatar}}" alt="unable to display image">
			@elseif ($targetUser->avatar == null)
				<img style="width:150px;height:150px; float:left; border-radius:50%" src="/images/avatar/avatar.png" alt="unabledisplay image">
			@endif
			<div style="float:left;">
				<h4><strong>{{$targetUser->name}}</strong></h4>
				<br>
				<i>{{$targetUser->email}}</i>
				<br>
				@if ($targetUser->telephone != null)
					{{$targetUser->telephone}}
				@endif
				<br>
			</div>
		</div>
	</div>
</div>

<div class="container">		
	<section class="flex-sect">
		<form action="" method="get" enctype="multipart/form-data">
	        {{csrf_field()}}
	        <div class="container-width">
	            <div class="card-block">
	                @if ($targetUser->user_type == 5)
	                <div class="column" style="border:1px dashed grey; padding:16px">
	                    <div class="card-block">
	                        <h5 class="card-text">
	                            <small class="card-text">
	                                Email address: {{$targetUser->email}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Registered on {{$targetUser->created_at}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Account type: 
	                                @if ($targetUser->user_type == 5)
	                                    <strong>Customer</strong>
	                                @elseif ($targetUser->user_type == 4)
	                                    <strong>Lister</strong>
	                                @elseif ($targetUser->user_type == 3)
	                                    <strong>Representative</strong>
	                                @elseif ($targetUser->user_type == 2)
	                                    <strong>Super Administrator</strong>
	                                @elseif ($targetUser->user_type == 1)
	                                    <strong>System Administrator</strong>
	                                @endif
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Account status: <strong>{{$targetUser->status}}</strong>
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Phone number:
	                                @if ($targetUser->telephone != null)
	                                    {{$targetUser->telephone}}
	                                @else
	                                    Not set
	                                @endif
	                            </small>
	                        </h5>
	                        <!-- <h5 class="card-text">
	                            <small>
	                                &nbsp;
	                            </small>
	                        </h5> -->
	                    </div>
	                    <div class="card-block" style="border-left:1px dashed grey;">
	                        <h5 class="card-text">
	                            <small>
	                                Total number of listing applications made: {{count($customerApplications)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Total number of listing reviews done: {{count($customerReviews)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Last application made on:
	                                @if($customerLastApplication != null)
	                                    {{$customerLastApplication->created_at}}
	                                @else
	                                    (No applications made)
	                                @endif
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Last listing review done on:
	                                @if($customerLastReview != null)
	                                    {{$customerLastReview->updated_at}}
	                                @else
	                                    (No reviews done)
	                                @endif
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Number of times suspended: {{count($customerSuspendedCount)}}
	                            </small>
	                        </h5>
	                    </div>
	                </div>
	                @elseif($targetUser->user_type == 4)
	                <div class="column" style="border:1px dashed grey; padding:16px">
	                    <div class="card-block">
	                        <h5 class="card-text">
	                            <small class="card-text">
	                                Email address: {{$targetUser->email}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Registered on {{$targetUser->created_at}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Account type: 
	                                @if ($targetUser->user_type == 5)
	                                    <strong>Customer</strong>
	                                @elseif ($targetUser->user_type == 4)
	                                    <strong>Lister</strong>
	                                @elseif ($targetUser->user_type == 3)
	                                    <strong>Representative</strong>
	                                @elseif ($targetUser->user_type == 2)
	                                    <strong>Super Administrator</strong>
	                                @elseif ($targetUser->user_type == 1)
	                                    <strong>System Administrator</strong>
	                                @endif
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Account status: <strong>{{$targetUser->status}}</strong>
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Phone number:
	                                @if ($targetUser->telephone != null)
	                                    {{$targetUser->telephone}}
	                                @else
	                                    Not set
	                                @endif
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                &nbsp;
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                &nbsp;
	                            </small>
	                        </h5>
	                    </div>
	                    <div class="card-block" style="border-left:1px dashed grey;">
	                        <h5 class="card-text">
	                            <small>
	                                Number of active properties listed: {{count($listerListings)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Current number of customers: {{count($listerCustomers)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Current number of pending applications: {{count($listerPendingApplications)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Current number of suspended listings: {{count($listerSuspendedListings)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Current number of rejected applications: {{count($listerRejectedApplications)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Last listing application approved on:
	                                @if($listerLastApplication != null)
	                                    {{$listerLastApplication->created_at}}
	                                @else
	                                    (No applications made)
	                                @endif
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Number of times suspended: {{count($listerSuspendedCount)}}
	                            </small>
	                        </h5>
	                    </div>
	                </div>
	                @elseif($targetUser->user_type == 3)
	                <div class="column" style="border:1px dashed grey; padding:16px">
	                    <div class="card-block">
	                        <h5 class="card-text">
	                            <small class="card-text">
	                                Email address: {{$targetUser->email}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Registered on {{$targetUser->created_at}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Account type: 
	                                @if ($targetUser->user_type == 5)
	                                    <strong>Customer</strong>
	                                @elseif ($targetUser->user_type == 4)
	                                    <strong>Lister</strong>
	                                @elseif ($targetUser->user_type == 3)
	                                    <strong>Representative</strong>
	                                @elseif ($targetUser->user_type == 2)
	                                    <strong>Super Administrator</strong>
	                                @elseif ($targetUser->user_type == 1)
	                                    <strong>System Administrator</strong>
	                                @endif
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Account status: <strong>{{$targetUser->status}}</strong>
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Phone number:
	                                @if ($targetUser->telephone != null)
	                                    {{$targetUser->telephone}}
	                                @else
	                                    Not set
	                                @endif
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                &nbsp;
	                            </small>
	                        </h5>
	                    </div>
	                    <div class="card-block" style="border-left:1px dashed grey;">
	                        <h5 class="card-text">
	                            <small>
	                                Total number of suspended users: {{count($repUsersSuspended)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Total number of approved listings: {{count($repListingsApproved)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Total number of rejected listing applications: {{count($repListingsRejected)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Total number of suspended listings: {{count($repListingsSuspended)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Total number of deleted listings: {{count($repListingsDeleted)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Number of times suspended: {{count($repSuspendedCount)}}
	                            </small>
	                        </h5>
	                        
	                    </div>
	                </div>
	                @elseif($targetUser->user_type == 2 || $targetUser->user_type == 1)
	                <div class="column" style="border:1px dashed grey; padding:16px">
	                    <div class="card-block">
	                        <h5 class="card-text">
	                            <small class="card-text">
	                                Email address: {{$targetUser->email}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Registered on {{$targetUser->created_at}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Account type: 
	                                @if ($targetUser->user_type == 5)
	                                    <strong>Customer</strong>
	                                @elseif ($targetUser->user_type == 4)
	                                    <strong>Lister</strong>
	                                @elseif ($targetUser->user_type == 3)
	                                    <strong>Representative</strong>
	                                @elseif ($targetUser->user_type == 2)
	                                    <strong>Super Administrator</strong>
	                                @elseif ($targetUser->user_type == 1)
	                                    <strong>System Administrator</strong>
	                                @endif
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Account status: <strong>{{$targetUser->status}}</strong>
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Phone number:
	                                @if ($targetUser->telephone != null)
	                                    {{$targetUser->telephone}}
	                                @else
	                                    Not set
	                                @endif
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                &nbsp;
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                &nbsp;
	                            </small>
	                        </h5>
	                    </div>
	                    <div class="card-block" style="border-left:1px dashed grey;">
	                        <h5 class="card-text">
	                            <small>
	                                Total number of users created: {{count($adminUsersCreated)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Total number of suspended users: {{count($adminUsersSuspended)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Total number of approved listings: {{count($adminListingsApproved)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Total number of rejected listing applications: {{count($adminListingsRejected)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Total number of suspended listings: {{count($adminListingsSuspended)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Total number of deleted listings: {{count($adminListingsDeleted)}}
	                            </small>
	                        </h5>
	                        <h5 class="card-text">
	                            <small>
	                                Number of times suspended: {{count($adminSuspendedCount)}}
	                            </small>
	                        </h5>
	                        
	                    </div>
	                </div>
	                @endif
	            </div>
	            <div class="flex-sect">
					@if ($targetUser->status != "suspended")
						@if ($targetUser->status == "inactive")
							<div>
								<a class="btn btn-small btn-success" href="/manage_users/all/{{$targetUser->id}}/activate">*Activate*</a>
									@if(Auth::user()->user_type == 1)
										<form action="/manage_users/all/{{$targetUser->id}}/kick" method="post" enctype="multipart/form-data">
											{{csrf_field()}}
											{{method_field('DELETE')}}
											<input class="btn btn-small btn-danger pull-xs-right" type="submit" value="Delete" name="btn_delete"></input>
										</form>
									@endif
							</div>
						@else
							<div>
								<a class="btn btn-small btn-primary" href="/manage_users/all/{{$targetUser->id}}/suspend">Suspend</a>
							</div>
						@endif
					@elseif ($targetUser->status == "suspended")
						<div>
							<a class="btn btn-small btn-info" href="/manage_users/all/{{$targetUser->id}}/activate">Restore</a>
							@if(Auth::user()->user_type == 1)
								<form action="/manage_users/all/{{$targetUser->id}}/kick" method="post" enctype="multipart/form-data">
									{{csrf_field()}}
									{{method_field('DELETE')}}
									<input class="btn btn-small btn-danger pull-xs-right" type="submit" value="Delete" name="btn_delete"></input>
								</form>
							@endif
						</div>
					@endif
				</div>
			</div>
		</form>
	</section>
</div>
	
@endsection