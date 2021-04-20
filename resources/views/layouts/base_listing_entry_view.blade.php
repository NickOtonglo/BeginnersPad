@extends('layouts.base_no_panel')

@section ('content')
<div class="container">
    @if(session()->has('message'))
    <div class="row">
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!</strong> {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif
    <div class="row">
        @yield('top_buttons')
	</div>
	<br>
    <div class="row">
        @yield('lister_forms')
    </div>
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
                @yield('thumbnail_button')
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
    <br>
    <!-- Remove the 'row' below this line for a different effect -->
    <div class="row">
        @forelse($entry->ListingFile->where('category','regular') as $image)
        <div class="responsive" style="padding: 10px;">
            <div class="gallery bp-gallery-container">
                <div class="btn-top-delete-gallery">
                    @if(Auth::user()->user_type === 4)
                    <form method="post" action="{{route('lister.deleteListingEntryImage',['listingId'=>$entry->listing->id,'entryId'=>$entry->id,'imageId'=>$image->id])}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input class="btn btn-sm bp-btn-outline-danger btn-entry-delete" type="submit" name="btn_submit" value="x">
                    </form>
                    @endif
                </div>
                <a target="_blank" href="/images/listings/{{$entry->listing->id}}/{{$image->file_name}}">
                    <img src="/images/listings/{{$entry->listing->id}}/{{$image->file_name}}" alt="{{$image->file_name}}">
                </a>
            </div>
        </div>
        @empty
        <h2 style="text-align:center;">No images to display</h2>
        @endforelse
    </div>
    @yield('img_control')
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