@extends('layouts.base_admin_manage_listings')

@section('title')
    <title>Property Management | Beginners Pad</title>
@endsection

@section ('lister_col_centre')
<div class="card">
    @isset ($category)
        @if ($category == 'zone' || $category == 'subzone')
        <div class="card-header">Properties listed in {{$statusItem}} area</div>
        @elseif ($category == 'lister')
        <div class="card-header">Properties listed by {{$statusItem}}</div>
        @endif
    @else
    <div class="card-header text-capitalize">{{$statusItem}} Properties Listed</div>
    @endif
    <div class="card-body">
        <div class="post">
            <div class="row">
                @forelse($listings as $listing)
                <a role="button" href="{{route('admin.manageListing',['listing'=>$listing->id])}}">
                    <div class="card mb-3" style="max-width: 540px;margin: auto">
                        <div class="row g-0">
                            @if($listing->thumbnail != null)
                            <div class="col-md-4" style="background-image: url('/images/listings/{{$listing->id}}/thumbnails/{{$listing->thumbnail}}');background-position: center;"></div>
                            @elseif($listing->thumbnail == null)
                            <div class="col-md-4" style="background-image: url('/images/listings/vector-house-icon.jpg');background-position: center;"></div>
                            @endif
                            <div class="col-md-8">
                                <div class="card-body">
                                    <span style="display: inline-block;width: calc(95%);white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
                                        <h5 class="card-title">{{$listing->property_name}}</h5>
                                    </span>
                                    @if($listing->status=='unpublished')
                                    <p class="card-text"><small>not submitted for publishing</small></p>
                                    @elseif($listing->status=='pending')
                                    <p class="card-text text-info"><small>pending approval</small></p>
                                    @elseif($listing->status=='approved')
                                    <p class="card-text text-success"><small>approved</small></p>
                                    @elseif($listing->status=='rejected')
                                    <p class="card-text text-danger"><small>rejected</small></p>
                                    @elseif($listing->status=='suspended')
                                    <p class="card-text text-danger"><small>suspended</small></p>
                                    @else
                                    <p class="card-text"><small>invalid status</small></p>
                                    @endif
                                    <p class="card-text"><small>Location: <i>{{$listing->zoneEntry->name}} ({{$listing->zoneEntry->zone->county}})</i></small></p>
                                    @if($listing->listing_type=='single')
                                    <p class="card-text"><small>Type: <i>Single-listing property</i></small></p>
                                    @elseif($listing->listing_type=='multi')
                                    <p class="card-text"><small>Type: <i>Multiple-listing property</i></i></small></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                    <h4 style="text-align:center;">No listings to manage</h4>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection