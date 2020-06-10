@extends('layouts.base_lister_info')

@section('title')
    <title>Manage Properties | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="container">
    <div class="row">
        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{ session()->get('message') }}
        </div>
        @endif
        <div class="pull-right">
            <a class="btn btn-mid btn-info" data-toggle="modal" data-target="#modalCreateListing" role="button">+ Add New Property</a>
        </div>
    </div>
    <div class="row">
        <div class="modal fade" id="modalCreateListing" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalLabel">New Listing Property</h4>
                    </div>
                    <form method="post" action="/manage-listings/new" enctype="multipart/form-data" onsubmit="return validateListingCreateForm();">
                        <div class="modal-body">
                            {{csrf_field() }}
                            <div class="form-group">
                                <label for="property_name">Name of property *</label>
                                <div class="alert alert-danger" id="alert_name_listing_create" hidden></div>
                                <input class="form-control" name="property_name" type="text" id="property_name">
                            </div>
                            <div class="form-group">
                                <label for="description">Description *</label>
                                <div class="alert alert-danger" id="alert_desc_listing_create" hidden></div>
                                <textarea class="form-control" name="description" type="text" id="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="zone_entry_id">Sub-Zone *</label>
                                <div class="alert alert-danger" id="alert_subzone_listing_create" hidden></div>
                                <select class="form-control" id="zone_entry_id" name="zone_entry_id">
                                    <option value="" selected>Select sub-zone</option>
                                    @forelse($subZonesList as $subZoneItem)
                                    <option value="{{$subZoneItem->id}}">{{$subZoneItem->name}} ({{$subZoneItem->zone->name}}, {{$subZoneItem->zone->county}})</option>
                                    @empty
                                    <option value="" selected>(no sub-zones available)</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lat">Latitude *</label>
                                <div class="alert alert-danger" id="alert_lat_listing_create" hidden></div>
                                <input class="form-control" name="lat" type="number" step="any" id="lat">
                            </div>
                            <div class="form-group">
                                <label for="lng">Longitude *</label>
                                <div class="alert alert-danger" id="alert_lng_listing_create" hidden></div>
                                <input class="form-control" name="lng" type="number" step="any" id="lng">
                            </div>
                            <div class="form-group" style="height:100%; width:100%;">
                                <div id="map" style="clear:both; height:300px;"></div>
                            </div>
                            <div class="form-group">
                                <label for="listing_type">Number of listings to be listed under this property *</label>
                                <div class="alert alert-danger" id="alert_type_listing_create" hidden></div>
                                <select class="form-control" id="listing_type" name="listing_type">
                                    <option value="" selected>Select property type</option>
                                    <option value="single">Just one (single-listing property)</option>
                                    <option value="multi">More than one one (multiple-listing property)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="stories">Number of stories/floors in property building *</label>
                                <div class="alert alert-danger" id="alert_stories_listing_create" hidden></div>
                                <input class="form-control" name="stories" type="number" id="stories">
                            </div>
                            <div class="form-group">
                                <input type="checkbox" value="checkbox" id="checkbox"> <strong id="checkbox-tag" data-toggle="tooltip" title="Loading...">Price all listings under this property equally (what's this?)</strong>
                            </div>
                            <div class="form-group" id="form-price" hidden>
                                <label for="price">Price of rent/month for all listings under this property *</label>
                                <div class="alert alert-danger" id="alert_price_listing_create" hidden></div>
                                <input class="form-control" name="price" type="number" step=".01" id="price">
                            </div>
                            <div class="form-group">
                                <label for="thumbnail">Upload thumbnail</label>
                                <input class="file-path-wrapper" accept="image/*" name="thumbnail" id="thumbnail" type="file" onchange="loadFile(event)" required>
                                <img id="output" width="250px" style="margin: 15px" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input class="btn btn-primary" id="btnSubmit" type="submit" value="Create Property">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
@endsection

@section('lister_col_centre')
<div class="panel panel-default">
    <div class="panel-heading">My Properties</div>
    <div class="panel-body">
        <div class="post">
            <div class="row">
                @forelse($listings as $listing)
                    <a class="card-big-clickable card-block" style="margin:9px; " role="button" href="/manage-listings/{{$listing->id}}/manage">
                        <div class="col-md-8 col-md-offset-0">
                            <span style="display: inline-block;width: 210px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"><h4>{{$listing->property_name}}</h4></span><br>
                            @if($listing->status=='unpublished')
                            <span><small><strong class="text-default">not submitted for publishing</strong></small></span><br>
                            @elseif($listing->status=='pending')
                            <span><small><strong class="text-info">pending approval</strong></small></span><br>
                            @elseif($listing->status=='approved')
                            <span><small><strong class="text-success">approved</strong></small></span><br>
                            @elseif($listing->status=='rejected')
                            <span><small><strong class="text-danger">rejected (open for details)</strong></small></span><br>
                            @elseif($listing->status=='suspended')
                            <span><small><strong class="text-danger">suspended (open for details)</strong></small></span><br>
                            @else
                            <span><small><strong>invalid status</strong></small></span><br>
                            @endif
                            <span><small>Location: <i>{{$listing->zoneEntry->name}} ({{$listing->zoneEntry->zone->county}})</i></small></span><br>
                            @if($listing->listing_type=='single')
                            <span><small>Type: <i>Single-listing property</i></small></span>
                            @elseif($listing->listing_type=='multi')
                            <span><small>Type: <i>Multiple-listing property</i></small></span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            @if($listing->thumbnail != null)
                            <img class="img-rounded" style="width:125px;height:100px;float:right;" src="/images/listings/{{$listing->id}}/thumbnails/{{$listing->thumbnail}}" alt="unable to display image">
                            @elseif($listing->thumbnail == null)
                            <img class="img-rounded" style="width:125px;height:100px;float:right;" src="/images/listings/vector-house-icon.jpg" alt="unable to display image">
                            @endif
                        </div>
                    </a>
                @empty
                    <h4 style="text-align:center;">You have no active listings</h4>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_scripts')
  <script src="{{asset('js/listings.js')}}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key={{$API_KEY}}&callback=initMap"async defer></script>
  <script src="{{asset('js/map-script.js')}}"></script>
@endsection