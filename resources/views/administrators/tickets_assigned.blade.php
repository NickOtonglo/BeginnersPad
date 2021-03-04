@extends('layouts.base_tickets')

@section('ticket_button_area')
    @if($targetUser->user_type === 3 || $targetUser->user_type === 2 || $targetUser->user_type === 1)
    <div class="pull-right">
        <div class="btn-group" role="group">
            @if (Auth::user()->id === $targetUser->id)
            <a class="btn btn-mid btn-default" role="button" id="btn_history" href="{{route('admin.viewAdminTicketLogs',['user'=>'me'])}}">Ticket Activity</a>
            @else
            <a class="btn btn-mid btn-default" role="button" id="btn_history" href="{{route('admin.viewAdminTicketLogs',$targetUser->id)}}">Ticket Activity</a>
            @endif
	    </div>
	</div>
    @endif
@endsection

@section ('panel_heading')
Tickets assigned to <b>{{$targetUser->name}}</b> @if(Auth::user()->id === $targetUser->id) (ME) @endif
@endsection