@extends('layouts.base_lister_info')

@section('title')
    <title>Manage Listings | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="container-fluid">
    <div class="pull-right">
        <a class="btn btn-mid btn-info" href="{{route('listings.new')}}" role="button">Create New Listing</a>
    </div>
</div>
<br>
@endsection

@section('lister_col_centre')
<div class="panel panel-default">
    <div class="panel-heading">My Listings</div>
    <div class="panel-body">
        <div class="post">
            <div class="row">
                @forelse($listings as $listing)
                    <div class="card-big-clickable card-block" style="margin:9px; " role="button" onclick="location.href='/manage_listings/{{$listing->id}}/manage';">
                        <div class="col-md-5">
                            @if($listing->images != null)
                            <img class="img-rounded" style="width:150px;height:120px;" src="/images/listings/{{$listing->user_id}}/thumbnails/{{$listing->images}}" alt="unable to display image">
                            @elseif($listing->images == null)
                            <img class="img-rounded" style="width:150px;height:120px;" src="/images/listings/vector-house-icon.jpg" alt="unable to display image">
                            @endif
                        </div>
                        <div class="col-md-5 col-md-offset-0">
                            <span style="display: inline-block;width: 210px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"><h4>{{$listing->property_name}}</h4></span><br>
                            <span><small><strong>{{$listing->available_units}}</strong> unit(s) left</small></span><br>
                            <span><small><strong>{{$listing->unit_area}}</strong> sq M</small></span><br>
                            <span><small>KES <strong>{{number_format($listing->cost, 2)}}</strong></small></span>
                        </div>
                    </div>
                @empty
                    <h4 style="text-align:center;">You have no active listings</h4>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection