@extends('layouts.base_no_panel_no_clutter')

@section('title')
    <title>My Bookmarks | Beginners Pad</title>
@endsection

@section('lister_col_centre')
<div class="card">
    <div class="card-header">Bookmarks</div>
    <div class="card-body">
        <div class="post">
            <div class="row">
                @forelse($bookmarks as $bookmark)
                    @if($bookmark->listing_entry_id == null)
                    <a role="button" href="{{route('admin.manageListing',['listing'=>$bookmark->listing->id])}}">
                        <div class="card mb-3" style="max-width: 540px;margin: auto">
                            <form action="{{route('admin.removeBookmark',['id'=>$bookmark->id])}}" method="post" enctype="multipart/form-data" >
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <input class="btn btn-sm btn-outline-danger btn-top-delete btn-delete" type="submit" value="x" name="btn_delete" data-toggle="tooltip" title="Delete" id="btnDelete">
                            </form>
                            <div class="row g-0">
                                @if($bookmark->listing->thumbnail != null)
                                <div class="col-md-4" style="background-image: url('/images/listings/{{$bookmark->listing->id}}/thumbnails/{{$bookmark->listing->thumbnail}}');background-position: center;"></div>
                                @elseif($bookmark->listing->thumbnail == null)
                                <div class="col-md-4" style="background-image: url('/images/listings/vector-house-icon.jpg');background-position: center;"></div>
                                @endif
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <span style="display: inline-block;width: calc(95%);white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                            <h5 class="card-title">{{$bookmark->listing->property_name}}</h5>
                                        </span>
                                        @if($bookmark->listing->status=='unpublished')
                                        <p class="card-text"><small>not submitted for publishing</small></p>
                                        @elseif($bookmark->listing->status=='pending')
                                        <p class="card-text text-info"><small>pending approval</small></p>
                                        @elseif($bookmark->listing->status=='approved')
                                        <p class="card-text text-success"><small>approved</small></p>
                                        @elseif($bookmark->listing->status=='rejected')
                                        <p class="card-text text-danger"><small>rejected</small></p>
                                        @elseif($bookmark->listing->status=='suspended')
                                        <p class="card-text text-danger"><small>suspended</small></p>
                                        @else
                                        <p class="card-text"><small>invalid status</small></p>
                                        @endif
                                        <p class="card-text"><small>Location: <i>{{$bookmark->listing->zoneEntry->name}} ({{$bookmark->listing->zoneEntry->zone->county}})</i></small></p>
                                        @if($bookmark->listing->listing_type=='single')
                                        <p class="card-text"><small>Type: <i>Single-listing property</i></small></p>
                                        @elseif($bookmark->listing->listing_type=='multi')
                                        <p class="card-text"><small>Type: <i>Multiple-listing property</i></i></small></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @else
                    <a role="button" href="{{route('admin.manageListingEntry',['listingId'=>$bookmark->listing->id,'entryId'=>$bookmark->listingEntry->id])}}">
                        <div class="card mb-3" style="max-width: 540px;margin: auto">
                            <form action="{{route('admin.removeBookmark',['id'=>$bookmark->id])}}" method="post" enctype="multipart/form-data" >
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <input class="btn btn-sm btn-outline-danger btn-top-delete btn-delete" type="submit" value="x" name="btn_delete" data-toggle="tooltip" title="Delete" id="btnDelete">
                            </form>
                            <div class="row g-0">
                                @if($bookmark->listingEntry->listingFile()->where('category','thumbnail')->first() != null)
                                <div class="col-md-4" style="background-image: url('/images/listings/{{$bookmark->listing->id}}/thumbnails/{{$data[$bookmark->listingEntry->id]}}');background-position: center;"></div>
                                @elseif($bookmark->listing->thumbnail == null)
                                <div class="col-md-4" style="background-image: url('/images/listings/vector-house-icon.jpg');background-position: center;"></div>
                                @endif
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <span style="display: inline-block;width: calc(95%);white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                            <h5 class="card-title">{{$bookmark->listingEntry->listing_name}}</h5>
                                        </span>
                                        @if($bookmark->listingEntry->status=='active')
                                        <p class="card-text text-success"><small>active</small></p>
                                        @elseif($bookmark->listingEntry->status=='inactive')
                                        <p class="card-text text-danger"><small>inactive</small></p>
                                        @elseif($bookmark->listingEntry->status=='occupied')
                                        <p class="card-text"><small>occupied</small></p>
                                        @endif
                                        @if($bookmark->listingEntry->initial_deposit<=0)
                                        <p><small class="card-text">Initial deposit: <strong>Not required</strong></small></p>
                                        @elseif($bookmark->listingEntry->initial_deposit>0)
                                        <p><small class="card-text">Initial deposit: <strong>Required</strong></small></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endif
                @empty
                    <h4 style="text-align:center;">No bookmarks</h4>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('lister_col_left')
    <small>Bookmark Stats</small>
    <div class="bp-mini-panel">
        Total bookmarks: <strong>{{$bookmarks->count()}}</strong>
        <br>Property bookmarks: <strong>{{$bookmarks->where('listing_entry_id',null)->count()}}</strong>
        <br>Listing bookmarks: <strong>{{$bookmarks->where('listing_entry_id','!=',null)->count()}}</strong>
    </div>
@endsection

@section('bottom_scripts')
<script src="{{asset('js/bookmarks.js')}}"></script>
@endsection