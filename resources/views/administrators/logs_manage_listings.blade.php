@extends('layouts.base_admin_tables')

@section('title')
    <title>Logs - Listing Management | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="container">
	<div class="pull-right">
        @if($targetUsers == 'me')
        <form method="get" action="{{route('admin.viewListingManagementLogs',['$target'=>'all'])}}" enctype="multipart/form-data">
        @else
        <form method="get" action="{{route('admin.viewListingManagementLogs',['$target'=>''])}}" enctype="multipart/form-data">
        @endif
		{{csrf_field()}}
			@if($targetUsers == 'me')
			<input class="btn btn-sm btn-primary btn-filter" type="submit" name="btn_sort" value="Show All Administrators" id="btn_fetch_all">
			@else
			<!-- <input class="btn btn-sm btn-primary btn-filter" type="submit" name="btn_sort" value="Show Me Only" hidden> -->
			@endif
		</form>
	</div>
</div>
<br>
@endsection

@section ('col_centre')
<div class="row">
    <div class="modal fade" id="modalViewLog" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalLabel">View Action</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="log_id">#</label>
                        <input class="form-control" name="log_id" type="text" id="log_id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="features">Action</label>
                        <input class="form-control" name="action" type="text" id="action" readonly>
                    </div>
                    <div class="form-group">
                        <label for="features">Reason</label>
                        <input class="form-control" name="reason" type="text" id="reason" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading text-capitalize">Activity History</div>
    <div class="panel-body">
        <div class="post">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Property</th>
                        <th scope="col">Listing</th>
                        @if($targetUsers != 'me')
                        <th id="t_head_admin" scope="col">Admin</th>
                        @endif
                        <th scope="col">Action</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr class="row-clickable" role="button" onclick="populateLogModal('{{$log}}',this);">
                        <th id="t_body_id" scope="row">{{$log->id}}</th>
                        <td id="t_body_name">{{$log->listing->property_name}}</td>
                        @if ($log->listing_entry_id != '')
                        <td id="t_body_entry_name">{{$log->listingEntry->listing_name}}</td>
                        @else
                        <td id="t_body_entry_name">N/A</td>
                        @endif
                        @if($targetUsers != 'me')
                            @isset($log->user->name)
                            <td id="t_body_admin">{{$log->user->name}}</td>
                            @else
                            <td id="t_body_admin">deleted [id {{$log->admin_id}}]</td>
                            @endif
                        @endif
                        <td id="t_body_action" onclick="populateLogModal('{{$log}}',this);">{{$log->action}}</td>
                        @if($log->reason != '')
                        <td id="t_body_reason" onclick="populateLogModal('{{$log}}',this);">{{$log->reason}}</td>
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
        </div>
    </div>
</div>
@endsection

@section('bottom_scripts')
<script src="{{asset('js/listing-management-admin-logs.js')}}"></script>
@endsection