@extends('layouts.base_no_panel')

@section('title')
    <title>Welcome | Beginners Pad</title>
@endsection

@section('welcome_expansion')
<div class="header-banner">
   <div class="container">
      <div class="clearfix"></div>
      <div class="lead-title" style="color:whitesmoke">Welcome to Beginners Pad<br/></div>
      @if (Auth::guest())
      <div class="sub-lead-title"><h4 style="color:whitesmoke">Howdy, stranger!</div>
      @else
      <div class="sub-lead-title"><h4 style="color:whitesmoke">Howdy, {{ucfirst(Auth::user()->name)}}!</h5></div>
      @endif
      <div class="lead-btn" role="button" onclick="location.href='{{route('listings.list')}}';">
         <span>What's new</span>
      </div>
   </div>
</div>
@endsection

@section('content')
   <div class="container">
      <div class="flex-title">Listings</div>
      <div class="flex-desc">Sorted by newest first</div>
      @forelse($listings as $listing)
      <a role="button" onclick="location.href='/listings/{{$listing->id}}/view';">
         <div class="cards" style="margin:5px">
            <div class="card" style="width:280px;height:320px;">
               @if($listing->images == null)
               <div class="card-header"></div>
               @else
               <div>
                  <img style="width:280px;height:210px;" src="/images/listings/{{$listing->user_id}}/thumbnails/{{$listing->images}}" alt="unable to display image">
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
@endsection

@section('feature_section_1')
   <section class="blk-sect">
      <div class="container-width">
         <div class="blk-title">Subscriptions</div>
         <div class="blk-desc">Still in development...</div>
         <div class="price-cards">
            <div class="price-card-cont">
               <div class="price-card">
                  <div class="pc-title">Starter</div>
                  <div class="pc-desc">Some random list</div>
                  <div class="pc-feature odd-feat">+ Starter feature 1</div>
                  <div class="pc-feature">+ Starter feature 2</div>
                  <div class="pc-feature odd-feat">+ Starter feature 3</div>
                  <div class="pc-feature">+ Starter feature 4</div>
                  <div class="pc-amount odd-feat">KES 100/mo</div>
               </div>
            </div>
            <div class="price-card-cont">
               <div class="price-card pc-regular">
                  <div class="pc-title">Premium</div>
                  <div class="pc-desc">Some random list</div>
                  <div class="pc-feature odd-feat">+ Regular feature 1</div>
                  <div class="pc-feature">+ Regular feature 2</div>
                  <div class="pc-feature odd-feat">+ Regular feature 3</div>
                  <div class="pc-feature">+ Regular feature 4</div>
                  <div class="pc-amount odd-feat">KES 300/mo</div>
               </div>
            </div>
            <div class="price-card-cont">
               <div class="price-card pc-enterprise">
                  <div class="pc-title">Ultimate</div>
                  <div class="pc-desc">Some random list</div>
                  <div class="pc-feature odd-feat">+ Enterprise feature 1</div>
                  <div class="pc-feature">+ Enterprise feature 2</div>
                  <div class="pc-feature odd-feat">+ Enterprise feature 3</div>
                  <div class="pc-feature">+ Enterprise feature 4</div>
                  <div class="pc-amount odd-feat">KES 500/mo</div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection

@section('footer_content')
<footer class="footer-under">
   <div class="container-width">
      <div class="footer-container">
         <div class="foot-lists">
            <div class="foot-list">
               <div class="foot-list-title">About us</div>
               <div class="foot-list-item">Contact</div>
               <div class="foot-list-item">Company</div>
            </div>
            <div class="clearfix"></div>
         </div>
         <div class="form-sub">
            <div class="foot-form-cont">
               <div class="foot-form-title">Subscribe</div>
               <div class="foot-form-desc">Subscribe to our newsletter to receive exclusive offers and the latest news</div>
               <input placeholder="Name" name="name" class="sub-input"/>
               <input placeholder="Email" name="email" class="sub-input"/>
               <button type="button" class="sub-btn">Submit</button>
            </div>
         </div>
      </div>
   </div>
</footer>
@endsection

@section('footer_bottom')
<footer class="footer-minor">
   <div class="copyright-minor">
     <div class="container-width">
        <div class="made-with" style="">Developed by Nick Otonglo</div>
        <div class="foot-social-btns">facebook twitter linkedin mail</div>
        <div class="clearfix"></div>
     </div>
   </div>
</footer>
@endsection
