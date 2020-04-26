@extends('layouts.base_no_panel')

@section('title')
    <title>All Users | Beginners Pad</title>
@endsection

@section ('content')
    <div class="container">
        @if (Auth::user()->user_type === 2 || Auth::user()->user_type === 1)
            <div class="pull-xs-right">
                <a class="btn btn-mid btn-info" href="/manage-users/create" role="button">
                    Add User
                </a>
            </div>
        @endif
        <div class="flex-sect">

            <section class="flex-sect jumbotron">
                <div class="container-width">

                    <div class="flex-title">Users</div>

                    <div class="card-big">
                        <table class="table-hover" style="width:100%" border="1" cellpadding="10">
                            <tr>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>User Type</th>
                                <th>Status</th>
                                <th>Registration date</th>
                                <th>Account</th>
                            </tr>
                            @foreach($users as $user)
                            <tr role="button" onclick="location.href='/manage-users/all/{{$user->id}}';">
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                @if ($user->user_type == 5)
                                    <td>Customer</td>
                                @elseif ($user->user_type == 4)
                                    <td>Lister</td>
                                @elseif ($user->user_type == 3)
                                    <td>Representative</td>
                                @elseif ($user->user_type == 2)
                                    <td>Super Administrator</td>
                                @endif
                                <td>{{$user->status}}</td>
                                <td>{{$user->created_at}}</td>
                                @if ($user->status != "suspended")
                                    @if ($user->status == "inactive")
                                        <td align="center">
                                            <a class="btn btn-small btn-success" href="/manage-users/all/{{$user->id}}/activate">Activate</a>
                                            @if(Auth::user()->user_type == 1)
                                                <form action="/manage-users/all/{{$user->id}}/kick" method="post" enctype="multipart/form-data">
                                                    {{csrf_field()}}
                                                    {{method_field('DELETE')}}
                                                    <br><input class="btn btn-small btn-danger" type="submit" value="Delete" name="btn_delete"></input>
                                                </form>
                                            @endif
                                        </td>
                                    @else
                                        <td align="center">
                                            <a class="btn btn-small btn-primary" href="/manage-users/all/{{$user->id}}/suspend">Suspend</a>
                                        </td>
                                    @endif
                                @elseif ($user->status == "suspended")
                                    <td align="center">
                                        <a class="btn btn-small btn-info" href="/manage-users/all/{{$user->id}}/activate">Restore</a>
                                        @if(Auth::user()->user_type == 1)
                                            <form action="/manage-users/all/{{$user->id}}/kick" method="post" enctype="multipart/form-data">
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                                <br><input class="btn btn-small btn-danger" type="submit" value="Delete" name="btn_delete"></input>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection