<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('css/beginnerspad.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
  <!-- <link rel="stylesheet" href="{{asset('css/card.css')}}"> -->
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">
  @yield('stylesheets')
  @yield('top_scripts')
  @yield('title')
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="navbar-brand">
          <a class="bp-navbar-text-colour" role="button" onclick="location.href='{{route('home')}}';">Beginners Pad</a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto">
            <li class="nav-item {{ Route::currentRouteNamed('listings.list') || Request::is('listings/*') ? 'active' : '' }}">
              <a class="nav-link" href="{{route('listings.list')}}">Listings</a>
            </li>
            @if(!Auth::guest())
              @if (Auth::user()->user_type === 5)
              <li class="nav-item {{ Route::currentRouteNamed('customer.myReviews') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('customer.myReviews')}}">My Reviews</a>
              </li>
              <li class="nav-item {{ Route::currentRouteNamed('customer.waitingList') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('customer.waitingList')}}">Waiting List</a>
              </li>
              <li class="nav-item {{ Route::currentRouteNamed('listing.myFavourites') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('listing.myFavourites')}}">My Favourites</a>
              </li>
              <li class="nav-item {{ Route::currentRouteNamed('listing.myApplications') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('listing.myApplications')}}">Property History</a>
              </li>
              @elseif (Auth::user()->user_type === 4)
              <li class="nav-item {{ Route::currentRouteNamed('lister.myApplications') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('lister.myApplications')}}">My Applications</a>
              </li>
              <li class="nav-item {{ Route::currentRouteNamed('lister.manageListings') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('lister.manageListings')}}">Manage Listings</a>
              </li>
              @elseif (Auth::user()->user_type === 3 || Auth::user()->user_type === 2 || Auth::user()->user_type === 1)
              <li class="nav-item {{ Route::currentRouteNamed('admin.listUsers') || Request::is('manage_user/*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.listUsers')}}">Manage Users</a>
              </li>
              <li class="nav-item {{ Route::currentRouteNamed('admin.manageListings') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.manageListings',['status'=>'pending'])}}">Applications</a>
              </li>
              <li class="nav-item {{ Route::currentRouteNamed('admin.manageBookmarks') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.manageBookmarks')}}">Bookmarks</a>
              </li>
              <li class="nav-item {{ Route::currentRouteNamed('admin.zones') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.zones')}}">Zones</a>
              </li>
              <li class="nav-item {{ Route::currentRouteNamed('admin.topics') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('admin.topics')}}">Topics</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('listings.list')}}">Reports</a>
              </li>
              @endif
            @endif
          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="{{ Route::currentRouteNamed('help') || Request::is('help/*') ? 'active' : '' }}">
              <a class="nav-link" href="{{url('/help')}}"><span class="material-icons" style="font-size: 18px;">help_outline</span> Help</a>
            </li>
            @if (Auth::guest())
            <li class="{{ Request::is('register') ? 'active' : '' }}">
              <a class="nav-link" href="{{url('/register')}}"><span class="material-icons" style="font-size: 18px;">person_outline</span> Register</a>
            </li>
            <li class="{{ Request::is('login') ? 'active' : '' }}">
              <a class="nav-link" href="{{url('/login')}}"><span class="material-icons" style="font-size: 18px;">login</span></span> Login</a>
            </li>
            @else
            <li class="nav-item dropdown">
              @if (Auth::user()->avatar != null)
              <img class="img-navbar-account" src="/images/avatar/{{Auth::user()->id}}/{{Auth::user()->avatar}}" alt="">
              @elseif (Auth::user()->avatar == null)
              <img class="img-navbar-account" src="/images/avatar/avatar.png" alt="">
              @endif
              <a class="nav-link dropdown-toggle navbar-account" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Account
              </a>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <h6 class="dropdown-header"><span style="display: inline-block;width: 160px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">{{Auth::user()->name}}</span></h6>
                <a class="dropdown-item" href="{{route('manageAccount')}}">Manage Account</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" role="button" onclick="location.href='{{route('logout')}}';
                event.preventDefault();
                document.getElementById('logout-form').submit();">Logout</a>
                <form action="{{route('logout')}}" id="logout-form" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </div>
            </li>
            @endif
          </ul>
        </div>
      </div>
    </nav>
    @yield('welcome_expansion')
  </header>
  <section style="min-height: 100vh;">
    @yield('content-base')
  </section>
  @yield('feature_section_1')
  @yield('footer_content')
  @yield('footer_bottom')
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{asset('js/tooltip.js')}}"></script>
  @yield('bottom_scripts')
</body>

