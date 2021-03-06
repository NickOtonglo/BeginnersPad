@extends('layouts.base_no_panel')

@section('content')
    <br>
    @yield('top_buttons')
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-md-offset-0">
                <h5>My Highest Rated Listings</h5>
                <div class="list-group">
                    <a href="#" class="list-group-item">First item</a>
                    <a href="#" class="list-group-item">Second item</a>
                    <a href="#" class="list-group-item">Third item</a>
                </div>
                <h5>Highest Rated Listings</h5>
                <div class="list-group">
                    <a href="#" class="list-group-item">First item</a>
                    <a href="#" class="list-group-item">Second item</a>
                    <a href="#" class="list-group-item">Third item</a>
                </div>
                <h5>Quick Links</h5>
                <div class="list-group">
                    <a href="#" class="list-group-item">My Approved Listings</a>
                    <a href="#" class="list-group-item">My Pending Applications</a>
                    <a href="#" class="list-group-item">New Listing</a>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-0">
                @yield('lister_col_centre')
            </div>
            <div class="col-md-3 col-md-offset-0 pull-xs-right" style="border-left: 1px lightgrey">
                <div class="jumbotron" style="height: 100vh"><h6 style="text-align:center;">Ad zone</h6></div>
                @yield('lister_col_right')
            </div>
        </div>
    </div>
@endsection