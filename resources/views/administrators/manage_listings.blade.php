@extends('layouts.base_admin_manage_listings')

@section('title')
    <title>Pending Property Applications | Beginners Pad</title>
@endsection

@section ('lister_col_centre')
@section('lister_col_centre')
<div class="panel panel-default">
    <div class="panel-heading">**********</div>
    <div class="panel-body">
        <div class="post">
            <div class="row">
                @forelse($listings as $listing)
                    <a class="card-big-clickable card-block" style="margin:9px;" role="button" href="{{route('admin.manageListing',['listing'=>$listing->id])}}">
                        <div class="col-md-8 col-md-offset-0">
                            <span style="display: inline-block;width: 210px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"><h4>{{$listing->property_name}}</h4></span><br>
                            @if($listing->status=='unpublished')
                            <span><small><strong class="text-default">not submitted for publishing</strong></small></span><br>
                            @elseif($listing->status=='pending')
                            <span><small><strong class="text-info">pending approval</strong></small></span><br>
                            @elseif($listing->status=='approved')
                            <span><small><strong class="text-success">approved</strong></small></span><br>
                            @elseif($listing->status=='rejected')
                            <span><small><strong class="text-danger">rejected</strong></small></span><br>
                            @elseif($listing->status=='suspended')
                            <span><small><strong class="text-danger">suspended</strong></small></span><br>
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
                    <h4 style="text-align:center;">No listings to manage</h4>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection