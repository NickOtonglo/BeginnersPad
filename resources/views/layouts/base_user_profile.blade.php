@extends('layouts.base_no_panel')

@section('content')
<div class="row">
    <div class="container-width">
        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible">
            <strong>Success!</strong> {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endforeach
    </div>
</div>
<div class="row" style="margin: 30px;">
    <div class="container">
        <div class="card-big card-block bp-card-big-shadow-fx">
            <div class="row">
                <div class="col-md-3 col-md-offset-0">
                    <div class="row">
                        @if ($targetUser->avatar != null)
                            <img class="bp-user-avatar" style="width:180px;height:180px; display:block;margin:auto; border-radius:50%" src="/images/avatar/{{$targetUser->id}}/{{$targetUser->avatar}}" alt="unable to display image">
                        @elseif ($targetUser->avatar == null)
                            <img class="bp-user-avatar" style="width:180px;height:180px; display:block;margin:auto; border-radius:50%" src="/images/avatar/avatar.png" alt="unable to display image">
                        @endif
                    </div>
                    <div class="row">
                        <div style="text-align:center;">
                            <h3 class="bp-profile-text">{{$targetUser->name}}</h3>
                            @if($targetUser->user_type == 5)
                            <p class="bp-profile-text">Customer</p>
                            @elseif($targetUser->user_type == 4)
                            <p class="bp-profile-text">Lister</p>
                            @elseif($targetUser->user_type == 3)
                            <p class="bp-profile-text">Representative</p>
                            @elseif($targetUser->user_type == 2)
                            <p class="bp-profile-text">Super Administrator</p>
                            @elseif($targetUser->user_type == 1)
                            <p class="bp-profile-text">System Administrator</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-md-offset-0">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-0">
                    <div style="text-align:center;">
                        @if($targetUser->user_type == 5)
                        <h6 class="bp-profile-text">Joined on {{$targetUser->created_at->format('j M Y')}}</h6>
                        @elseif($targetUser->user_type == 4)
                        <h6 class="bp-profile-text">Joined on {{$targetUser->created_at->format('j M Y')}}</h6>
                        @elseif($targetUser->user_type == 3)
                        <h6 class="bp-profile-text">Registered on {{$targetUser->created_at->format('j M Y')}}</h6>
                        @elseif($targetUser->user_type == 2)
                        <h6 class="bp-profile-text">Registered on {{$targetUser->created_at->format('j M Y')}}</h6>
                        @elseif($targetUser->user_type == 1)
                        <h6 class="bp-profile-text">Created by the Big Bang!</h6>
                        @endif
                    </div>
                </div>
                <div class="col-md-9 col-md-offset-0">
                    <div class="btn-group" role="group" aria-label="..." style="float:right;">
                        @if(Auth::user()->user_type === 3 || Auth::user()->user_type === 2 || Auth::user()->user_type === 1)    
                            @if ($targetUser->user_type >= 4 && $tickets->isNotEmpty())
                            <a type="button" class="btn btn-outline-secondary" style="border-radius: 3px 0px 0px 3px;" href="{{route('admin.viewUserTicket',['user'=>$targetUser->email])}}">Tickets</a>
                            <a type="button" class="btn btn-outline-secondary" style="border-radius: 0px 0px 0px 0px;" href="{{route('admin.viewUserManagementLogs',['target'=>$targetUser])}}">Management Log</a>
                            @else
                            <a type="button" class="btn btn-outline-secondary" style="border-radius: 3px 0px 0px 3px;" href="{{route('admin.viewUserManagementLogs',['target'=>$targetUser])}}">Management Log</a>
                            @endif
                            @yield('admin_actions')
                        @endif
                        @if($targetUser->id == Auth::user()->id)
                            @if(Auth::user()->user_type >= 4)
                            <a type="button" class="btn btn-outline-secondary" style="border-radius: 3px 0px 0px 3px;" href="{{route('viewTicketHistory')}}">View My Tickets</a>
                            @endif
                            @yield('account_actions')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin: 30px;">
    <div class="container">
        <div class="col-md-6 col-md-offset-0">
            @yield('col_left')
        </div>
        <div class="col-md-6 col-md-offset-0">
            @yield('col_right')
        </div>
    </div>
</div>
@endsection