@extends('layouts.base_no_panel')

@section('title')
    <title>Beginners Pad</title>
@endsection

@section('content')
<div class="container"><h1>Listings</h1></div>  
<div class="container">
   <div class="card">
      <div class="card-header">Sorted by newest first</div>
      <div class="card-body">
         @forelse($listings as $listing)
         <a role="button" onclick="location.href='/listings/{{$listing->id}}/view';">
            <div class="cst-cards" style="margin:5px">
               <div class="cst-card" style="width:260px;">
                  @if($listing->images == null)
                  <div class="cst-card-header"></div>
                  @else
                  <div>
                     <img style="width:260px;height:180px;" src="/images/listings/{{$listing->user_id}}/thumbnails/{{$listing->images}}" alt="unable to display image">
                  </div>
                  @endif
                  <div class="cst-card-body">
                     <div class="cst-card-title">{{$listing->property_name}}</div>
                     <div class="cst-card-sub-title">{{$listing->location}}</div>
                     <div class="cst-card-desc"><h6><span style="display: inline-block;width:240px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">{{$listing->description}}</span></h6></div>
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