@extends('layouts.base_no_panel')

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
        @yield('top_buttons')
	</div>
	<br>
    <div class="row">
        <div class="col-md-6">
            <small>Listing Details</small>
            <div style="border:1px solid lightgrey; padding:16px">
                <h3>{{$entry->listing_name}}</h3>
                <hr>
                <div class="row">
                    <img class="img-rounded" id="img_thumb" style="width:255px;height:200px;display:block;margin-left:auto;margin-right:auto;" src="/images/listings/{{$entry->listing->id}}/thumbnails/{{$entry->listingFile()->where('category','thumbnail')->first()->file_name}}" alt="unable to display image">
                </div>
                <br>
                @if(Auth::user()->user_type === 4)
                <form id="thumb_form" method="post" action="{{route('lister.storeListingEntryThumb',['listingId'=>$entry->listing->id,'entryId'=>$entry->id])}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div hidden>
                        <input class="file-path-wrapper" accept="image/*" name="thumb" id="btn_thumb_real" type="file" onchange="loadFileThumb(event)" />
                    </div>
                </form>
                <input class="btn btn-sm btn-primary btn-block" style="border-radius:25px;" type="submit" name="btn_submit" id="btn_thumb_faux" value="Change Thumbnail">
                <hr>
                @endif
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
            @yield('lister_controls')
        </div>
        <div class="col-md-5 col-md-offset-1">
            <br>
            <div class="card">
                <div class="card-header">More Information</div>
                <div class="card-body">
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
                    @if($entry->description == null && $entry->disclaimer == null && $entry->features == null)
                    <strong>Not available</strong>
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
        <div class="" style="width:150px;height:150px;">
            @if(Auth::user()->user_type === 4)
            <div class="card-img-clickable" style="width:150px;height:178px;">
            @else
            <div class="card-img-clickable" style="width:150px;height:150px;">
            @endif
                <a href="/images/listings/{{$entry->listing->id}}/{{$image->file_name}}" target="_blank">
                    <img style="width:150px;height:150px;" src="/images/listings/{{$entry->listing->id}}/{{$image->file_name}}" alt="unable to display image">
                </a>
                @if(Auth::user()->user_type === 4)
                <form method="post" action="{{route('lister.deleteListingEntryImage',['listingId'=>$entry->listing->id,'entryId'=>$entry->id,'imageId'=>$image->id])}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <input class="card-body btn btn-sm btn-danger btn-entry-delete" style="width:150px;border-radius:0px" type="submit" name="btn_submit" value="Remove">
                </form>
                @endif
            </div>
        </div>
        @empty
        <h2 style="text-align:center;">No images to display</h2>
        @endforelse
        @if(Auth::user()->user_type === 4)
        <div class="cards" id="images_upload">
            <div class="card" style="width:150px;height:178px;">
                <form id="image_form" method="post" action="{{route('lister.storeListingEntryImage',['listingId'=>$entry->listing->id,'entryId'=>$entry->id])}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div hidden>
                        <input class="file-path-wrapper" accept="image/*" name="images[]" id="images_solo" type="file" multiple onchange="loadFileCustom(event)" />
                    </div>
                    <img style="width:150px;height:150px;" id="images_virtual" src="/images/btn-add.png" alt="unable to display image">
                    <!-- <div style="width:150px;text-align:center">
                        <small id="images_text">New image</small>
                    </div> -->
                </form>
                <input class="card-body btn btn-sm btn-primary" style="width:150px;border-radius:0px" type="submit" name="btn_submit" id="btn_add_img" value="Add Image">
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('bottom_scripts')
<script>
    let listingObj = {!!json_encode($entry->listing)!!};
    let entryObj = {!!json_encode($entry)!!};
    // let listingObj = {!!json_encode($entry->listing)!!};
</script>
@yield('entries_scripts')
@endsection