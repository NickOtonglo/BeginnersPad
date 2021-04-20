@extends('layouts.base_no_panel')

@section('title')
    <title>Manage Zone - {{$zone->name}} | Beginners Pad</title>
@endsection

@section ('content')
<div class="container">
    <div class="row" style="margin-bottom: 16px;">
        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!</strong> {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="col-md-3">
            <button class="btn btn-sm btn-outline-primary" role="button" data-bs-toggle="modal" data-bs-target="#modalCreateEntry"
             onclick="initMapEntryCreate()">+ Add Sub-Zone</button>
        </div>
        <div class="col-md-9 d-grid gap-2 d-md-flex justify-content-md-end">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="$('#btn_edit').trigger('click');">Edit This Zone</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="$('#btn_delete').trigger('click');" disabled>Delete Zone</button>
            </div>
        </div>
        <div class="modal fade" id="modalUpdateZone" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel">Edit Zone</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="/manage-zone/{{$zone->id}}/edit" enctype="multipart/form-data" onsubmit="return validateZoneUpdateForm();">
                        <div class="modal-body">
                            {{csrf_field() }}
                            {{method_field('PUT')}}
                            <div class="mb-3">
                                <label for="name">Name of zone *</label>
                                <div class="alert alert-danger" id="alert_name_zone_update" hidden></div>
                                <input class="form-control" name="name" type="text" id="zone_name_update">
                            </div>
                            <div class="mb-3">
                                <label for="country">Country *</label>
                                <div class="alert alert-danger" id="alert_country_zone_update" hidden></div>
                                <select class="form-select" id="zone_country_update" name="country">
                                    <option value="" selected="selected">Select Country</option>
                                    <option value="KE">Kenya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="county">County *</label>
                                <div class="alert alert-danger" id="alert_county_zone_update" hidden></div>
                                <input class="form-control" name="county" type="text" id="zone_county_update">
                            </div>
                            <div class="mb-3">
                                <label for="lat">Latitude</label>
                                <div class="alert alert-danger" id="alert_lat_zone_update" hidden></div>
                                <input class="form-control" name="lat" type="number" step="any" id="zone_lat_update">
                            </div>
                            <div class="mb-3">
                                <label for="lng">Longitude</label>
                                <div class="alert alert-danger" id="alert_lng_zone_update" hidden></div>
                                <input class="form-control" name="lng" type="number" step="any" id="zone_lng_update">
                            </div>
                            <div class="mb-3" style="height:100%; width:100%;">
                                <div id="zone_map_update" style="clear:both; height:300px;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="radius">Radius (km)</label>
                                <div class="alert alert-danger" id="alert_radius_zone_update" hidden></div>
                                <input class="form-control" name="radius" type="number" step=".01" id="zone_radius_update">
                            </div>
                            <div class="mb-3">
                                <label for="timezone">Timezone</label>
                                <div class="alert alert-danger" id="alert_timezone_zone_update" hidden></div>
                                <input class="form-control" name="timezone" type="text" id="zone_timezone_update">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <input id="btn_update_zone" class="btn btn-outline-primary" value="Update" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalCreateEntry" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel">New Sub-Zone</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="/manage-zone/{{$zone->id}}/add" enctype="multipart/form-data" onsubmit="return validateEntryCreateForm();">
                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="mb-3">
                                <label for="name">Name of sub-zone *</label>
                                <div class="alert alert-danger" id="alert_name_create" hidden></div>
                                <input class="form-control" name="name" type="text" id="entry_name_create">
                            </div>
                            <div class="mb-3">
                                <label for="country">Role/Nature of sub-zone *</label>
                                <div class="alert alert-danger" id="alert_role_create" hidden></div>
                                <select class="form-select" id="entry_role_create" name="role">
                                    <option value="" selected="selected">Select Role</option>
                                    <option value="residential">Residential</option>
                                    <option value="industrial">Industrial</option>
                                    <option value="commercial">Commercial</option>
                                    <option value="agricultural">Agricultural</option>
                                    <option value="multi">Multi-industry</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="lat">Latitude</label>
                                <div class="alert alert-danger" id="alert_lat_create" hidden></div>
                                <input class="form-control" name="lat" type="number" step="any" id="entry_lat_create">
                            </div>
                            <div class="mb-3">
                                <label for="lng">Longitude</label>
                                <div class="alert alert-danger" id="alert_lng_create" hidden></div>
                                <input class="form-control" name="lng" type="number" step="any" id="entry_lng_create">
                            </div>
                            <div class="mb-3" style="height:100%; width:100%;">
                                <div id="entry_map_create" style="clear:both; height:300px;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="radius">Radius (km)</label>
                                <div class="alert alert-danger" id="alert_radius_create" hidden></div>
                                <input class="form-control" name="radius" type="number" step=".01" id="entry_radius_create">
                            </div>
                            <div class="mb-3">
                                <label for="timezone">Timezone</label>
                                <div class="alert alert-danger" id="alert_timezone_create" hidden></div>
                                <input class="form-control" name="timezone" type="text" value="{{$zone->timezone}}" id="entry_timezone_create">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <input  id="btn_save" class="btn btn-outline-primary" value="Save" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalUpdateEntry" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel">Edit Sub-Zone</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" enctype="multipart/form-data" onsubmit="return validateEntryUpdateForm();" id="formEntryUpdate">
                        <div class="modal-body">
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <div class="mb-3">
                                <label for="name">Name of sub-zone *</label>
                                <div class="alert alert-danger" id="alert_name_update" hidden></div>
                                <input class="form-control" name="name" type="text" id="entry_name_update">
                            </div>
                            <div class="mb-3">
                                <label for="country">Role/Nature of sub-zone *</label>
                                <div class="alert alert-danger" id="alert_role_update" hidden></div>
                                <select class="form-select" id="entry_role_update" name="role">
                                    <option value="" selected="selected">Select Role</option>
                                    <option value="residential">Residential</option>
                                    <option value="industrial">Industrial</option>
                                    <option value="commercial">Commercial</option>
                                    <option value="agricultural">Agricultural</option>
                                    <option value="multi">Multi-industry</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="lat">Latitude</label>
                                <div class="alert alert-danger" id="alert_lat_update" hidden></div>
                                <input class="form-control" name="lat" type="number" step="any" id="entry_lat_update">
                            </div>
                            <div class="mb-3">
                                <label for="lng">Longitude</label>
                                <div class="alert alert-danger" id="alert_lng_update" hidden></div>
                                <input class="form-control" name="lng" type="number" step="any" id="entry_lng_update">
                            </div>
                            <div class="mb-3" style="height:100%; width:100%;">
                                <div id="entry_map_update" style="clear:both; height:300px;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="radius">Radius (km)</label>
                                <div class="alert alert-danger" id="alert_radius_update" hidden></div>
                                <input class="form-control" name="radius" type="number" step=".01" id="entry_radius_update">
                            </div>
                            <div class="mb-3">
                                <label for="timezone">Timezone</label>
                                <div class="alert alert-danger" id="alert_timezone_update" hidden></div>
                                <input class="form-control" name="timezone" type="text" id="entry_timezone_update">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <input id="btn_update" class="btn btn-outline-primary" value="Update" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <small>Zone Details</small>
            <div class="bp-mini-panel">
                <h3>{{$zone->name}}</h3>
                <hr>
                <p class="card-text">
                    Country: <strong>{{$zone->country}}</strong>
                </p>
                <p class="card-text">
                    County: <strong>{{$zone->county}}</strong>
                </p>
                <p class="card-text">
                    @if ($zone->state != null)
                    State: <strong>{{$zone->state}}</strong>
                    @endif
                </p>
                <p class="card-text">
                    @if ($zone->latitude != null && $zone->longitude != null)
                    Coordinates: <strong>{{$zone->latitude}},{{$zone->longitude}}</strong>
                    @endif
                </p>
                <p class="card-text">
                    @if ($zone->radius != null)
                    Zone radius: <strong>{{$zone->radius}}km</strong>
                    @endif 
                </p>
                <p class="card-text">
                    @if ($zone->timezone != null)
                    Timezone: <strong>{{$zone->timezone}}</strong>
                    @endif
                </p>
                <p class="card-text">
                    Created on: <strong>{{$zone->created_at}}</strong>
                </p>
            </div>
            <div hidden>
                <input class="btn btn-lg btn-outline-primary btn-block" style="margin-top:5px" type="button" value="Edit zone" name="btn_edit" id="btn_edit"
                 data-bs-toggle="modal" data-bs-target="#modalUpdateZone" onclick="populateZoneUpdateForm('{{$zone}}',this);initMapZoneUpdate();">
                <input class="btn btn-lg btn-outline-danger btn-block" style="margin-top:5px" type="submit" value="Delete zone" name="btn_delete" id="btn_delete" disabled>
            </div>
        </div>
        <div class="col-md-7 col-md-offset-1">
            <div class="row" style="margin-bottom: 16px;">
                <div class="flex-title" style="text-align:left;">Sub-Zones in {{$zone->name}}</div>
                @forelse($entries as $entry)
                <a class="card-big-clickable card-block" style="margin:9px;" role="button" onclick="populateEntryUpdateForm('{{$entry}}',this);initMapEntryUpdate();">
                    <form action="/manage-zone/{{$zone->id}}/{{$entry->id}}/edit" method="post" enctype="multipart/form-data" >
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input class="btn btn-sm btn-outline-danger btn-top-delete btn-delete" type="submit" value="x" name="btn_delete" data-toggle="tooltip" title="Delete" id="btnDelete">
                    </form>
                    <div class="row">
                        <div class="col-md-12"><h4 class="text-capitalize" style="padding-top: 25px;">{{$entry->name}}</h4></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4" style="margin:2px">
                            <p>
                                @if($entry->lat || $entry->lng)
                                    <small>Coordinates: {{number_format((float)$entry->lat, 3, '.', '')}},{{number_format((float)$entry->lng, 3, '.', '')}}</small>
                                @else
                                    <small>Coordinates: not set</small>
                                @endif
                            </p>
                            <p>
                                @if($entry->radius)
                                    <small>Radius: {{$entry->radius}}km</small>
                                @else
                                    <small>Radius: not set</small>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 col-md-offset-0" style="margin:2px">
                            <p>
                                @if($entry->timezone)
                                    <small>Timezone: {{$entry->timezone}}</small>
                                @else
                                    <small>Timezone: not set</small>
                                @endif
                            </p>
                            <p>
                                <small>Created on: {{$entry->created_at}}</small>
                            </p>
                        </div>
                        <div class="col-md-3 col-md-offset-0" style="margin:2px">
                            <p>
                                @if($entry->role)
                                    <small>Role: {{$entry->role}}</small>
                                @else
                                    <small>Role: not set</small>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                </a>
                @empty
                <h4 style="text-align:center;">No sub-zones currently available</h4>
                @endforelse
            </div>
        </div>
        
    </div>
</div>
@endsection

@section ('bottom_scripts')
<script>
    let zoneObj = {!! json_encode($zone)!!};
    let initLatZoneUpdate,initLngZoneUpdate,initLatEntryUpdate,initLngEntryUpdate;
</script>
<script src="{{asset('js/zone-entries.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{$API_KEY}}"></script>
<script src="{{asset('js/map-zone-entries.js')}}"></script>
@endsection