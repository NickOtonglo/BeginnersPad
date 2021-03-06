@extends('layouts.base_admin_tables')

@section('title')
<title>Help Categories Logs | Beginners Pad</title>
@endsection

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
    @if($targetUser == 'all')
	<div class="pull-right btn-group" role="group">
        <a class="btn btn-sm btn-outline-secondary" role="button" id="btn_logs" href="{{route('admin.viewHelpCategoryLogs',['target'=>'me'])}}">View My Activity</a>
	</div>
    @endif
</div>
<br>
@endsection

@section ('col_centre')
<div class="table-responsive">
    <h5>Help Category Activity Logs</h5>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ticket ID</th>
                <th scope="col">Name/Title</th>
                <th scope="col">Priority</th>
                <th scope="col">Action</th>
                @if($targetUser == 'all')
                <th scope="col">Admin</th>
                @endif
                <th scope="col">Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr class="row-clickable">
                <th id="t_body_id" scope="row">{{$log->id}}</th>
                <td id="t_body_ticket">{{$log->parent_id}}</td>
                <td id="t_body_name">{{$log->name}}</td>
                <td id="t_body_priority">{{$log->priority}}</td>
                <td id="t_body_action">{{$log->action}}</td>
                @if($targetUser == 'all')
                <td id="t_body_admin">{{$log->user->name}}</td>
                @endif
                <td id="t_body_time">{{$log->created_at}}</td>
            </tr>
            @empty
            <tr>No entries</tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection