@extends('layouts.base_admin_tables')

@section('title')
<title>All Users | Beginners Pad</title>
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
        @if (Auth::user()->user_type === 2 || Auth::user()->user_type === 1)
        <a class="btn btn-mid btn-info" role="button" id="btn_add_user">+ Add User</a>
        @endif
	</div>
</div>
<br>
@endsection

@section ('col_centre')
<div class="panel panel-default">
    <div class="panel-heading text-capitalize">All Users</div>
    <div class="panel-body">
        <div class="post">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Account Type</th>
                        <th scope="col">Account Status</th>
                        <th scope="col">Date Registered</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="row-clickable" role="button" onclick="populateActionForm('{{$user}}',this);">
                        <th id="t_body_id" scope="row">{{$user->id}}</th>
                        <td id="t_body_name">{{$user->name}}</td>
                        @if ($user->user_type == 5)
                        <td id="t_body_type">Customer</td>
                        @elseif ($user->user_type == 4)
                        <td id="t_body_type">Lister</td>
                        @elseif ($user->user_type == 3)
                        <td id="t_body_type">Representative</td>
                        @elseif ($user->user_type == 2)
                        <td id="t_body_type">Super Administrator</td>
                        @endif
                        <td id="t_body_status">{{$user->status}}</td>
                        <td id="t_body_time">{{$user->created_at}}</td>
                    </tr>
                    @empty
                    <tr>No users</tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="modal fade" id="modalNewUser" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalLabel">Create User</h4>
                </div>
                <form method="post" action="{{route('superAdmin.storeUser')}}" enctype="multipart/form-data" onsubmit="return validateCreateUserForm();" id="formCreate">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name">User name</label>
                            <div class="alert alert-danger" id="alert_name" hidden></div>
                            <input id="name" class="form-control" type="text" name="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="alert alert-danger" id="alert_email" hidden></div>
                            <input id="email" class="form-control" type="text" name="email">
                        </div>
                        <div class="form-group">
                            <label for="telephone">Phone Number (+254xxxxxxxxx)</label>
                            <div class="alert alert-danger" id="alert_phone" hidden></div>
                            <input id="telephone" type="text" class="form-control" name="telephone">
                        </div>
                        @if (Auth::user()->user_type === 2)
                        <div class="form-group">
                            <label for="user_type">Account type</label>
                            <div class="alert alert-danger" id="alert_type" hidden></div>
                            <select class="form-control" id="user_type" name="user_type">
                                <option value="3">Representative</option>
                            </select>
                        </div>
                        @elseif (Auth::user()->user_type === 1)
                        <div class="form-group">
                            <label for="user_type">Account type</label>
                            <div class="alert alert-danger" id="alert_type" hidden></div>
                            <select class="form-control" id="user_type" name="user_type">
                                <option value="3">Representative</option>
                                <option value="2">Super Administrator</option>
                            </select>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="alert alert-danger" id="alert_password" hidden></div>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="btn_generate_password">Generate</button>
                                </span>
                                <input type="text" class="form-control" placeholder="" id="password">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input class="btn btn-primary" type="submit" value="Create" id="btn_create"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
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
<script src="{{asset('js/user-management-admin.js')}}"></script>
@endsection