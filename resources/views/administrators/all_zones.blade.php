@extends('layouts.base_zones')

@section('title')
<title>Zones | Beginners Pad</title>
@endsection

@section ('content')
<div class="container-width">
    <div class="row">
        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{ session()->get('message') }}
        </div>
        @endif
        <div class="pull-right">
            <input class="btn btn-sm btn-info btn-block" style="margin-top:5px" type="submit" value="+ Add Zone" name="btn_new" data-toggle="modal" data-target="#modalCreateZone">
        </div>
    </div>
    <div class="row">
        <div class="modal fade" id="modalCreateZone" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalLabel">New Zone</h4>
                    </div>
                    <form method="post" action="/manage-zone/new" enctype="multipart/form-data" onsubmit="return validateZoneCreateForm();">
                        <div class="modal-body">
                            {{csrf_field() }}
                            <div class="form-group">
                                <label for="name">Name of zone *</label>
                                <div class="alert alert-danger" id="alert_name_zone_create" hidden></div>
                                <input class="form-control" name="name" type="text" id="name">
                            </div>
                            <div class="form-group">
                                <label for="country">Country *</label>
                                <div class="alert alert-danger" id="alert_country_zone_create" hidden></div>
                                <select class="form-control" id="country" name="country">
                                    <option value="" selected="selected">Select Country</option>
                                    <option value="KE">Kenya</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="county">County *</label>
                                <div class="alert alert-danger" id="alert_county_zone_create" hidden></div>
                                <input class="form-control" name="county" type="text" id="county">
                            </div>
                            <div class="form-group">
                                <label for="lat">Latitude</label>
                                <div class="alert alert-danger" id="alert_lat_zone_create" hidden></div>
                                <input class="form-control" name="lat" type="number" step="any" id="lat">
                            </div>
                            <div class="form-group">
                                <label for="lng">Longitude</label>
                                <div class="alert alert-danger" id="alert_lng_zone_create" hidden></div>
                                <input class="form-control" name="lng" type="number" step="any" id="lng">
                            </div>
                            <div class="form-group" style="height:100%; width:100%;">
                                <div id="map" style="clear:both; height:300px;"></div>
                            </div>
                            <div class="form-group">
                                <label for="radius">Radius (km)</label>
                                <div class="alert alert-danger" id="alert_radius_zone_create" hidden></div>
                                <input class="form-control" name="radius" type="number" step=".01" id="radius">
                            </div>
                            <div class="form-group">
                                <label for="timezone">Timezone</label>
                                <div class="alert alert-danger" id="alert_timezone_zone_create" hidden></div>
                                <input class="form-control" name="timezone" type="text" id="timezone">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input id="btnCreate" class="btn btn-primary" value="Create" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <h5>Popular Zones</h5>
            <div class="list-group">
                @forelse($p_zones as $p_zone)
                <a href="/manage-zone/{{$p_zone->id}}" class="list-group-item">{{$p_zone->name}}</a>
                @empty
                <p class="list-group-item">No zones available</p>
                @endforelse
            </div>
        </div>
        <div class="col-md-8 col-md-offset-1">
            <div class="row">
                <div class="flex-title" style="text-align:left;">Zones</div>
                @forelse($zones as $zone)
                <a class="card-big-clickable card-block" style="margin:9px; " role="button" href="/manage-zone/{{$zone->id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-capitalize">{{$zone->name}} <small>({{$zone->country}})</small></h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3" style="margin:2px">
                            <p><small>County: {{$zone->county}}</small></p>
                            <p>
                                @if($zone->state)
                                <small> State: {{$zone->state}}</small>
                                @else
                                <small>State: not set</small>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 col-md-offset-0" style="margin:2px">
                            <p>
                                @if($zone->lat || $zone->lng)
                                <small>Coordinates: {{number_format((float)$zone->lat, 3, '.', '')}},{{number_format((float)$zone->lng, 3, '.', '')}}</small>
                                @else
                                <small>Coordinates: not set</small>
                                @endif
                            </p>
                            <p>
                                @if($zone->radius)
                                <small>Radius: {{$zone->radius}}km</small>
                                @else
                                <small>Radius: not set</small>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 col-md-offset-0" style="margin:2px">
                            <p>
                                @if($zone->timezone)
                                <small>Timezone: {{$zone->timezone}}</small>
                                @else
                                <small>Timezone: not set</small>
                                @endif
                            </p>
                            <p>
                                <small>Created at: {{$zone->created_at}}</small>
                            </p>
                        </div>
                    </div>
                </a>
                @empty
                <h4 style="text-align:center;">No zones currently available</h4>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{$API_KEY}}&callback=initMap"async defer></script>
<script src="{{asset('js/map-script.js')}}"></script>
<script src="{{asset('js/zones.js')}}"></script>
@endsection