@extends('layouts.base_beginner_info')

@section('title')
    <title>My Applications | Beginners Pad</title>
@endsection

@section('beginner_panel_title')
    My Listing Applications
@endsection

@section('beginner_panel_body')
    @forelse($applications as $application)
    <div class="card-big-clickable card-block" style="margin:9px; " role="button" onclick="location.href='/listings/{{$application->property_id}}/view';">
        <div class="col-md-7 col-md-offset-0">
            <span style="display: inline-block;width: 210px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"><h4>{{$application->listing->property_name}} <small>({{$application->listing->lister_name}})</small></h4></span><br>
            <span><small>Location: <strong>{{$application->listing->location}}</strong></small></span><br>
            <span><small>Area: <strong>{{$application->listing->unit_area}}</strong> sq M</small></span><br>
            <span><small>KES <strong>{{number_format($application->listing->cost, 2)}}</strong> per month</small></span><br>
            @if($application->status=='active')
            <span><small>You applied on <strong>{{$application->updated_at}}</strong></small></span><br>
            @else
            <span><small>You applied on <strong>{{$application->updated_at}}</strong></small></span><br>
            @endif
        </div>
        <div class="col-md-5">
            @if($application->listing->images != null)
            <img class="img-rounded" style="width:150px;height:120px;" src="/images/listings/{{$application->listing->user_id}}/thumbnails/{{$application->listing->images}}" alt="unable to display image">
            @elseif($application->listing->images == null)
            <img class="img-rounded" style="width:150px;height:120px;" src="/images/listings/vector-house-icon.jpg" alt="unable to display image">
            @endif
        </div>
    </div>
    @empty
        <h4 style="text-align:center;">No applications</h4>
    @endforelse
@endsection