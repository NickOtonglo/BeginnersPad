@extends('layouts.base_user_profile')

@section('title')
    <title>Manage User | Beginners Pad</title>
@endsection

@section('admin_actions')
	@if($targetUser->id !== Auth::user()->id)
	<div class="btn-group me-2" role="group" aria-label="...">
		<button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
		<ul class="dropdown-menu">
			@if(Auth::user()->user_type < $targetUser->user_type)
				@if($targetUser->status == 'inactive')
				<li class="list-action" id="btn_activate"><a class="dropdown-item" role="button" onclick="">Activate</a></li>
				@endif
				@if($targetUser->status == 'active')
				<li class="list-action" id="btn_suspend"><a class="dropdown-item" role="button" onclick="">Suspend</a></li>
				@endif
				@if($targetUser->status == 'suspended')
				<li class="list-action" id="btn_restore"><a class="dropdown-item" role="button" onclick="">Restore</a></li>
				@endif
			@endif
			@if(Auth::user()->user_type === 1)
			<li class="list-action" id="btn_delete"><a class="dropdown-item" role="button" onclick="">Delete</a></li>
			@endif
		</ul>
	</div>
	@endif
@endsection

@section('col_left')
<div class="card-big card-block bp-card-big-shadow-fx">
	<h6 class="bp-profile-text">Email address: {{$targetUser->email}}</h6>
	<h6 class="bp-profile-text">Registered on {{$targetUser->created_at}}</h6>
	<h6 class="bp-profile-text">Account status: <strong>{{$targetUser->status}}</strong></h6>
	<h6 class="bp-profile-text">
	    Phone number:
	    @if ($targetUser->telephone != null)
	        +{{$targetUser->telephone}}
	    @else
	        Not set
	    @endif
	</h6>
</div>
<div class="card-big card-block bp-card-big-shadow-fx">
	@if ($targetUser->user_type == 5)
	<h6 class="text-muted">Total number of times user occupied listings: {{count($customerOccupations)}}</h6>
	<h6 class="text-muted">Total number of listing reviews done: {{count($customerReviews)}}</h6>
	<h6 class="text-muted">
		Last listing occupied on:
	    @if($customerLastOccupation != null)
	    	{{$customerLastOccupation->created_at}}
	    @else
	    	(No listings occupied)
		@endif
	</h6>
	<h6 class="text-muted">
		Last listing review done on:
	    @if($customerLastReview != null)
	    	{{$customerLastReview->updated_at}}
	    @else
	    	(No reviews done)
	    @endif
	</h6>
	<h6 class="text-muted">Number of times suspended: {{count($customerSuspendedCount)}}</h6>
	@elseif ($targetUser->user_type == 4)
	<h6 class="text-muted">Number of active properties listed: {{count($listerListings)}}</h6>
	<h6 class="text-muted">Current number of customers: {{count($listerCustomers)}}</h6>
	<h6 class="text-muted">Current number of pending applications: {{count($listerPendingApplications)}}</h6>
	<h6 class="text-muted">Current number of suspended listings: {{count($listerSuspendedListings)}}</h6>
	<h6 class="text-muted">Current number of rejected applications: {{count($listerRejectedApplications)}}</h6>
	<h6 class="text-muted">
		Last listing application approved on:
	    @if($listerLastSubmission != null)
	        {{$listerLastSubmission->created_at}}
	    @else
	        (No applications made)
		@endif
	</h6>
	<h6 class="text-muted">Number of times suspended: {{count($listerSuspendedCount)}}</h6>
	@elseif ($targetUser->user_type == 3)
	<h6 class="text-muted">Total number of suspended users: {{count($repUsersSuspended)}}</h6>
	<h6 class="text-muted">Total number of approved listings: {{count($repListingsApproved)}}</h6>
	<h6 class="text-muted">Total number of rejected listing applications: {{count($repListingsRejected)}}</h6>
	<h6 class="text-muted">Total number of suspended listings: {{count($repListingsSuspended)}}</h6>
	<h6 class="text-muted">Total number of deleted listings: {{count($repListingsDeleted)}}</h6>
	<h6 class="text-muted">Number of times suspended: {{count($repSuspendedCount)}}</h6>
	@elseif ($targetUser->user_type == 2 || $targetUser->user_type == 1)
	<h6 class="text-muted">Total number of users created: {{count($adminUsersCreated)}}</h6>
	<h6 class="text-muted">Total number of suspended users: {{count($adminUsersSuspended)}}</h6>
	<h6 class="text-muted">Total number of approved listings: {{count($adminListingsApproved)}}</h6>
	<h6 class="text-muted">Total number of rejected listing applications: {{count($adminListingsRejected)}}</h6>
	<h6 class="text-muted">Total number of suspended listings: {{count($adminListingsSuspended)}}</h6>
	<h6 class="text-muted">Total number of deleted listings: {{count($adminListingsDeleted)}}</h6>
		@if($targetUser->user_type == 2)
		<h6 class="text-muted">Number of times suspended: {{count($adminSuspendedCount)}}</h6>
		@endif
	@endif
</div>
@endsection

@section('bottom_scripts')
<script>
    let user = {!! json_encode($targetUser)!!};
</script>
<script src="{{asset('js/user-management-admin-individual.js')}}"></script>
@endsection