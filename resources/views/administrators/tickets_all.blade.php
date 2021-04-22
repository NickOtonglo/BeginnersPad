@extends('layouts.base_admin_tickets')

@section('ticket_button_area')
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <div class="btn-group" role="group">
            <a class="btn btn-sm btn-outline-secondary" role="button" href="">Statistics</a>
            <a class="btn btn-sm btn-outline-secondary" role="button" href="{{route('admin.viewHelpFAQs')}}">F.A.Qs</a>
            <a class="btn btn-sm btn-outline-secondary" role="button" href="">Help Topics</a>
            <a class="btn btn-sm btn-outline-secondary" role="button" href="{{route('admin.viewHelpCategories')}}">Help Categories</a>
	    </div>
        <div class="btn-group" role="group">
            <a class="btn btn-sm btn-outline-secondary" role="button" href="{{route('admin.viewTicketLogs',['ticket'=>'all'])}}">Action Log</a>
            <a class="btn btn-sm btn-outline-secondary" role="button" href="{{route('admin.assignedTickets',['user'=>'me'])}}">Assigned to me</a>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assigned to<span class="caret"></span></button>
            <ul class="dropdown-menu">
                @forelse($users->where('user_type','<=','3')->where('id','!=',Auth::user()->id) as $user)
                <li class="list-action" id="btn_activate"><a class="dropdown-item" role="button" onclick="" href="{{route('admin.assignedTickets',$user->id)}}">{{$user->name}}</a></li>
                @empty
                <li class="list-action" id=""><a class="dropdown-item" role="button" onclick="">-not applicable-</a></li>
                @endforelse
            </ul>
        </div>
	</div>
@endsection

@section ('panel_heading')
All Tickets
@endsection