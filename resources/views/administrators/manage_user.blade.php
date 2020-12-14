@extends('layouts.base_user_profile')

@section('title')
    <title>Manage User | Beginners Pad</title>
@endsection

@section('col_left')
<div class="card-big card-block" style="box-shadow:5px 5px 15px grey;padding:30px;">
	<h5 class="text-muted">Email address: {{$targetUser->email}}</h5>
	<h5 class="text-muted">Registered on {{$targetUser->created_at}}</h5>
	<h5 class="text-muted">Account status: <strong>{{$targetUser->status}}</strong></h5>
	<h5 class="text-muted">
	    Phone number:
	    @if ($targetUser->telephone != null)
	        {{$targetUser->telephone}}
	    @else
	        Not set
	    @endif
	</h5>
</div>
<div class="card-big card-block" style="box-shadow:5px 5px 15px grey;padding:30px;">
	@if ($targetUser->user_type == 5)
	<h5 class="card-text">Total number of times user occupied listings: {{count($customerOccupations)}}</h5>
	<h5 class="card-text">Total number of listing reviews done: {{count($customerReviews)}}</h5>
	<h5 class="card-text">
		Last listing occupied on:
	    @if($customerLastOccupation != null)
	    	{{$customerLastOccupation->created_at}}
	    @else
	    	(No listings occupied)
		@endif
	</h5>
	<h5 class="card-text">
		Last listing review done on:
	    @if($customerLastReview != null)
	    	{{$customerLastReview->updated_at}}
	    @else
	    	(No reviews done)
	    @endif
	</h5>
	<h5 class="card-text">Number of times suspended: {{count($customerSuspendedCount)}}</h5>
	@elseif ($targetUser->user_type == 4)
	<h5 class="card-text">Number of active properties listed: {{count($listerListings)}}</h5>
	<h5 class="card-text">Current number of customers: {{count($listerCustomers)}}</h5>
	<h5 class="card-text">Current number of pending applications: {{count($listerPendingApplications)}}</h5>
	<h5 class="card-text">Current number of suspended listings: {{count($listerSuspendedListings)}}</h5>
	<h5 class="card-text">Current number of rejected applications: {{count($listerRejectedApplications)}}</h5>
	<h5 class="card-text">
		Last listing application approved on:
	    @if($listerLastSubmission != null)
	        {{$listerLastSubmission->created_at}}
	    @else
	        (No applications made)
		@endif
	</h5>
	<h5 class="card-text">Number of times suspended: {{count($listerSuspendedCount)}}</h5>
	@elseif ($targetUser->user_type == 3)
	<h5 class="card-text">Total number of suspended users: {{count($repUsersSuspended)}}</h5>
	<h5 class="card-text">Total number of approved listings: {{count($repListingsApproved)}}</h5>
	<h5 class="card-text">Total number of rejected listing applications: {{count($repListingsRejected)}}</h5>
	<h5 class="card-text">Total number of suspended listings: {{count($repListingsSuspended)}}</h5>
	<h5 class="card-text">Total number of deleted listings: {{count($repListingsDeleted)}}</h5>
	<h5 class="card-text">Number of times suspended: {{count($repUsersSuspended)}}</h5>
	@elseif ($targetUser->user_type == 2 || $targetUser->user_type == 1)
	<h5 class="card-text">Total number of users created: {{count($adminUsersCreated)}}</h5>
	<h5 class="card-text">Total number of suspended users: {{count($adminUsersSuspended)}}</h5>
	<h5 class="card-text">Total number of approved listings: {{count($adminListingsApproved)}}</h5>
	<h5 class="card-text">Total number of rejected listing applications: {{count($adminListingsRejected)}}</h5>
	<h5 class="card-text">Total number of suspended listings: {{count($adminListingsSuspended)}}</h5>
	<h5 class="card-text">Total number of deleted listings: {{count($adminListingsDeleted)}}</h5>
	<h5 class="card-text">Number of times suspended: {{count($adminUsersSuspended)}}</h5>
	@endif
</div>
@endsection