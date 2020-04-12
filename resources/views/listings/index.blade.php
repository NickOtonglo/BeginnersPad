@extends('layouts.base_no_panel')

@section('stylesheets')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endsection

@section('title')
    <title>Beginners Pad</title>
@endsection

@section('content')
<div class="container"><h1>Listings</h1></div>  
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading" style="background:white">Sorted by newest first</div>
      <div class="panel-body" style="background:whitesmoke;">
         @forelse($listings as $listing)
         <a role="button" onclick="location.href='/listings/{{$listing->id}}/view';">
            <div class="cards" style="margin:5px">
               <div class="card" style="width:260px;">
                  @if($listing->images == null)
                  <div class="card-header"></div>
                  @else
                  <div>
                     <img style="width:260px;height:180px;" src="/images/listings/{{$listing->user_id}}/thumbnails/{{$listing->images}}" alt="unable to display image">
                  </div>
                  @endif
                  <div class="card-body">
                     <div class="card-title">{{$listing->property_name}}</div>
                     <div class="card-sub-title">{{$listing->location}}</div>
                     <div class="card-desc"><h6><span style="display: inline-block;width:240px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">{{$listing->description}}</span></h6></div>
                  </div>
               </div>
            </div>
         </a>
         @empty
            <h4 style="text-align:center;">No listings available</h4>
         @endforelse
      </div>
   </div>
</div>
@endsection