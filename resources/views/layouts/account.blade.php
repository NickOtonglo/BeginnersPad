@extends('layouts.base_user_profile')

@section('title')
    <title>My Profile | Beginners Pad</title>
@endsection

@section('account_actions')
<div class="btn-group" role="group">
	<button type="button" class="btn btn-outline-primary" id="btn_edit_profile">Edit Profile</button>
</div>
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

@section('col_right')
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Edit Profile</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3">
                        <div class="col-md-4 col-md-offset-0"></div>
                        <div class="col-md-4 col-md-offset-0" style="display: block;width:100%">
                            <form id="formAvatar" method="post" action="{{route('updateAccountDetails')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div id="div_img" >
                                    <input class="file-path-wrapper" accept="image/*" name="btn_submit" id="btn_img" type="file" onchange="loadAvatar(event);"/>
                                </div>
                            </form>
                            <div class="row">
                                <div class="card-big-clickable" style="width:150px;height:150px;margin: auto;border-radius:50%;padding: 0px"
                                 data-toggle="tooltip" title="Click to change" id="btn_img_faux" type="button">
                                    @if ($targetUser->avatar != null)
                                    <img style="width:150px;height:150px; display:block;margin:auto; border-radius:50%"
                                     src="/images/avatar/{{$targetUser->id}}/{{$targetUser->avatar}}" alt="unable to display image" id="img_avatar">
                                    @elseif ($targetUser->avatar == null)
                                    <img style="width:150px;height:150px; display:block;margin:auto; border-radius:50%"
                                     src="/images/avatar/avatar.png" alt="unable to display image" id="img_avatar">
                                    @endif
                                    <form id="formNoAvatar" method="post" action="{{route('updateAccountDetails')}}" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <input class="btn btn-sm btn-danger btn-top-delete btn-delete" style="border-radius:50%;margin: 15px" type="submit" value="X" name="btn_submit" data-toggle="tooltip"
                                            title="Remove" id="btn_remove_avatar">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-0"></div>
                    </div>
                </div>
                <hr>
                <form method="post" action="{{route('updateAccountDetails')}}" enctype="multipart/form-data" onsubmit="return validateDetailsForm();" id="formDetails">
                    {{csrf_field()}}
                    <div class="mb-3">
                        <h3>Account Details</h3>
                    </div>
                    <div class="mb-3">
                        <label for="name">Full name</label>
                        <div class="alert alert-danger" id="alert_name" hidden></div>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('name') }}</strong><br>
                            </span>
                        @endif
                        <input id="name" class="form-control" type="text" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <div class="alert alert-danger" id="alert_email" hidden></div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('email') }}</strong><br>
                            </span>
                        @endif
                        <input id="email" class="form-control" type="text" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="telephone">Phone Number (254xxxxxxxxx)</label>
                        <div class="alert alert-danger" id="alert_phone" hidden></div>
                        @if ($errors->has('telephone'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('telephone') }}</strong><br>
                            </span>
                        @endif
                        <input id="telephone" type="text" class="form-control" name="telephone">
                    </div>
                    <div class="mb-3">
                        <label for="username">Username (must be unique)</label>
                        <div class="alert alert-danger" id="alert_username" hidden></div>
                        <input id="username" type="text" class="form-control" name="username" onkeyup="/*this.value = this.value.toLowerCase();*/">
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-outline-primary" type="submit" value="Update" name="btn_submit" id="btn_update"></input>
                    </div>
                </form>
                <hr>
                <form method="post" action="{{route('updateAccountDetails')}}" enctype="multipart/form-data" onsubmit="return validatePasswordForm();" id="formPassword">
                    {{csrf_field()}}
                    <div class="mb-3">
                        <h3>Password</h3>
                    </div>
                    <div class="mb-3">
                        <label for="password_current">Current Password</label>
                        <div class="alert alert-danger" id="alert_password_current" hidden></div>
                        @if ($errors->has('password_current'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('password_current') }}</strong><br>
                            </span>
                        @endif
                        <input class="form-control" type="password" name="password_current" id="password_current">
                    </div>
                    <div class="mb-3">
                        <label for="password">New Password</label>
                        <div class="alert alert-danger" id="alert_password" hidden></div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('password') }}</strong><br>
                            </span>
                        @endif
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation">Re-enter New Password</label>
                        <div class="alert alert-danger" id="alert_password_confirmation" hidden></div>
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-outline-primary" type="submit" value="Change Password" name="btn_submit" id="btn_password"></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_scripts')
<script>
    let authUser = {!! json_encode(Auth::user())!!};
</script>
<script src="{{asset('js/account.js')}}"></script>
@endsection