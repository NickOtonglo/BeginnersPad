@extends('layouts.base_admin_tables')

@section('title')
    <title>Logs - Tickets | Beginners Pad</title>
@endsection

@section ('col_centre')
<div class="table-responsive">
    <h5>Activity History</h5>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ticket ID</th>
                <th scope="col">Email Address</th>
                <th scope="col">Previous status</th>
                <th scope="col">Action</th>
                <th scope="col">Action by</th>
                <th scope="col">New status</th>
                <th scope="col">Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr class="row-clickable" role="button" onclick="window.location='{{ route('admin.viewTicket',['ticket'=>$log->ticket_id]) }}'">
                <th id="t_body_id" scope="row">{{$log->id}}</th>
                <td id="t_body_parent">{{$log->ticket_id}}</td>
                <td id="t_body_email">{{$log->user_email}}</td>
                <td id="t_body_old_status">{{$log->old_status}}</td>
                <td id="t_body_action">{{$log->action}}</td>
                <td id="t_body_action_by">{{$log->actionByUser->name}}</td>
                <td id="t_body_new_status">{{$log->new_status}}</td>
                <td id="t_body_time">{{$log->created_at}}</td>
            </tr>
            @empty
            <tr>No history</tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('bottom_scripts')

@endsection