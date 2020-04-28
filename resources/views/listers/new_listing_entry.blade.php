@extends('layouts.base_new_listing')

@section('title')
<title>New Listing | Beginners Pad</title>
@endsection

@section('listing-form')
<div class="container">
  <div class="flex-title">Create new listing</div>
  <div class="flex-desc">Fill in the required details in the fields below:</div>
  <form method="post" action="{{route('lister.addListingEntry')}}" enctype="multipart/form-data" onsubmit="return validateEntryCreateForm();">
    {{csrf_field() }}
    <div class="form-group">
      <label for="listing_name">Name of listing *</label>
      <div class="alert alert-danger" id="alert_name_entry_create" hidden></div>
      <input class="form-control" name="listing_name" type="text" id="listing_name">
    </div>
    <div class="form-group">
      <label for="description">Description</label>
      <div class="alert alert-danger" id="alert_desc_entry_create" hidden></div>
      <textarea class="form-control" name="description" type="text" id="description"></textarea>
    </div>
    <div class="form-group">
      <label for="floor_area">Floor area of listing in square-metres *</label>
      <div class="alert alert-danger" id="alert_floor_area_entry_create" hidden></div>
      <input class="form-control" name="floor_area" type="number" id="floor_area">
    </div>
    <div class="form-group">
      <label for="disclaimer">Disclaimer(s) (separate with commas)</label>
      <div class="alert alert-danger" id="alert_disclaimer_entry_create" hidden></div>
      <textarea class="form-control" name="disclaimer" type="text" id="disclaimer"></textarea>
    </div>
    <div class="form-group">
      <label for="features">Feature(s) (separate with commas)</label>
      <div class="alert alert-danger" id="alert_features_entry_create" hidden></div>
      <textarea class="form-control" name="features" type="text" id="features"></textarea>
    </div>
    <div class="form-group" id="form-price" hidden>
      <label for="initial_deposit">Initial deposit amount (if applicable)</label>
      <div class="alert alert-danger" id="alert_initial_deposit_entry_create" hidden></div>
      <input class="form-control" name="initial_deposit" type="number" step=".01" id="initial_deposit">
    </div>
    <div class="form-group">
      <label for="initial_deposit_period">Initial deposit period in months (if applicable)</label>
      <div class="alert alert-danger" id="alert_deposit_period_entry_create" hidden></div>
      <input class="form-control" name="initial_deposit_period" type="number" id="initial_deposit_period">
    </div>
    <div class="form-group" id="form-price" hidden>
      <label for="price">Initial deposit amount (if applicable)</label>
      <div class="alert alert-danger" id="alert_price_entry_create" hidden></div>
      <input class="form-control" name="price" type="number" step=".01" id="price">
    </div>
    <div class="form-group">
      <input class="btn btn-primary" id="btnSubmit" type="submit" value="Create Property">
    </div>
  </form>
</div>
@endsection

@section('bottom_scripts')
  <script src="{{asset('js/listing-entries.js')}}"></script>
@endsection