@extends('layouts.base_admin_tickets')

@section('ticket_button_area')
    
@endsection

@section ('panel_heading')
Tickets issued by @if ($tickets->first()->is_registered == 'true') <b>{{$tickets->first()->user->name}}</b> @else <b>{{$tickets->first()->email}}</b> @endif
@endsection