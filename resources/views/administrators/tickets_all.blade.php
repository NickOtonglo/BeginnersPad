@extends('layouts.base_admin_tickets')

@section('ticket_button_area')
    <div class="pull-right">
        <div class="btn-group" role="group">
            <a class="btn btn-mid btn-default" role="button" href="{{route('admin.viewUserManagementLogs',['target'=>''])}}">Statistics</a>
            <a class="btn btn-mid btn-default" role="button" href="{{route('admin.viewHelpFAQs')}}">F.A.Qs</a>
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
@endsection

@section ('panel_heading')
All Tickets
@endsection