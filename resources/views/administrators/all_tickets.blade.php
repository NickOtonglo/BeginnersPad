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
            <a class="btn btn-mid btn-default" role="button" id="btn_history" href="{{route('admin.viewHelpCategories')}}">Help Categories</a>
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
                            <label for="mod_id">Ticket ID</label>
                            <div class="alert alert-danger" id="alert_id" hidden></div>
                            <input id="mod_id" class="form-control" type="text" name="mod_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="mod_email">Email</label>
                            <div class="alert alert-danger" id="alert_email" hidden></div>
                            <input id="mod_email" class="form-control" type="email" name="mod_email" readonly>
                        </div>
                        <div class="form-group">
                            <label for="mod_reg">Is registered</label>
                            <div class="alert alert-danger" id="alert_reg" hidden></div>
                            <input id="mod_reg" type="text" class="form-control" name="mod_reg" readonly>
                        </div>
                        <div class="form-group">
                            <label for="mod_category">Category</label>
                            <div class="alert alert-danger" id="alert_category" hidden></div>
                            <input id="mod_category" type="text" class="form-control" name="mod_category" readonly>
                        </div>
                        <div class="form-group">
                            <label for="mod_priority">Priority</label>
                            <div class="alert alert-danger" id="alert_priority" hidden></div>
                            <input id="mod_priority" type="text" class="form-control" name="mod_priority" readonly>
                        </div>
                        <div class="form-group">
                            <label for="mod_status">Status</label>
                            <div class="alert alert-danger" id="alert_status" hidden></div>
                            <input id="mod_status" type="text" class="form-control" name="mod_status" readonly>
                        </div>
                        <div class="form-group">
                            <label for="mod_assign">Assigned to</label>
                            <div class="alert alert-danger" id="alert_assign" hidden></div>
                            <input id="mod_assign" type="text" class="form-control" name="mod_assign" readonly>
                        </div>
                        <div class="form-group">
                            <label for="mod_time">Timestamp</label>
                            <div class="alert alert-danger" id="alert_time" hidden></div>
                            <input id="mod_time" type="text" class="form-control" name="mod_time" readonly>
                        </div>
                    </div>
                    <di v class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <div class="btn-group" role="group" aria-label="...">
                            <a id="btn_view_profile" type="button" class="btn btn-primary" style="border-radius: 3px 0px 0px 3px;">Open Ticket</a>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions<span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li class="list-action" id="btn_pick" hidden><a role="button" onclick="">Pick Ticket</a></li>
                                    <li class="list-action" id="btn_release" hidden><a role="button" onclick="">Release Ticket</a></li>
                                    <li class="list-action" id="btn_close_resolved" hidden><a role="button" onclick="">Close as 'Resolved'</a></li>
                                    <li class="list-action" id="btn_close" hidden><a role="button" onclick="">Close Ticket</a></li>
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
<script src="{{asset('js/ticket-management-admin.js')}}"></script>
@endsection