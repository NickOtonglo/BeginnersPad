@extends('layouts.base_admin_tables')

@section('title')
<title>Help Tickets | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="container">
    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible">
            <strong>Success!</strong> {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach
    @yield('ticket_button_area')
</div>
<br>
@endsection

@section ('col_centre')
<div class="table-responsive">
    <h5>@yield('panel_heading')</h5>
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
                @if($ticket->assignedToUser != null)
                    @if($ticket->helpCategory != null)
                    <tr class="row-clickable" role="button" onclick="setPriority('{{$ticket->helpCategory->priority}}',this);
                        setAssignedTo('{{$ticket->assignedToUser->name}}',this);
                        showViewUser('{{$ticket->user}}',this);
                        populateActionForm('{{$ticket}}',this);">
                    @else
                    <tr class="row-clickable" role="button" onclick="setAssignedTo('{{$ticket->assignedToUser->name}}',this);
                        showViewUser('{{$ticket->user}}',this);
                        populateActionForm('{{$ticket}}',this);">
                    @endif
                @else
                    @if($ticket->helpCategory != null)
                    <tr class="row-clickable" role="button" onclick="setPriority('{{$ticket->helpCategory->priority}}',this);
                        showViewUser('{{$ticket->user}}',this);
                        populateActionForm('{{$ticket}}',this);">
                    @else
                    <tr class="row-clickable" role="button" onclick="showViewUser('{{$ticket->user}}',this);
                        populateActionForm('{{$ticket}}',this);">
                    @endif
                @endif
            @else
                @if($ticket->helpCategory != null)
                <tr class="row-clickable" role="button" onclick="setPriority('{{$ticket->helpCategory->priority}}',this);
                    showViewUser('{{$ticket->user}}',this);
                    populateActionForm('{{$ticket}}',this);">
                @else
                <tr class="row-clickable" role="button" onclick="showViewUser('{{$ticket->user}}',this);
                    populateActionForm('{{$ticket}}',this);">
                @endif
            @endif
                <th id="t_body_id" scope="row">{{$ticket->id}}</th>
                <td id="t_body_email">{{$ticket->email}}</td>
                <td id="t_body_reg">{{$ticket->is_registered}}</td>
                <td id="t_body_category">{{$ticket->topic}}</td>
                @if($ticket->helpCategory != null)
                <td id="t_body_priority">{{$ticket->helpCategory->priority}}</td>
                @else
                <td id="t_body_priority">invalid</td>
                @endif
                <td id="t_body_status">{{$ticket->status}}</td>
                @if($ticket->assigned_to != null)
                    @if($ticket->assignedToUser != null)
                    <td id="t_body_assigned">{{$ticket->assignedToUser->name}}</td>
                    @else
                    <td id="t_body_assigned">invalid [id = {{$ticket->assigned_to}}]</td>
                    @endif
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

<div class="row">
    <div class="modal fade" id="modalViewTicket"  tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Preview Ticket</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form onsubmit="return true;" method="post" enctype="multipart/form-data" id="formAction">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="mod_id" class="text-muted">Ticket ID</label>
                            <div class="alert alert-danger" id="alert_id" hidden></div>
                            <h4 id="mod_id" type="text" name="mod_id">Loading...</h4>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="mod_email" class="text-muted">Email Address</label>
                            <div class="alert alert-danger" id="alert_email" hidden></div>
                            <p id="mod_email" type="text" name="mod_email">Loading...</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="mod_reg" class="text-muted">Is registered</label>
                            <div class="alert alert-danger" id="alert_reg" hidden></div>
                            <p id="mod_reg" type="text" name="mod_reg">Loading...</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="mod_category" class="text-muted">Topic</label>
                            <div class="alert alert-danger" id="alert_category" hidden></div>
                            <p class="lead" id="mod_category" type="text" name="mod_category">Loading...</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="mod_priority" class="text-muted">Priority</label>
                            <div class="alert alert-danger" id="alert_priority" hidden></div>
                            <p id="mod_priority" type="text" name="mod_priority">Loading...</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="mod_description" class="text-muted">Description</label>
                            <div class="alert alert-danger" id="alert_status" hidden></div>
                            <p class="lead" id="mod_description" type="text" name="mod_description">Loading...</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="mod_status" class="text-muted">Status</label>
                            <div class="alert alert-danger" id="alert_status" hidden></div>
                            <p id="mod_status" type="text" name="mod_status">Loading...</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="mod_assign" class="text-muted">Assigned to</label>
                            <div class="alert alert-danger" id="alert_assign" hidden></div>
                            <p id="mod_assign" type="text" name="mod_assign">Loading...</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="mod_time" class="text-muted">Timestamp</label>
                            <div class="alert alert-danger" id="alert_time" hidden></div>
                            <p id="mod_time" type="text" name="mod_time">Loading...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <div class="pull-left">
                            <div class="btn-group" data-toggle="buttons">
                                <a id="btn_view_user" type="button" class="btn btn-outline-secondary" hidden>View User</a>
                                <a id="btn_view_tickets" type="button" class="btn btn-outline-secondary">View User's Tickets</a>
                            </div>
                        </div>
                        <div class="btn-group" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions<span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li class="list-action" id="pick_ticket" hidden><a class="dropdown-item" role="button" onclick="">Pick Ticket</a></li>
                                    <li class="list-action" id="release_ticket" hidden><a class="dropdown-item" role="button" onclick="">Release Ticket</a></li>
                                    <li class="list-action" id="close_resolved_ticket" hidden><a class="dropdown-item" role="button" onclick="">Close as 'Resolved'</a></li>
                                    <li class="list-action" id="close_ticket" hidden><a class="dropdown-item" role="button" onclick="">Close Ticket</a></li>
                                </ul>
                            </div>
                            <a id="btn_open_ticket" type="button" class="btn btn-outline-primary" style="border-radius: 0px 3px 3px 0px;">Go To Ticket</a>
                        </div>
                        <div class="mb-3 hidden" hidden>
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