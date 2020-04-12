@extends('layouts.base_no_panel')

@section('title')
    <title>Account | Beginners Pad</title>
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endsection

@section('top_scripts')
    <script src="{{asset('js/telephone-validation.js')}}"></script>
@endsection

@section ('content')
<div class="row">
    <div class="container">
    @if ($errors->has('post_avatar'))
        <span class="help-block">
            <strong class="text-danger">{{ $errors->first('post_avatar') }}</strong><br>
        </span>
    @endif
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-1">
            <div class="card-big text-center"
            style="width:250px;border:1px solid white;background-image: linear-gradient(rgba(220, 217, 46, 0.6),rgba(220, 46, 138, 0.22)), url();box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16), 0 0 0 1px rgba(0, 0, 0, 0.08);">
                <div class="row">
                    <div style="padding-top:30px;">
                    @if ($targetUser->avatar != null)
                        <img class="center" style="width:150px;height:150px; float:center; border-radius:50%; border:1px solid white" src="/images/avatar/{{$targetUser->id}}/{{$targetUser->avatar}}" alt="unable to display image">
                    @elseif ($targetUser->avatar == null)
                        <img class="center" style="width:150px;height:150px; float:center; border-radius:50%; border:1px solid white" src="/images/avatar/avatar.png"
                        alt="unable to display image">
                    @endif
                    </div>
                </div>
                <div class="row">
                    <div class="pagination-centered" style="padding:20px;">
                        <div class="row"><h4><strong>{{$targetUser->name}}</strong></h4></div>
                        <div class="row"><i>{{$targetUser->email}}</i></div>
                        @if ($targetUser->telephone != null)
                            <div class="row">{{$targetUser->telephone}}</div>
                        @endif
                        <form action="/account" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row" style="padding:20px">
                                <input class="file-path-wrapper" accept="image/*" name="post_avatar" id="post_avatar" type="file" required>
                            </div>
                            <div class="row">
                                <input class="btn btn-sm btn-primary" type="submit" value="Update Avatar" name="btn_submit"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6">
        <!-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="container">
            <div class="flex-sect">
                <div class="pull-xs-right">
                    
                </div>
                <h1>Hello {{ ucfirst(Auth::user()->name) }},</h1>
                <p>Manage your account here.</p>
                
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        @if ($targetUser->user_type == 5)
        <div style="border:1px solid lightgrey; padding:16px">
            <h4>Account Details</h4>
            <hr>
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
        @elseif($targetUser->user_type == 4)
        <div style="border:1px solid lightgrey; padding:16px">
            <h4>Account Details</h4>
            <hr>
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
            <hr>
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
        @elseif($targetUser->user_type == 3)
        <div style="border:1px solid lightgrey; padding:16px">
            <h4>Account Details</h4>
            <hr>
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
            <hr>
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
        @elseif($targetUser->user_type == 2 || $targetUser->user_type == 1)
        <div style="border:1px solid lightgrey; padding:16px">
            <h4>Account Details</h4>
            <hr>
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
            <hr>
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
        @endif
    </div>
    <div class="col-md-7 col-md-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">Edit account details</div>
            <div class="panel-body">
                <form action="/account" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">Account Name</label>
                        <input class="form-control" type="text" name="name" value="{{$users->name}}" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('name') }}</strong><br>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="telephone">Phone Number (+254xxxxxxxxx)</label>
                        <input id="telephone" type="number" class="form-control" name="telephone" value="{{$users->telephone}}"
                        onfocusout="telephoneValidation(document.getElementById('telephone').value)" required>
                        @if ($errors->has('telephone'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('telephone') }}</strong><br>
                            </span>
                        @endif
                    </div>
                    <input class="btn btn-primary" type="submit" value="Update" name="btn_submit"></input>
                </form>
                <hr>
                <form action="/account" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input class="form-control" type="password" name="current_password" required>
                        @if ($errors->has('current_password'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('current_password') }}</strong><br>
                            </span>
                        @endif
                        <label for="password">New Password</label>
                        <input class="form-control" type="password" name="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('password') }}</strong><br>
                            </span>
                        @endif
                        <label for="password_confirmation">Re-enter New Password</label>
                        <input class="form-control" type="password" name="password_confirmation" required>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('password_confirmation') }}</strong><br>
                            </span>
                        @endif
                    </div>
                    <input class="btn btn-primary" type="submit" value="Change Password" name="btn_submit"></input>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_scripts')
    <script src="{{asset('js/telephone-validation.js')}}"></script>
@endsection