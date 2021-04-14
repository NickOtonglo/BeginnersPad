@extends('layouts.base_no_panel')

@section('content')
    @yield('top_buttons')
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-md-offset-0">
                <h5>Property Categories</h5>
                <div class="list-group" style="margin-bottom: 18px;">
                    <a href="{{route('admin.allListings')}}" class="list-group-item list-group-item-action">All</a>
                    @if(count((array)$allListings->where('status','pending'))==0)
                    <a href="#" class="list-group-item">Pending</a>
                    @else
                    <a href="{{route('admin.manageListings',['status'=>'pending'])}}" class="list-group-item list-group-item-action">Pending</a>
                    @endif
                    @if(count((array)$allListings->where('status','approved'))==0)
                    <a href="#" class="list-group-item">Approved</a>
                    @else
                    <a href="{{route('admin.manageListings',['status'=>'approved'])}}" class="list-group-item list-group-item-action">Approved</a>
                    @endif
                    @if(count((array)$allListings->get()->where('status','rejected'))==0)
                    <a href="#" class="list-group-item">Rejected</a>
                    @else
                    <a href="{{route('admin.manageListings',['status'=>'rejected'])}}" class="list-group-item list-group-item-action">Rejected</a>
                    @endif
                    @if(count((array)$allListings->get()->where('status','suspended'))==0)
                    <a href="#" class="list-group-item">Suspended</a>
                    @else
                    <a href="{{route('admin.manageListings',['status'=>'suspended'])}}" class="list-group-item list-group-item-action">Suspended</a>
                    @endif
                </div>
                <h5>Filter by Zone</h5>
                <div class="list-group" style="margin-bottom: 18px;">
                    <select class="form-select" id="nav_zone_id" name="nav_zone_id">
                        <option value="" selected>--select zone--</option>
                        @forelse($zones as $zone)
                            @isset($value)
                                @if($zone->id == $value && $category == 'zone')
                                <option value="{{$zone->id}}" selected>({{$zone->country}}) {{$zone->county}} - {{$zone->name}}</option>
                                @else
                                <option value="{{$zone->id}}">({{$zone->country}}) {{$zone->county}} - {{$zone->name}}</option>
                                @endif
                            @else
                            <option value="{{$zone->id}}">({{$zone->country}}) {{$zone->county}} - {{$zone->name}}</option>
                            @endif
                        @empty
                        <option value="">-no zones available-</option>
                        @endforelse
                    </select>
                </div>
                <h5>Filter by Sub-Zone</h5>
                <div class="list-group" style="margin-bottom: 18px;">
                    <select class="form-select" id="nav_zone_entry_id" name="nav_zone_entry_id">
                        <option value="" selected>--select sub-zone--</option>
                        @forelse($subZones as $subZone)
                            @isset($value)
                                @if($subZone->id == $value && $category == 'subzone')
                                <option value="{{$subZone->id}}" selected>({{$subZone->zone->country}}) {{$subZone->name}} [{{$subZone->zone->county}}, {{$subZone->zone->name}}]</option>
                                @else
                                <option value="{{$subZone->id}}">({{$subZone->zone->country}}) {{$subZone->name}} [{{$subZone->zone->county}}, {{$subZone->zone->name}}]</option>
                                @endif
                            @else
                            <option value="{{$subZone->id}}">({{$subZone->zone->country}}) {{$subZone->name}} [{{$subZone->zone->county}}, {{$subZone->zone->name}}]</option>
                            @endif
                        @empty
                        <option value="">-no sub-zones available-</option>
                        @endforelse
                    </select>
                </div>
                <h5>Filter by Property Lister</h5>
                <div class="list-group" style="margin-bottom: 18px;">
                    <select class="form-select" id="nav_lister_id" name="nav_lister_id">
                        <option value="" selected>--select property lister--</option>
                        @forelse($listers_list as $lister)
                            @isset($value)
                                @if($lister->id == $value && $category == 'lister')
                                <option value="{{$lister->id}}" selected>{{$lister->name}} ({{$listings_stats->where('lister_id',$lister->id)->where('status','approved')->count()}} approved listings)</option>
                                @else
                                <option value="{{$lister->id}}">{{$lister->name}} ({{$listings_stats->where('lister_id',$lister->id)->where('status','approved')->count()}} approved listings)</option>
                                @endif
                            @else
                            <option value="{{$lister->id}}">{{$lister->name}} ({{$listings_stats->where('lister_id',$lister->id)->where('status','approved')->count()}} approved listings)</option>
                            @endif
                        @empty
                        <option value="">-no listers available-</option>
                        @endforelse
                    </select>
                </div>
                <h5>Quick Links</h5>
                <div class="list-group">
                    <a href="{{route('admin.viewListingManagementLogs',['target'=>''])}}" class="list-group-item">My Management History</a>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-0">
                @yield('lister_col_centre')
            </div>
            <div class="col-md-3 col-md-offset-0">
                <small>Listing Stats</small>
                <div style="border:1px solid lightgrey; padding:16px">
                    Number of properties: <strong>{{$listings_stats->count()}}</strong>
                    <br>Pending:  <strong>{{$listings_stats->where('status','pending')->count()}}</strong>
                    <br>Approved: <strong>{{$listings_stats->where('status','approved')->count()}}</strong>
                    <br>Rejected: <strong>{{$listings_stats->where('status','rejected')->count()}}</strong>
                    <br>Suspended: <strong>{{$listings_stats->where('status','suspended')->count()}}</strong>
                </div>
                @yield('lister_col_right')
            </div>
        </div>
    </div>
@endsection

@section('bottom_scripts')
<script src="{{asset('js/base-listings-applications-management-admin.js')}}"></script>
@endsection