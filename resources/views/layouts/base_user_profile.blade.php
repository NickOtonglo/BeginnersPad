@extends('layouts.base_no_panel')

@section('content')
<div class="row" style="margin: 30px;">
    <div class="container">
        <div class="card-big card-block" style="box-shadow:5px 5px 15px grey;padding:30px;">
            <div class="row">
                <div class="col-md-3 col-md-offset-0">
                    <div class="row">
                        @if ($targetUser->avatar != null)
                            <img style="width:150px;height:150px; display:block;margin-left:auto;margin-right:auto; border-radius:50%" src="/images/avatar/{{$targetUser->id}}/{{$targetUser->avatar}}" alt="unable to display image">
                        @elseif ($targetUser->avatar == null)
                            <img style="width:150px;height:150px; display:block;margin-left:auto;margin-right:auto; border-radius:50%" src="/images/avatar/avatar.png" alt="unable to display image">
                        @endif
                    </div>
                    <div class="row">
                        <div style="text-align:center;">
                            <h3 class="bp-navbar-text-colour">{{$targetUser->name}}</h3>
                            @if($targetUser->user_type == 5)
                            <p class="bp-navbar-text-colour">Customer</p>
                            @elseif($targetUser->user_type == 4)
                            <p class="bp-navbar-text-colour">Lister</p>
                            @elseif($targetUser->user_type == 3)
                            <p class="bp-navbar-text-colour">Representative</p>
                            @elseif($targetUser->user_type == 2)
                            <p class="bp-navbar-text-colour">Super Administrator</p>
                            @elseif($targetUser->user_type == 1)
                            <p class="bp-navbar-text-colour">System Administrator</p>
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
                        <h5 class="bp-navbar-text-colour">Joined on {{$targetUser->created_at->format('j M Y')}}</h5>
                        @elseif($targetUser->user_type == 4)
                        <h5 class="bp-navbar-text-colour">Joined on {{$targetUser->created_at->format('j M Y')}}</h5>
                        @elseif($targetUser->user_type == 3)
                        <h5 class="bp-navbar-text-colour">Registered on {{$targetUser->created_at->format('j M Y')}}</h5>
                        @elseif($targetUser->user_type == 2)
                        <h5 class="bp-navbar-text-colour">Registered on {{$targetUser->created_at->format('j M Y')}}</h5>
                        @elseif($targetUser->user_type == 1)
                        <h5 class="bp-navbar-text-colour">Created by the Big Bang!</h5>
                        @endif
                    </div>
                </div>
                <div class="col-md-9 col-md-offset-0">
                    <div class="btn-group" role="group" aria-label="..." style="float:right;">
                        @if(Auth::user()->user_type === 3 || Auth::user()->user_type === 2 || Auth::user()->user_type === 1)    
                            @if ($targetUser->user_type >= 4 && $tickets->isNotEmpty())
                            <a type="button" class="btn btn-default" style="border-radius: 3px 0px 0px 3px;" href="{{route('admin.viewUserTicket',['user'=>$targetUser->email])}}">Tickets</a>
                            <a type="button" class="btn btn-default" style="border-radius: 0px 0px 0px 0px;" href="{{route('admin.viewUserManagementLogs',['target'=>$targetUser])}}">Management Log</a>
                            @else
                            <a type="button" class="btn btn-default" style="border-radius: 3px 0px 0px 3px;" href="{{route('admin.viewUserManagementLogs',['target'=>$targetUser])}}">Management Log</a>
                            @endif
                            @yield('admin_actions')
                        @endif
                        @if($targetUser->id == Auth::user()->id)
                            @if(Auth::user()->user_type >= 4)
                            <a type="button" class="btn btn-default" style="border-radius: 3px 0px 0px 3px;" href="{{route('viewTicketHistory')}}">View My Tickets</a>
                            @endif
                            @yield('account_actions')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
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