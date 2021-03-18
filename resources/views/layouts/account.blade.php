@extends('layouts.base_user_profile')

@section('title')
    <title>My Profile | Beginners Pad</title>
@endsection

@section('account_actions')
<div class="btn-group" role="group">
	<button type="button" class="btn btn-primary" id="btn_edit_profile">Edit Profile</button>
</div>
@endsection

@section('col_left')
<div class="card-big card-block" style="box-shadow:5px 5px 15px grey;padding:30px;">
	<h5 class="text-muted">Email address: {{$targetUser->email}}</h5>
	<h5 class="text-muted">Registered on {{$targetUser->created_at}}</h5>
	<h5 class="text-muted">Account status: <strong>{{$targetUser->status}}</strong></h5>
	<h5 class="text-muted">
	    Phone number:
	    @if ($targetUser->telephone != null)
	        +{{$targetUser->telephone}}
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
	<h5 class="card-text">Number of times suspended: {{count($adminUsersSuspended)}}</h5> <!--incorrect-->
	@endif
</div>
@endsection

@section('col_right')


<div class="row">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalLabel">Add Entry</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-0"></div>
                            <div class="col-md-4 col-md-offset-0">
                                <form id="formAvatar" method="post" action="{{route('updateAccountDetails')}}" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div id="div_img" >
                                        <input class="file-path-wrapper" accept="image/*" name="btn_submit" id="btn_img" type="file" onchange="loadAvatar(event);"/>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="card" style="width:150px;height:150px;margin: auto;border-radius:50%" data-toggle="tooltip" title="Click to change" id="btn_img_faux">
                                        @if ($targetUser->avatar != null)
                                        <img style="width:150px;height:150px; display:block;margin-left:auto;margin-right:auto; border-radius:50%"
                                         src="/images/avatar/{{$targetUser->id}}/{{$targetUser->avatar}}" alt="unable to display image" id="img_avatar">
                                        @elseif ($targetUser->avatar == null)
                                        <img style="width:150px;height:150px; display:block;margin-left:auto;margin-right:auto; border-radius:50%"
                                         src="/images/avatar/avatar.png" alt="unable to display image" id="img_avatar">
                                        @endif
                                    </div>
                                    <form id="formNoAvatar" method="post" action="{{route('updateAccountDetails')}}" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <input class="btn btn-sm btn-danger btn-top-delete btn-delete" style="border-radius:50%;margin: 25px" type="submit" value="X" name="btn_submit" data-toggle="tooltip"
                                            title="Remove" id="btn_remove_avatar">
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-0"></div>
                        </div>
                    </div>
                    <hr>
                    <form method="post" action="{{route('updateAccountDetails')}}" enctype="multipart/form-data" onsubmit="return validateDetailsForm();" id="formDetails">
                        {{csrf_field()}}
                        <div class="form-group">
                            <h3>Account Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="name">Full name</label>
                            <div class="alert alert-danger" id="alert_name" hidden></div>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('name') }}</strong><br>
                                </span>
                            @endif
                            <input id="name" class="form-control" type="text" name="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="alert alert-danger" id="alert_email" hidden></div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('email') }}</strong><br>
                                </span>
                            @endif
                            <input id="email" class="form-control" type="text" name="email">
                        </div>
                        <div class="form-group">
                            <label for="telephone">Phone Number (254xxxxxxxxx)</label>
                            <div class="alert alert-danger" id="alert_phone" hidden></div>
                            @if ($errors->has('telephone'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('telephone') }}</strong><br>
                                </span>
                            @endif
                            <input id="telephone" type="text" class="form-control" name="telephone">
                        </div>
                        <div class="form-group">
                            <label for="username">Username (must be unique)</label>
                            <div class="alert alert-danger" id="alert_username" hidden></div>
                            <input id="username" type="text" class="form-control" name="username" onkeyup="/*this.value = this.value.toLowerCase();*/">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Update" name="btn_submit" id="btn_update"></input>
                        </div>
                    </form>
                    <hr>
                    <form method="post" action="{{route('updateAccountDetails')}}" enctype="multipart/form-data" onsubmit="return validatePasswordForm();" id="formPassword">
                        {{csrf_field()}}
                        <div class="form-group">
                            <h3>Password</h3>
                        </div>
                        <div class="form-group">
                            <label for="password_current">Current Password</label>
                            <div class="alert alert-danger" id="alert_password_current" hidden></div>
                            @if ($errors->has('password_current'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('password_current') }}</strong><br>
                                </span>
                            @endif
                            <input class="form-control" type="password" name="password_current" id="password_current">
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <div class="alert alert-danger" id="alert_password" hidden></div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('password') }}</strong><br>
                                </span>
                            @endif
                            <input class="form-control" type="password" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Re-enter New Password</label>
                            <div class="alert alert-danger" id="alert_password_confirmation" hidden></div>
                            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Change Password" name="btn_submit" id="btn_password"></input>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
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