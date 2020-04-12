@extends('layouts.base')

@section('content')
	<section class="flex-sect">
         <div class="container-width">
            <div class="flex-title">Listings</div>
            <div class="flex-desc">Sorted by newest first</div>
            <!--============================================= Listings =================================================-->
            <!-- Listing item -->
            @foreach($listings as $listing)
            <a role="button" onclick="location.href='/listings/{{$listing->id}}/view';">
               <div class="cards">
                  <div class="card">
                     <div class="card-header"></div>
                     <div class="card-body">
                        <div class="card-title">{{$listing->name}}</div>
                        <div class="card-sub-title">{{$listing->location}}</div>
                        <div class="card-desc">{{$listing->description}}</div>
                     </div>
                  </div>
                  
               </div>
            </a>
            @endforeach
         </div>
      </section>
@endsection