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
            <a class="btn btn-mid btn-default" role="button" href="{{route('admin.viewUserManagementLogs',['target'=>''])}}">Statistics</a>
            <a class="btn btn-mid btn-default" role="button" href="{{route('admin.viewUserManagementLogs',['target'=>''])}}">F.A.Qs</a>
            <a class="btn btn-mid btn-default" role="button" href="{{route('admin.viewUserManagementLogs',['target'=>''])}}">Help Topics</a>
            <a class="btn btn-mid btn-default" role="button" href="{{route('admin.viewHelpCategories')}}">Help Categories</a>
	    </div>
        <div class="btn-group" role="group">
            <a class="btn btn-mid btn-default" role="button" href="{{route('admin.viewTicketLogs',['ticket'=>'all'])}}">Action Log</a>
            <a class="btn btn-mid btn-default" role="button" href="{{route('admin.assignedTickets',['user'=>'me'])}}">Assigned to me</a>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assigned to<span class="caret"></span></button>
            <ul class="dropdown-menu">
                @forelse($users->where('user_type','<=','3')->where('id','!=',Auth::user()->id) as $user)
                <li class="list-action" id="btn_activate"><a role="button" onclick="" href="{{route('admin.assignedTickets',$user->id)}}">{{$user->name}}</a></li>
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
                        <th scope="col">Topic</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Status</th>
                        <th scope="col">Assigned to</th>
                        <th scope="col">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    @if($ticket->assigned_to != null)
                    <tr class="row-clickable" role="button" onclick="setPriority('{{$ticket->helpCategory->priority}}',this);
                    setAssignedTo('{{$ticket->assignedToUser->name}}',this);
                    showViewUser('{{$ticket->user}}',this);
                    populateActionForm('{{$ticket}}',this);">
                    @else
                    <tr class="row-clickable" role="button" onclick="setPriority('{{$ticket->helpCategory->priority}}',this);
                    showViewUser('{{$ticket->user}}',this);
                    populateActionForm('{{$ticket}}',this);">
                    @endif
                        <th id="t_body_id" scope="row">{{$ticket->id}}</th>
                        <td id="t_body_email">{{$ticket->email}}</td>
                        <td id="t_body_reg">{{$ticket->is_registered}}</td>
                        <td id="t_body_category">{{$ticket->topic}}</td>
                        <td id="t_body_priority">{{$ticket->helpCategory->priority}}</td>
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

<div class="row">
    <div class="modal fade bd-example-modal-lg" id="modalViewTicket" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalLabel">Preview Ticket</h4>
                </div>
                <form onsubmit="return true;" method="post" enctype="multipart/form-data" id="formAction">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="mod_id" class="text-muted">Ticket ID</label>
                            <div class="alert alert-danger" id="alert_id" hidden></div>
                            <h4 id="mod_id" type="text" name="mod_id">Loading...</h4>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="mod_email" class="text-muted">Email Address</label>
                            <div class="alert alert-danger" id="alert_email" hidden></div>
                            <p id="mod_email" type="text" name="mod_email">Loading...</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="mod_reg" class="text-muted">Is registered</label>
                            <div class="alert alert-danger" id="alert_reg" hidden></div>
                            <p id="mod_reg" type="text" name="mod_reg">Loading...</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="mod_category" class="text-muted">Topic</label>
                            <div class="alert alert-danger" id="alert_category" hidden></div>
                            <p class="lead" id="mod_category" type="text" name="mod_category">Loading...</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="mod_priority" class="text-muted">Priority</label>
                            <div class="alert alert-danger" id="alert_priority" hidden></div>
                            <p id="mod_priority" type="text" name="mod_priority">Loading...</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="mod_description" class="text-muted">Description</label>
                            <div class="alert alert-danger" id="alert_status" hidden></div>
                            <p class="lead" id="mod_description" type="text" name="mod_description">Loading...</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="mod_status" class="text-muted">Status</label>
                            <div class="alert alert-danger" id="alert_status" hidden></div>
                            <p id="mod_status" type="text" name="mod_status">Loading...</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="mod_assign" class="text-muted">Assigned to</label>
                            <div class="alert alert-danger" id="alert_assign" hidden></div>
                            <p id="mod_assign" type="text" name="mod_assign">Loading...</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="mod_time" class="text-muted">Timestamp</label>
                            <div class="alert alert-danger" id="alert_time" hidden></div>
                            <p id="mod_time" type="text" name="mod_time">Loading...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="pull-left">
                            <div class="btn-group" data-toggle="buttons">
                                <a id="btn_view_user" type="button" class="btn btn-default hidden">View User</a>
                                <a id="btn_view_tickets" type="button" class="btn btn-default">View User's Tickets</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <div class="btn-group" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions<span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li class="list-action" id="pick_ticket" hidden><a role="button" onclick="">Pick Ticket</a></li>
                                    <li class="list-action" id="release_ticket" hidden><a role="button" onclick="">Release Ticket</a></li>
                                    <li class="list-action" id="close_resolved_ticket" hidden><a role="button" onclick="">Close as 'Resolved'</a></li>
                                    <li class="list-action" id="close_ticket" hidden><a role="button" onclick="">Close Ticket</a></li>
                                </ul>
                            </div>
                            <a id="btn_view_profile" type="button" class="btn btn-primary" style="border-radius: 0px 3px 3px 0px;">Go To Ticket</a>
                        </div>
                        <div class="form-group hidden" hidden>
                            <input type="submit" id="btn_pick" value="Pick Ticket" name="btn_action">
                            <input type="submit" id="btn_release" value="Release Ticket" name="btn_action">
                            <input type="submit" id="btn_close_resolved" value="Close as 'Resolved'" name="btn_action">
                            <input type="submit" id="btn_close" value="Close Ticket" name="btn_action">
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
<script src="{{asset('js/ticket-management-admin.js')}}"></script>
@endsection