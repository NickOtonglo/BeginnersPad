@extends('layouts.base_no_panel')

@section('title')
    <title>Manage Ticket | Beginners Pad</title>
@endsection

@section ('content')
<div class="container-width">
    <h2><strong>Ticket # {{$ticket->id}}</strong></h2>
    @if($ticket->is_registered == 'false')
    <h5 class="card-text" style="text-align:left;">Issued by: {{$ticket->email}}</h5>
    @elseif($ticket->is_registered == 'true')
    <h5 class="card-text" style="text-align:left;" role="button" onclick="location.href='/manage_user/{{$user->id}}/view';">Issued by: <u style="color:DeepSkyBlue">{{$ticket->email}}</u></h5>
    @endif

    <div class="column card-text">
        
    </div>
    
    <div class="column card-text">
        <div>
            <small>
                Issued on 2019-05-26 18:40:53
            </small>
        </div>
        <div>
            <h5 class="pull-xs-right">
                @if($ticket->status == 'resolved')
                Status: <strong style="color:green">{{$ticket->status}}</strong>
                @elseif($ticket->status == 'pending')
                Status: <strong style="color:orange">{{$ticket->status}}</strong>
                @elseif($ticket->status == 'closed')
                Status: <strong style="color:red">{{$ticket->status}}</strong>
                @elseif($ticket->status == 'open')
                Status: <strong style="color:DeepSkyBlue">{{$ticket->status}}</strong>
                @endif
            </h5>
        </div>
    </div>
    <div>
        <h6 class="pull-xs-right">
            @if($ticket->assigned_to != null)
            Assigned to: <strong>{{$admin->name}}</strong>
            @endif
        </h6>
    </div>
    <br>    
</div>
<div class="container">
    @if($ticket->topic == 'topic1')
    <h4>Topic: <strong>Topic 1</strong></h4>
    @elseif($ticket->topic == 'topic2')
    <h4>Topic: <strong>Topic 2</strong></h4>
    @elseif($ticket->topic == 'topic3')
    <h4>Topic: <strong>Topic 3</strong></h4>
    @elseif($ticket->topic == 'topic4')
    <h4>Topic: <strong>Topic 4</strong></h4>
    @elseif($ticket->topic == 'topic5')
    <h4>Topic: <strong>Topic 5</strong></h4>
    @endif
</div>
<div class="container jumbotron">
    {{$ticket->description}}
</div>
<!-- @if(Auth::user()->user_type === 2)
    @if($ticket->status == 'open')
        <div class="container">
            <select class="form-control" name="">
                <option>Choose action</option>
                @foreach($reps as $rep)
                <option value="{{$rep->id}}">{{$rep->name}}</option>
                @endforeach
            </select>
            <br>
        </div>
    @endif
@endif -->
<div class="container">
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
        <br>
        @if($ticket->status == "closed" || $ticket->status == "resolved")
        <input class="btn btn-xs pull-xs-right" type="submit" value="✔" name="btn_action" disabled>
        @else
        <input class="btn btn-xs btn-info pull-xs-right" type="submit" value="✔" name="btn_action">
        @endif
    </form>
</div>
@endsection