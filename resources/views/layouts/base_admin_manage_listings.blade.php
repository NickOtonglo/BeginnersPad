@extends('layouts.base_no_panel')

@section('content')
    <br>
    @yield('top_buttons')
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-md-offset-0">
                <h5>Property Categories</h5>
                <div class="list-group">
                    <a href="{{route('admin.allListings')}}" class="list-group-item">All</a>
                    @if(count($allListings->where('status','pending'))==0)
                    <a href="#" class="list-group-item">Pending</a>
                    @else
                    <a href="{{route('admin.manageListings',['status'=>'pending'])}}" class="list-group-item">Pending</a>
                    @endif
                    @if(count($allListings->where('status','approved'))==0)
                    <a href="#" class="list-group-item">Approved</a>
                    @else
                    <a href="{{route('admin.manageListings',['status'=>'approved'])}}" class="list-group-item">Approved</a>
                    @endif
                    @if(count($allListings->get()->where('status','rejected'))==0)
                    <a href="#" class="list-group-item">Rejected</a>
                    @else
                    <a href="{{route('admin.manageListings',['status'=>'rejected'])}}" class="list-group-item">Rejected</a>
                    @endif
                    @if(count($allListings->get()->where('status','suspended'))==0)
                    <a href="#" class="list-group-item">Suspended</a>
                    @else
                    <a href="{{route('admin.manageListings',['status'=>'suspended'])}}" class="list-group-item">Suspended</a>
                    @endif
                    <a href="#" class="list-group-item">My Management History</a>
                </div>
                <h5>Filter by Zone</h5>
                <div class="list-group">
                    <select class="form-control" id="nav_zone_id" name="nav_zone_id">
                        <option value="" selected>Select Zone</option>
                        @forelse($allListings->get() as $listing)
                        <option value="{{$listing->zone_entry_id}}">{{$listing->zone_entry_id}}</option>
                        @empty
                        <option value="">-no zones available-</option>
                        @endforelse
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
                    Number of properties: <strong>{{$listings->where('status','!=','unpublished')->where('status','!=','deleted')->count()}}</strong>
                    <br>Pending:  <strong>{{$listings->where('status','pending')->count()}}</strong>
                    <br>Approved: <strong>{{$listings->where('status','approved')->count()}}</strong>
                    <br>Rejected: <strong>{{$listings->where('status','rejected')->count()}}</strong>
                    <br>Suspended: <strong>{{$listings->where('status','suspended')->count()}}</strong>
                </div>
                @yield('lister_col_right')
            </div>
        </div>
    </div>
@endsection