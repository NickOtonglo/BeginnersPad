@extends('layouts.base_new_listing')

@section('title')
<title>New Listing | Beginners Pad</title>
@endsection

@section('listing-form')
<div class="container">
    <div class="flex-title">Create new listing</div>
    <div class="flex-desc">Fill in the required details in the fields below:</div>
    <form method="post" action="{{route('lister.createListingEntry',['id' => $listing->id])}}" enctype="multipart/form-data" onsubmit="return validateEntryCreateForm();">
        {{csrf_field() }}
        <div class="form-group">
            <label for="listing_name">Name of listing *</label>
            <div class="alert alert-danger" id="alert_name_entry_create" hidden></div>
            <input class="form-control" name="listing_name" type="text" id="listing_name">
        </div>
        <div class="form-group">
            <label for="entry_description">Description</label>
            <div class="alert alert-danger" id="alert_desc_entry_create" hidden></div>
            <br><input type="checkbox" value="checkbox_description" id="checkbox_description"> <strong>Copy from property description</strong>
            <textarea class="form-control" name="entry_description" type="text" id="entry_description"></textarea>
        </div>
        <div class="form-group">
            <label for="floor_area">Floor area of listing in square-metres *</label>
            <div class="alert alert-danger" id="alert_floor_area_entry_create" hidden></div>
            <input class="form-control" name="floor_area" type="number" id="floor_area" min="1">
        </div>
        <div class="form-group">
            <label for="disclaimer">Disclaimer(s) (separate with commas)</label>
            <div class="alert alert-danger" id="alert_disclaimer_entry_create" hidden></div>
            <textarea class="form-control" name="disclaimer" type="text" id="disclaimer" placeholder="e.g. disclaimer 1,disclaimer 2,disclaimer 3...etc"></textarea>
        </div>
        <div class="form-group">
            <label for="features">Feature(s) (separate with commas)</label>
            <div class="alert alert-danger" id="alert_features_entry_create" hidden></div>
            <textarea class="form-control" name="features" type="text" id="features" placeholder="e.g. feature 1,feature 2,feature 3...etc"></textarea>
        </div>
        <div class="form-group">
            <input type="checkbox" value="checkbox_deposit" id="checkbox_deposit"> <strong>Set initial deposit</strong>
        </div>
        <div id="form_deposit" hidden>
            <div class="form-group">
                <label for="initial_deposit">Initial deposit amount</label>
                <div class="alert alert-danger" id="alert_initial_deposit_entry_create" hidden></div>
                <input class="form-control" name="initial_deposit" type="number" step=".01" min="0.1" id="initial_deposit">
            </div>
            <div class="form-group">
                <label for="initial_deposit_period">Initial deposit period in months</label>
                <div class="alert alert-danger" id="alert_deposit_period_entry_create" hidden></div>
                <input class="form-control" name="initial_deposit_period" type="number" min="1" id="initial_deposit_period" placeholder="at least 1 month">
            </div>
        </div>
        <div class="form-group">
            <label for="entry_price">Price of rent/month for this listing (KES) *</label>
            <div class="alert alert-danger" id="alert_price_entry_create" hidden></div>
            @if($listing->price == null)
            <input class="form-control" name="entry_price" type="number" step=".01" min="0.1" id="entry_price">
            @else
            <input class="form-control" name="entry_price" type="number" step=".01" min="0.1" id="entry_price" value="{{$listing->price}} (set at property level)" disabled>
            @endif
        </div>
        <div class="form-group">
            <label for="images">Upload image(s)</label>
            <input class="file-path-wrapper" accept="image/*" name="images[]" id="images" type="file" required multiple/>
        </div>
        <div class="form-group">
            <input class="btn btn-primary" id="btnSubmit" type="submit" value="Add Listing">
        </div>
    </form>
</div>
@endsection

@section('bottom_scripts')
<script>
    let listingObj = {!!json_encode($listing)!!};
</script>
<script src="{{asset('js/listing-entries.js')}}"></script>
@endsection