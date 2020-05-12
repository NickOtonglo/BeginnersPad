@extends('layouts.base_no_panel')

@section('title')
<title>Manage Listing - {{$entry->listing_name}} | Beginners Pad</title>
@endsection

@section ('content')
<div class="container">
    @if(session()->has('message'))
    <div class="row">
        <div class="alert alert-success alert-dismissible">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{ session()->get('message') }}
        </div>
    </div>
    @endif
    <div class="row">
        <div class="pull-right">
            <a class="btn btn-sm btn-info" role="button" data-toggle="modal" data-target="#modalUpdateEntry" onclick="populateEntryUpdateForm('{{$entry}}',this);">Edit Listing Entry</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="row">
            <div class="modal fade" id="modalUpdateEntry" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="modalLabel">Edit Listing</h4>
                        </div>
                        <form method="post" action="{{route('lister.updateListingEntry',['listingId'=>$entry->listing->id,'entryId'=>$entry->id])}}" enctype="multipart/form-data" onsubmit="return validateEntryCreateForm();">
                            <div class="modal-body">
                                {{csrf_field() }}
                                {{method_field('PUT')}}
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
                                    <label for="disclaimer">Disclaimer(s) (separate with semicolon ';')</label>
                                    <div class="alert alert-danger" id="alert_disclaimer_entry_create" hidden></div>
                                    <textarea class="form-control" name="disclaimer" type="text" id="disclaimer" placeholder="e.g. disclaimer 1;disclaimer 2;disclaimer 3...etc"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="features">Feature(s) (separate with semicolon ';')</label>
                                    <div class="alert alert-danger" id="alert_features_entry_create" hidden></div>
                                    <textarea class="form-control" name="features" type="text" id="features" placeholder="e.g. feature 1;feature 2;feature 3...etc"></textarea>
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
                                    @if($entry->listing->price == null)
                                    <input class="form-control" name="entry_price" type="number" step=".01" min="0.1" id="entry_price">
                                    @else
                                    <input class="form-control" name="entry_price" type="number" step=".01" min="0.1" id="entry_price" placeholder="{{$entry->listing->price}} (set at property level)" disabled>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <input class="btn btn-primary" id="btnSubmit" name="btn_submit" type="submit" value="Update Listing">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <small>Listing Details</small>
            <div style="border:1px solid lightgrey; padding:16px">
                <h3>{{$entry->listing_name}}</h3>
                <hr>
                <img class="img-rounded" style="width:255px;height:200px;display:block;margin-left:auto;margin-right:auto;" src="/images/listings/{{$entry->listing->id}}/thumbnails/{{$entry->listingFile()->where('category','thumbnail')->first()->file_name}}" alt="unable to display image">
                <hr>
                <div class="card-text">
                    <p>Status:
                        @if($entry->status=='active')
                        <span><strong class="text-success">active</strong></span><br>
                        @elseif($entry->status=='inactive')
                        <span><strong class="text-danger">inactive</strong></span><br>
                        @elseif($entry->status=='occupied')
                        <span><strong class="text-primary">occupied</strong></span><br>
                        @endif
                    </p>
                    <p>Floor area:
                        <strong>{{$entry->floor_area}} square metres</strong>
                    </p>
                    <p>
                        Initial deposit:
                        @if($entry->initial_deposit <= 0) <strong>not set</strong>
                            @else
                            <strong>KES {{$entry->initial_deposit}} valid for {{$entry->initial_deposit_period}} months</strong>
                            @endif
                    </p>
                    <p>
                        Rent price:
                        @if($entry->price != null || $entry->price != 0)
                        <strong>KES {{$entry->price}}</strong>
                        @else
                        <strong>KES {{$entry->listing->price}} (set at property level)</strong>
                        @endif
                    </p>
                </div>
            </div>
            <br>
            <!-- <input class="btn btn-lg btn-primary btn-block" style="margin-top:5px" type="submit" value="Edit" name="btn_edit" data-toggle="modal" data-target="#modalUpdateEntry" onclick="populateEntryUpdateForm('{{$entry}}',this);"> -->
            <form method="post" action="{{route('lister.updateListingEntry',['listingId'=>$entry->listing->id,'entryId'=>$entry->id])}}" enctype="multipart/form-data">
                {{csrf_field() }}
                {{method_field('PUT')}}
                @if($entry->status == 'active')
                <input class="btn btn-lg btn-danger btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Make Inactive (hide)" name="btn_submit">
                @elseif($entry->status == 'inactive')
                <input class="btn btn-lg btn-success btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Activate" name="btn_submit">
                @elseif($entry->status == 'occupied')
                <input class="btn btn-lg btn-danger btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Declare Vacant" name="btn_submit">
                @endif
            </form>
            <input class="btn btn-lg btn-danger btn-block btn-entry-delete" style="margin-top:5px" type="submit" value="Delete Listing" name="btn_submit" disabled>
        </div>
        <br>
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">More Information</div>
                <div class="panel-body">
                    @if($entry->description != null)
                    <div class="row" style="padding:8px">

                        <body>{{$entry->description}}</body>
                    </div>
                    <br>
                    @endif
                    @if($entry->disclaimer != null)
                    <div class="row" style="padding:8px">
                        <strong><u>Disclaimer (important)</u></strong>
                        <ul id="disclaimer_list">

                        </ul>
                    </div>
                    @endif
                    @if($entry->features != null)
                    <div class="row" style="padding:8px">
                        <strong>Features</strong>
                        <ul id="features_list">

                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <strong>Images</strong>
        <br>
        @forelse($entry->ListingFile->where('category','regular') as $image)
        <div class="cards">
            <div class="card" style="width:150px;height:178px;">
            <form method="post" action="{{route('lister.deleteListingEntry',['listingId'=>$entry->listing->id,'entryId'=>$entry->id,'imageId'=>$image->id])}}" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('DELETE')}}
                <a href="/images/listings/{{$entry->listing->id}}/{{$image->file_name}}" target="_blank">
                    <img style="width:150px;height:150px;" src="/images/listings/{{$entry->listing->id}}/{{$image->file_name}}" alt="unable to display image">
                </a>
                <input class="card-body btn btn-sm btn-danger btn-entry-delete" style="width:150px;border-radius:0px" type="submit" name="btn_submit" value="Remove">
            </form>
            </div>
        </div>
        @empty
        <h2 style="text-align:center;">No images to display</h2>
        @endforelse
        <div class="cards" id="images_upload">
            <div class="card" style="width:150px;height:178px;">
                {{csrf_field()}}
                <div hidden>
                    <input class="file-path-wrapper" accept="image/*" name="images[]" id="images_solo" type="file" multiple onchange="loadFileCustom(event)"/>
                </div>
                <img style="width:150px;height:150px;" id="images_virtual" src="/images/btn-add.png" alt="unable to display image">
                <div style="width:150px;text-align:center">
                    <small id="images_text">New image</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_scripts')
<script>
    let listingObj = {!!json_encode($entry->listing)!!};
    let entryObj = {!!json_encode($entry)!!};
    // let listingObj = {!!json_encode($entry->listing)!!};
</script>
<script src="{{asset('js/listings.js')}}"></script>
<script src="{{asset('js/listing-entries.js')}}"></script>
@endsection