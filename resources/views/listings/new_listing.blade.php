@extends('layouts.base_new_listing')

@section('title')
<title>New Listing | Beginners Pad</title>
@endsection

@section('listing-form')
<div class="container">
  <div class="flex-title">Create new listing</div>
  <div class="flex-desc">Fill in the required details in the fields below:</div>
  <form method="post" action="/manage-listings/new" enctype="multipart/form-data" onsubmit="return validateListingCreateForm();">
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
      <img id="output" width="250px" style="margin: 15px"/>
    </div>
    <div class="form-group">
      <input class="btn btn-primary" id="btnSubmit" type="submit" value="Create Property">
    </div>
  </form>
</div>
@endsection

@section('bottom_scripts')
  <script src="{{asset('js/listings.js')}}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key={{$API_KEY}}&callback=initMap"async defer></script>
  <script src="{{asset('js/map-script.js')}}"></script>
@endsection