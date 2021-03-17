@extends('layouts.base_tables')

@section('top_buttons')
<div class="container">
    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{ session()->get('message') }}
        </div>
    @endif
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ $errors->first() }}
        </div>
    @endforeach
    @yield('ticket_button_area')
</div>
<br>
@endsection

@section ('col_centre')
<div class="panel panel-default">
    <div class="panel-heading">@yield('panel_heading')</div>
    <div class="panel-body">
        <div class="post">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Topic</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Status</th>
                        <th scope="col">Assigned to</th>
                        <th scope="col">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr class="row-clickable" role="button" onclick="window.location='{{ route('viewTicket',['ticket'=>$ticket->id]) }}'">
                        <th id="t_body_id" scope="row">{{$ticket->id}}</th>
                        <td id="t_body_category">{{$ticket->topic}}</td>
                        @if($ticket->helpCategory->priority == 1)
                        <td id="t_body_priority">{{$ticket->helpCategory->priority}} (Lowest)</td>
                        @elseif($ticket->helpCategory->priority == 2)
                        <td id="t_body_priority">{{$ticket->helpCategory->priority}} (Low)</td>
                        @elseif($ticket->helpCategory->priority == 3)
                        <td id="t_body_priority">{{$ticket->helpCategory->priority}} (Moderate)</td>
                        @elseif($ticket->helpCategory->priority == 4)
                        <td id="t_body_priority">{{$ticket->helpCategory->priority}} (High)</td>
                        @elseif($ticket->helpCategory->priority == 5)
                        <td id="t_body_priority">{{$ticket->helpCategory->priority}} (Highest)</td>
                        @endif
                        <td id="t_body_status">{{$ticket->status}}</td>
                        @if($ticket->assigned_to != null)
                        <td id="t_body_assigned">{{$ticket->assignedToUser->name}}</td>
                        @else
                        <td id="t_body_assigned">Not assigned</td>
                        @endif
                        <td id="t_body_time">{{$ticket->created_at}}</td>
                    </tr>
                    @empty
                    <tr>No tickets</tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection