@extends('layouts.base_admin_tables')

@section('title')
    <title>Logs - Listing Management | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="container">
    @if($targetUsers == 'me')
    <form method="get" action="{{route('admin.viewUserManagementLogs',['$target'=>'all'])}}" enctype="multipart/form-data">
    @else
    <form method="get" action="{{route('admin.viewUserManagementLogs',['$target'=>''])}}" enctype="multipart/form-data">
    @endif
	{{csrf_field()}}
		@if($targetUsers == 'me')
		<input class="btn btn-sm btn-outline-secondary btn-filter" type="submit" name="btn_sort" value="Show All Administrators" id="btn_fetch_all">
		@else
		@endif
	</form>
</div>
<br>
@endsection

@section ('col_centre')
<div class="table-responsive">
    <h5>Activity History</h5>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">User</th>
                <th scope="col">Account Type</th>
                @if($targetUsers != 'me')
                <th id="t_head_admin" scope="col">Admin</th>
                @endif
                <th scope="col">Action/Status</th>
                <th scope="col">Reason</th>
                <th scope="col">Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr class="row-clickable" role="button" onclick="window.location='{{ route('admin.viewUser',['user'=>$log->user_id]) }}'">
                <th id="t_body_id" scope="row">{{$log->id}}</th>
                <td id="t_body_name">{{$log->name}}</td>
                @if ($log->user_type == 2)
                <td id="t_body_type">Super Administrator</td>
                @elseif ($log->user_type == 3)
                <td id="t_body_type">Representative</td>
                @elseif ($log->user_type == 4)
                <td id="t_body_type">Lister</td>
                @elseif ($log->user_type == 5)
                <td id="t_body_type">Customer</td>
                @else
                <td id="t_body_entry_name">unknown</td>
                @endif
                @if($targetUsers != 'me')
                    @isset($log->admin->name)
                    <td id="t_body_admin">{{$log->admin->name}}</td>
                    @else
                    <td id="t_body_admin">deleted [id {{$log->admin_id}}]</td>
                    @endif
                @endif
                <td id="t_body_action">{{$log->status}}</td>
                @if($log->reason != '')
                <td id="t_body_reason">{{$log->reason}}</td>
                @else
                <td id="t_body_reason">none given</td>
                @endif
                <td id="t_body_time">{{$log->created_at}}</td>
            </tr>
            @empty
            <tr>No history</tr>
            @endforelse
        </tbody>
    </table>
@endsection

@section('bottom_scripts')

@endsection