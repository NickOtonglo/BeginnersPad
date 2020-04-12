@extends('layouts.base_no_panel')

@section('title')
    <title>My Tickets | Beginners Pad</title>
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endsection

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h5>Categories</h5>
            <div class="list-group">
                <a value="all" href="{{route('viewTicketHistory')}}" class="list-group-item">
                    All Tickets
                </a>
                <a value="pending" href="{{route('viewTicketCategory', ['category' => 'pending'])}}" class="list-group-item">
                    Pending Tickets
                </a>
                <a value="resolved" href="{{route('viewTicketCategory', ['category' => 'resolved'])}}" class="list-group-item">
                    Resolved Tickets
                </a>
                <a value="open" href="{{route('viewTicketCategory', ['category' => 'open'])}}" class="list-group-item">
                    Open Tickets
                </a>
                <a value="closed" href="{{route('viewTicketCategory', ['category' => 'closed'])}}" class="list-group-item">
                    Closed Tickets
                </a>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-1">
            <div class="flex-title" style="text-align:left;">My Tickets</div>
            <div class="card-big table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Topic</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Assigned to</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr>
                            <td role="button" onclick="location.href='/help/my_tickets/{{$ticket->id}}';">{{$ticket->id}}</td>
                            <td role="button" onclick="location.href='/help/my_tickets/{{$ticket->id}}';">{{$ticket->topic}}</td>
                            <td role="button" onclick="location.href='/help/my_tickets/{{$ticket->id}}';">
                                <small>{!! \Illuminate\Support\Str::words($ticket->description, 8,'...')  !!}</small>
                            </td>
                            @if($ticket->status == 'resolved')
                            <td class="success" role="button" onclick="location.href='/help/my_tickets/{{$ticket->id}}';">
                                <strong style="color:green">{{$ticket->status}}</strong>
                            </td>
                            @elseif($ticket->status == 'pending')
                            <td class="warning" role="button" onclick="location.href='/help/my_tickets/{{$ticket->id}}';">
                                <strong style="color:orange">{{$ticket->status}}</strong>
                            </td>
                            @elseif($ticket->status == 'closed')
                            <td class="danger" role="button" onclick="location.href='/help/my_tickets/{{$ticket->id}}';">
                                <strong style="color:red">{{$ticket->status}}</strong>
                            </td>
                            @elseif($ticket->status == 'open')
                            <td class="info" role="button" onclick="location.href='/help/my_tickets/{{$ticket->id}}';">
                                <strong style="color:DeepSkyBlue">{{$ticket->status}}</strong>
                            </td>
                            @endif
                            @if ($ticket->assigned_to == null)
                                <td role="button" onclick="location.href='/help/my_tickets/{{$ticket->id}}';">Not assigned</td>
                            @else
                                <td role="button" onclick="location.href='/help/my_tickets/{{$ticket->id}}';">
                                    <small>{{\App\User::where(['id' => $ticket->assigned_to])->pluck('name')->first()}}</small>
                                </td>
                            @endif
                            <td role="button" onclick="location.href='/help/my_tickets/{{$ticket->id}}';">
                                <small>{{$ticket->created_at}}</small>
                            </td>
                        </tr>
                        @empty
                        <tr><td>No tickets available</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection