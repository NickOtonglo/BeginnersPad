@extends('layouts.base_admin_tables')

@section('title')
<title>Help Tickets | Beginners Pad</title>
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
	<div class="pull-right">
        <div class="btn-group" role="group">
            <a class="btn btn-mid btn-default" role="button" id="btn_history" href="{{route('admin.viewUserManagementLogs',['target'=>''])}}">Statistics</a>
            <a class="btn btn-mid btn-default" role="button" id="btn_history" href="{{route('admin.viewUserManagementLogs',['target'=>''])}}">F.A.Qs</a>
            <a class="btn btn-mid btn-default" role="button" id="btn_history" href="{{route('admin.viewUserManagementLogs',['target'=>''])}}">Help Topics</a>
	    </div>
        <div class="btn-group" role="group">
            <a class="btn btn-mid btn-default" role="button" id="btn_history" href="{{route('admin.viewUserManagementLogs',['target'=>''])}}">Assigned to me</a>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assigned to<span class="caret"></span></button>
            <ul class="dropdown-menu">
                @forelse($users->where('user_type','<=','3')->where('id','!=',Auth::user()->id) as $user)
                <li class="list-action" id="btn_activate"><a role="button" onclick="">{{$user->name}}</a></li>
                @empty
                <li class="list-action" id=""><a role="button" onclick="">-not applicable-</a></li>
                @endforelse
            </ul>
        </div>
	</div>
</div>
<br>
@endsection

@section ('col_centre')
<div class="panel panel-default">
    <div class="panel-heading text-capitalize">All Tickets</div>
    <div class="panel-body">
        <div class="post">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Is registered</th>
                        <th scope="col">Category</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Status</th>
                        <th scope="col">Assigned to</th>
                        <th scope="col">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr class="row-clickable" role="button" onclick="populateActionForm('{{$user}}',this);">
                        <th id="t_body_id" scope="row">{{$ticket->id}}</th>
                        <td id="t_body_email">{{$ticket->email}}</td>
                        <td id="t_body_reg">{{$ticket->is_registered}}</td>
                        <td id="t_body_category">{{$ticket->topic}}</td>
                        <td id="t_body_priority">Priority</td>
                        <td id="t_body_status">{{$ticket->status}}</td>
                        <td id="t_body_assigned">Not assigned</td>
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

<div class="row">
    <div class="modal fade" id="modalViewTicket" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalLabel">View User</h4>
                </div>
                <form onsubmit="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="act_name">User name</label>
                            <div class="alert alert-danger" id="alert_name_act" hidden></div>
                            <input id="act_name" class="form-control" type="text" name="act_name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="act_email">Email</label>
                            <div class="alert alert-danger" id="alert_email_act" hidden></div>
                            <input id="act_email" class="form-control" type="email" name="act_email" readonly>
                        </div>
                        <div class="form-group">
                            <label for="act_telephone">Phone Number (+254xxxxxxxxx)</label>
                            <div class="alert alert-danger" id="alert_phone_act" hidden></div>
                            <input id="act_telephone" type="text" class="form-control" name="act_telephone" readonly>
                        </div>
                        <div class="form-group">
                            <label for="act_user_type">Account Type</label>
                            <div class="alert alert-danger" id="alert_type_act" hidden></div>
                            <input id="act_user_type" type="text" class="form-control" name="act_user_type" readonly>
                        </div>
                        <div class="form-group">
                            <label for="act_timestamp">Time Registered</label>
                            <div class="alert alert-danger" id="alert_time_act" hidden></div>
                            <input id="act_timestamp" type="text" class="form-control" name="act_timestamp" readonly>
                        </div>
                        <div class="form-group">
                            <label for="act_status">Status</label>
                            <div class="alert alert-danger" id="alert_status_act" hidden></div>
                            <input id="act_status" type="text" class="form-control" name="act_status" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <div class="btn-group" role="group" aria-label="...">
                            <a id="btn_view_profile" type="button" class="btn btn-primary" style="border-radius: 3px 0px 0px 3px;">View Profile</a>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions<span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li class="list-action" id="btn_activate" hidden><a role="button" onclick="">Activate</a></li>
                                    <li class="list-action" id="btn_suspend" hidden><a role="button" onclick="">Suspend</a></li>
                                    <li class="list-action" id="btn_restore" hidden><a role="button" onclick="">Restore</a></li>
                                    <li class="list-action" id="btn_delete" hidden><a role="button" onclick="">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section ('bottom_scripts')
<script>
    let authUser = {!! json_encode(Auth::user())!!};
</script>
<!-- <script src="{{asset('js/user-management-admin.js')}}"></script> -->
@endsection