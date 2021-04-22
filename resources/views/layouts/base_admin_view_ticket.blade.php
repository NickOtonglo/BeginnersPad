@extends('layouts.base_no_panel')

@section ('content')
    @yield('top-msg-area')
<br>

<div class="container-width">
    <div class="h3"><strong>Ticket # {{$ticket->id}}</strong></div>
    @if($ticket->is_registered == 'false')
    <div>Issued by <strong>{{$ticket->email}}</strong> on {{$ticket->created_at}} </div>
    @elseif($ticket->is_registered == 'true')
    <div>Issued by <a href="{{route('admin.viewUser',$ticket->userEmail->id)}}" role="button"><strong>{{$ticket->userEmail->name}}</strong></a> on {{$ticket->created_at}}</div>
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
        @if($ticket->assigned_to != null)
            @if($ticket->assignedToUser != null)
                @if($ticket->assignedToUser->user_type > Auth::user()->user_type)
                <div>Assigned to: <a href="{{route('admin.viewUser',$ticket->assignedToUser->id)}}" role="button"><strong>{{$ticket->assignedToUser->name}}</strong></a></div>
                @else
                Assigned to: <strong>{{$ticket->assignedToUser->name}}</strong>
                @endif
            @else
            Assigned to: <strong>invalid [id ={{$ticket->assigned_to}}]</strong>
            @endif
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

<div class="container-width">
    <br>
    <div class="pull-left">
        <form onsubmit="return true;" method="post" enctype="multipart/form-data" id="formAction" action="{{route('admin.performTicketAction',$ticket->id)}}">
            {{csrf_field()}}
            <div class="btn-group" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-lg btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions<span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        @if($ticket->status == 'open' || $ticket->status == 'reopened')
                        <li class="list-action" id="pick_ticket"><a class="dropdown-item" role="button" onclick="">Pick Ticket</a></li>
                        <li class="list-action" id="close_resolved_ticket"><a class="dropdown-item" role="button" onclick="">Close as 'Resolved'</a></li>
                        <li class="list-action" id="close_ticket"><a class="dropdown-item" role="button" onclick="">Close Ticket</a></li>
                        @endif
                        @if($ticket->status == 'pending')
                            @if($ticket->assignedTo == Auth::user()->id || Auth::user()->user_type === 1)
                            <li class="list-action" id="release_ticket"><a class="dropdown-item" role="button" onclick="">Release Ticket</a></li>
                            <li class="list-action" id="close_resolved_ticket"><a class="dropdown-item" role="button" onclick="">Close as 'Resolved'</a></li>
                            <li class="list-action" id="close_ticket"><a class="dropdown-item" role="button" onclick="">Close Ticket</a></li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
            <div class="form-group hidden" hidden>
                <input type="submit" id="btn_pick" value="Pick Ticket" name="btn_action">
                <input type="submit" id="btn_release" value="Release Ticket" name="btn_action">
                <input type="submit" id="btn_close_resolved" value="Close as 'Resolved'" name="btn_action">
                <input type="submit" id="btn_close" value="Close Ticket" name="btn_action">
            </div>
        </form>
	</div>
</div>
<div class="container">
    <div class="col-md-12 col-md-offset-0" style="margin-top: 80px;">
        @yield('col_centre')
    </div>
</div>
@endsection

@section ('bottom_scripts')
<script src="{{asset('js/ticket-management-admin-individual.js')}}"></script>
@endsection