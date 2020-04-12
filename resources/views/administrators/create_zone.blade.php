@extends('layouts.all_zones')

<!-- @section('title')
    @if(!$zone)
    <title>Add Zone | Beginners Pad</title>
    @else
    <title>Edit Zone | Beginners Pad</title>
    @endif
@endsection -->

@section ('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="row">
                @if(!$zone)
                <div class="flex-title" style="text-align:left;">Add New Zone</div>
                @else
                <div class="flex-title" style="text-align:left;">Edit Zone</div>
                @endif
                <div class="panel panel-info">
                    @if(!$zone)
                    <div class="panel-heading">Complete the form</div>
                    @else
                    <div class="panel-heading">Edit zone details</div>
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
                        @if(!$zone)
                        <form method="post" action="/manage-zone/new" enctype="multipart/form-data">
                        @else
                        <form method="post" action="/manage-zone/{{$zone->id}}/edit" enctype="multipart/form-data">
                        @endif
                            {{csrf_field() }}
                            @if($zone)
                            {{method_field('PUT')}}
                            @endif
                            <div class="form-group">
                                <label for="name">Name of zone *</label>
                                @if(!$zone)
                                <input class="form-control" name="name" type="text" id="name">
                                @else
                                <input class="form-control" name="name" type="text" value="{{$zone->name}}" id="name">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="country">Country *</label>
                                @if(!$zone)
                                <select class="form-control" id="country" name="country"><option value="" selected="selected">Select Country</option><option value="KE">Kenya</option></select>
                                @else
                                <select class="form-control" id="country" name="country"><option value="" selected="selected">Select Country</option><option value="KE">Kenya</option></select>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="county">County *</label>
                                @if(!$zone)
                                <input class="form-control" name="county" type="text" id="county">
                                @else
                                <input class="form-control" name="county" type="text" value="{{$zone->county}}" id="county">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="lat">Latitude</label>
                                @if(!$zone)
                                <input class="form-control" name="lat" type="text" id="lat">
                                @else
                                <input class="form-control" name="lat" type="text" value="{{$zone->lat}}" id="lat">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="lng">Longitude</label>
                                @if(!$zone)
                                <input class="form-control" name="lng" type="text" id="lng">
                                @else
                                <input class="form-control" name="lng" type="text" value="{{$zone->lng}}" id="lng">
                                @endif
                            </div>
                            <div class="form-group" style="height:100%; width:100%;">
                                <div id="map" style="clear:both; height:400px;"></div>
                            </div>
                            <div class="form-group">
                                <label for="radius">Radius (km)</label>
                                @if(!$zone)
                                <input class="form-control" name="radius" type="text" id="radius">
                                @else
                                <input class="form-control" name="radius" type="text" value="{{$zone->radius}}" id="radius">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="timezone">Timezone</label>
                                @if(!$zone)
                                <input class="form-control" name="timezone" type="text" id="timezone">
                                @else
                                <input class="form-control" name="timezone" type="text" value="{{$zone->timezone}}" id="timezone">
                                @endif
                            </div>
                            @if(!$zone)
                            <input class="btn btn-primary" value="Create Zone" type="submit" >
                            @else
                            <input class="btn btn-primary" value="Update Zone" type="submit">
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection