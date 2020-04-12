@extends('layouts.base_no_panel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <h5>Latest Listings</h5>
            <div class="list-group">
                @forelse($p_listings as $p_listing)
                <a href="/listings/{{$p_listing->id}}/view" class="list-group-item">{{$p_listing->property_name}}</a>
                @empty
                <p class="list-group-item">No entries</p>
                @endforelse
            </div>
            <h5>Waiting List</h5>
            <div class="list-group">
                <p class="list-group-item">- no entries -</p>
            </div>
            <h5>My Favourites</h5>
            <div class="list-group">
                @forelse($p_favourites as $p_favourite)
                <a href="/listings/{{$p_favourite->property_id}}/view" class="list-group-item">{{$p_favourite->property_name}}</a>
                @empty
                <p>No entries</p>
                @endforelse
            </div>
        </div>
        <div class="col-md-0"></div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">@yield('beginner_panel_title')</div>
                <div class="panel-body">
                    @yield('beginner_panel_body')
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="container-width" style="padding:10px; background-color:whitesmoke;height: 100vh">
                <h6 style="text-align:center;">Ad zone</h6>
            </div>
        </div>
    </div>
</div>
@endsection