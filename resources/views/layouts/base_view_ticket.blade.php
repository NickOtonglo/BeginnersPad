@extends('layouts.base_no_panel')

@section ('content')
    @yield('top-msg-area')
<br>

<div class="container-width">
    <div class="h3"><strong>Ticket # {{$ticket->id}}</strong></div>
    @if($ticket->is_registered == 'false')
    <div>Issued by <strong>{{$ticket->email}}</strong> on {{$ticket->created_at}} </div>
    @elseif($ticket->is_registered == 'true')
    <div>Issued by <a href="{{route('manageAccount')}}" role="button"><strong>{{$ticket->userEmail->name}}</strong></a> on {{$ticket->created_at}}</div>
    @endif   
    <div>
        @if($ticket->status == 'resolved')
        Status: <strong style="color:green">{{$ticket->status}}</strong>
        @elseif($ticket->status == 'pending')
        Status: <strong style="color:orange">{{$ticket->status}}</strong>
        @elseif($ticket->status == 'closed')
        Status: <strong style="color:red">{{$ticket->status}}</strong>
        @elseif($ticket->status == 'open')
        Status: <strong style="color:DeepSkyBlue">{{$ticket->status}}</strong>
        @endif
    </div>
    <div>
        @if($ticket->helpCategory->priority == '1')
        Priority: <strong>{{$ticket->helpCategory->priority}} (Lowest)</strong>
        @elseif($ticket->helpCategory->priority == '2')
        Status: <strong>{{$ticket->helpCategory->priority}} (Low)</strong>
        @elseif($ticket->helpCategory->priority == '3')
        Status: <strong">{{$ticket->helpCategory->priority}} (Moderate)</strong>
        @elseif($ticket->helpCategory->priority == '4')
        Status: <strong>{{$ticket->helpCategory->priority}} (High)</strong>
        @elseif($ticket->helpCategory->priority == '5')
        Status: <strong>{{$ticket->helpCategory->priority}} (Highest)</strong>
        @endif
    </div>
    <div>
        @if($ticket->assignedToUser != null)
            Assigned to: <strong>{{$ticket->assignedToUser->name}}</strong>
        @endif
    </div>
    <br>
</div>
<div class="container-width">
    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
        <h2>{{$ticket->topic}}</h2>
    </div>
</div>

<div class="container-width">
    <hr>
    <p>{{$ticket->description}}</p>
</div>

<div class="container">
    <div class="col-md-12 col-md-offset-0" style="margin-top: 80px;">
        @yield('col_centre')
    </div>
</div>
@endsection