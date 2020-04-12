@extends('layouts.base_no_panel')

@section('title')
    <title>Help Tickets | Beginners Pad</title>
@endsection

@section ('content')
    <div class="container">
        <div class="pull-xs-right">
            <a class="btn btn-mid btn-info" href="/help/assigned" role="button">
                Tickets assigned to me
            </a>
        </div>
        <div class="flex-sect">

            <section class="flex-sect jumbotron">
                <div class="container-width">

                    <div class="flex-title">Tickets</div>

                    <div class="card-big">
                        <table class="table-hover" style="width:100%" border="1" cellpadding="10">
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Is registered</th>
                                <th>Topic</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Assigned to</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                            @forelse($tickets as $ticket)
                            <tr>
                                <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';">{{$ticket->id}}</td>
                                <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';"><small>{{$ticket->email}}</small></td>
                                <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';">{{$ticket->is_registered}}</td>
                                <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';">{{$ticket->topic}}</td>
                                <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';"><small>{!! \Illuminate\Support\Str::words($ticket->description, 9,'...')  !!}</small></td>
                                @if($ticket->status == 'resolved')
                                <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';"><strong style="color:green">{{$ticket->status}}</strong></td>
                                @elseif($ticket->status == 'pending')
                                <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';"><strong style="color:orange">{{$ticket->status}}</strong></td>
                                @elseif($ticket->status == 'closed')
                                <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';"><strong style="color:red">{{$ticket->status}}</strong></td>
                                @elseif($ticket->status == 'open')
                                <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';"><strong style="color:DeepSkyBlue">{{$ticket->status}}</strong></td>
                                @endif
                                
                                @if ($ticket->assigned_to == null)
                                    <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';">Not assigned</td>
                                @else
                                    <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';"><small>{{\App\User::where(['id' => $ticket->assigned_to])->pluck('name')->first()}}</small></td>
                                @endif
                                <td role="button" onclick="location.href='/help/tickets/{{$ticket->id}}';"><small>{{$ticket->created_at}}</small></td>
                                <td align="center">
                                    <form action="/help/tickets/{{$ticket->id}}/action" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <select class="form-control" name="review_rating">
                                            <option>Choose action</option>
                                            @if ($ticket->status == "open")
                                            <option value="pick_ticket">Pick ticket</option>
                                            <option value="close_ticket">Close ticket</option>
                                            @endif
                                            @if ($ticket->status == "pending" && $ticket->assigned_to == ucfirst(Auth::user()->id))
                                            <option value="leave_ticket">Release ticket</option>
                                            <option value="close_resolved_ticket">Close as 'Resolved'</option>
                                            <option value="close_ticket">Close ticket</option>
                                            @endif
                                        </select>
                                        @if($ticket->status == "closed" || $ticket->status == "resolved")
                                        <input class="btn btn-xs pull-xs-right" type="submit" value="✔" name="btn_action" disabled>
                                        @else
                                        <input class="btn btn-xs btn-info pull-xs-right" type="submit" value="✔" name="btn_action">
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td>No tickets available</td></tr>
                            @endforelse

                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection