@extends('layouts.base_no_panel')

@section('title')
    @if(!$zone)
    <title>Add Entry to Zone | Beginners Pad</title>
    @else
    <title>Edit Sub-Zone | Beginners Pad</title>
    @endif
@endsection

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-3" style="border:1px solid lightgrey; padding:16px">
            <h4>Zone Details</h4>
            <hr>
            <h5 class="card-text">
                <small>
                    Name: <strong>{{$zone->name}}</strong>
                </small>
            </h5>
            <h5 class="card-text">
                <small>
                    Country: {{$zone->country}}
                </small>
            </h5>
            <h5 class="card-text">
                <small>
                    County: {{$zone->county}}
                </small>
            </h5>
            <hr>
            <h5 class="card-text">
                <small>
                    Total number of sub-zones: {{$zone_entry_count}}
                </small>
            </h5>
            <h5 class="card-text">
                <small>
                @if ($zone->state != null)
                    State: {{$zone->state}}
                @endif
                </small>
            </h5>
            <h5 class="card-text">
                <small>
                @if ($zone->latitude != null && $zone->longitude != null)
                    Coordinates: {{$zone->latitude}},{{$zone->longitude}}
                @endif
                </small>
            </h5>
            <h5 class="card-text">
                <small>
                @if ($zone->radius != null)
                    Zone radius: {{$zone->radius}}
                @endif
                </small>
            </h5>
            <h5 class="card-text">
                <small>
                    Created at: {{$zone->created_at}}
                </small>
            </h5>
        </div>
        <div class="col-md-8 col-md-offset-1">
            <div class="row">
                @if(!$zone_entry)
                <div class="flex-title" style="text-align:left;">Add New Sub-Zone in <u>{{$zone->name}}</u></div>
                @else
                <div class="flex-title" style="text-align:left;">Edit <u>{{$zone_entry->name}}</u> Sub-Zone</u></div>
                @endif
                <div class="panel panel-info">
                    @if(!$zone_entry)
                    <div class="panel-heading">Complete the form</div>
                    @else
                    <div class="panel-heading">Edit entry details</div>
                    @endif
                    <div class="panel-body">
                        @if(count($errors)>0)
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li class="alert alert-danger">{{$error}}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if(!$zone_entry)
                        <form method="post" action="/manage-zone/{{$zone->id}}/add" enctype="multipart/form-data">
                        @else
                        <form method="post" action="/manage-zone/{{$zone->id}}/{{$zone_entry->id}}/edit" enctype="multipart/form-data">
                        @endif
                            {{csrf_field()}}
                            @if($zone_entry)
                            {{method_field('PUT')}}
                            @endif
                            <div class="form-group">
                                <label for="name">Name of sub-zone *</label>
                                @if(!$zone_entry)
                                <input class="form-control" name="name" type="text" id="name">
                                @else
                                <input class="form-control" name="name" type="text" value="{{$zone_entry->name}}" id="name">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="country">Role/Nature of sub-zone *</label>
                                @if(!$zone_entry)
                                <select class="form-control" id="role" name="role">
                                    <option value="" selected="selected">Select Role</option>
                                    <option value="residential">Residential</option>
                                    <option value="industrial">Industrial</option>
                                    <option value="commercial">Commercial</option>
                                    <option value="agricultural">Agricultural</option>
                                    <option value="multi">Multi-industry</option>
                                    <option value="other">Other</option>
                                </select>
                                @else
                                <select class="form-control" id="role" name="role">
                                    <option value="" selected="selected">Select Role</option>
                                    <option value="residential">Residential</option>
                                    <option value="industrial">Industrial</option>
                                    <option value="commercial">Commercial</option>
                                    <option value="agricultural">Agricultural</option>
                                    <option value="multi">Multi-industry</option>
                                    <option value="other">Other</option>
                                </select>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="lat">Latitude</label>
                                @if(!$zone_entry)
                                <input class="form-control" name="lat" type="text" id="lat">
                                @else
                                <input class="form-control" name="lat" type="text" value="{{$zone_entry->lat}}" id="lat">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="lng">Longitude</label>
                                @if(!$zone_entry)
                                <input class="form-control" name="lng" type="text" id="lng">
                                @else
                                <input class="form-control" name="lng" type="text" value="{{$zone_entry->lng}}" id="lng">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="radius">Radius (km)</label>
                                @if(!$zone_entry)
                                <input class="form-control" name="radius" type="text" id="radius">
                                @else
                                <input class="form-control" name="radius" type="text" value="{{$zone_entry->radius}}" id="radius">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="timezone">Timezone</label>
                                @if(!$zone_entry)
                                <input class="form-control" name="timezone" type="text" value="{{$zone->timezone}}" id="timezone">
                                @else
                                <input class="form-control" name="timezone" type="text" value="{{$zone_entry->timezone}}" id="timezone">
                                @endif
                            </div>
                            @if(!$zone_entry)
                            <input class="btn btn-primary" value="Save Sub-Zone" type="submit" >
                            @else
                            <input class="btn btn-primary" value="Update Sub-Zone" type="submit">
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection