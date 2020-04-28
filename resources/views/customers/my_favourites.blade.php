@extends('layouts.base_beginner_info')

@section('title')
    <title>My Favourites | Beginners Pad</title>
@endsection

@section('beginner_panel_title')
    My Favourites
@endsection

@section('beginner_panel_body')
    @forelse($favourites as $favourite)
        <div class="card-big-clickable card-block" style="margin:9px; " role="button" onclick="location.href='/listings/{{$favourite->property_id}}/view';">
            <div class="col-md-7 col-md-offset-0">
                <span style="display: inline-block;width: 210px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"><h4>{{$favourite->property_name}} <small>({{$favourite->lister_name}})</small></h4></span><br>
                <span><small><strong>{{$favourite->available_units}}</strong> unit(s) left</small></span><br>
                <span><small>Area: <strong>{{$favourite->listing->unit_area}}</strong> sq M</small></span><br>
                <span><small>KES <strong>{{number_format($favourite->cost, 2)}}</strong> per month</small></span><br>
            </div>
            <div class="col-md-5">
                @if($favourite->listing->images != null)
                <img class="img-rounded" style="width:150px;height:120px;" src="/images/listings/{{$favourite->listing->user_id}}/thumbnails/{{$favourite->listing->images}}" alt="unable to display image">
                @elseif($favourite->listing->images == null)
                <img class="img-rounded" style="width:150px;height:120px;" src="/images/listings/vector-house-icon.jpg" alt="unable to display image">
                @endif
            </div>
        </div>
    @empty
        <h4 style="text-align:center;">No favourites</h4>
    @endforelse
@endsection