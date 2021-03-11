@extends('layouts.base_view_ticket')

@section('title')
    <title>Manage Ticket | Beginners Pad</title>
@endsection

@section ('top-msg-area')
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
@endsection

@section ('col_centre')
<div class="panel panel-default">
    <div class="panel-heading text-capitalize">Activity History</div>
    <div class="panel-body">
        <div class="post">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Previous status</th>
                        <th scope="col">Action</th>
                        <th scope="col">Action by</th>
                        <th scope="col">New status</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr class="row-clickable">
                        <th id="t_body_id" scope="row">{{$log->id}}</th>
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
    </div>
</div>
@endsection