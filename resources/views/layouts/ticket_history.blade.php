@extends('layouts.base_tickets')

@section('title')
    <title>My Tickets | Beginners Pad</title>
@endsection

@section('ticket_button_area')
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <div class="btn-group" role="group">
            <a class="btn btn-sm btn-outline-secondary" role="button" href="{{route('viewTicketHistory')}}">All</a>
            <a class="btn btn-sm btn-outline-secondary" role="button" href="{{route('viewTicketCategory', ['category' => 'pending'])}}">Pending</a>
            <a class="btn btn-sm btn-outline-secondary" role="button" href="{{route('viewTicketCategory', ['category' => 'resolved'])}}">Resolved</a>
            <a class="btn btn-sm btn-outline-secondary" role="button" href="{{route('viewTicketCategory', ['category' => 'open'])}}">Open</a>
            <a class="btn btn-sm btn-outline-secondary" role="button" href="{{route('viewTicketCategory', ['category' => 'closed'])}}">Closed</a>
	    </div>
	</div>
@endsection

@section ('panel_heading')
My Ticket History
@endsection