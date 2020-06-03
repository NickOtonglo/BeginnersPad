@extends('layouts.base_no_panel')

@section('content')
    <br>
    @yield('top_buttons')
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-md-offset-0">
                <h5>Listing Categories</h5>
                <div class="list-group">
                    <a href="#" class="list-group-item">Pending</a>
                    <a href="#" class="list-group-item">Approved</a>
                    <a href="#" class="list-group-item">Rejected</a>
                    <a href="#" class="list-group-item">Suspended</a>
                    <a href="#" class="list-group-item">My Management History</a>
                </div>
                <h5>Filter by Zone</h5>
                <div class="list-group">
                    <select class="form-control" id="nav_zone_id" name="nav_zone_id">
                        <option value="" selected>Select Zone</option>   
                    </select>
                </div>
                <h5>Filter by Sub-Zone</h5>
                <div class="list-group">
                    <select class="form-control" id="nav_zone_entry_id" name="nav_zone_entry_id">
                        <option value="" selected>Select Sub-Zone</option>   
                    </select>
                </div>
                <h5>Filter by Property Lister</h5>
                <div class="list-group">
                    <select class="form-control" id="nav_lister_id" name="nav_lister_id">
                        <option value="" selected>Select Property Lister</option>   
                    </select>
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
                <small>Listing Stats</small>
                <div style="border:1px solid lightgrey; padding:16px">
                    
                </div>
                @yield('lister_col_right')
            </div>
        </div>
    </div>
@endsection