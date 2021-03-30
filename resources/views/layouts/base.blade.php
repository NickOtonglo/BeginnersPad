<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('css/beginnerspad.css')}}">
  <link rel="stylesheet" href="{{asset('css/card.css')}}">
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">
  @yield('stylesheets')
  @yield('top_scripts')
  @yield('title')
</head>
<body>
  <header>
    <nav class="navbar navbar-default navbar-fixed-top" style="background:whitesmoke">
      <div class="container-fluid">
        <div class="navbar-header">
          <div class="navbar-brand" role="button" style="border-radius: 15px 50px 30px;" onclick="location.href='{{route('home')}}';">
            <p class="bp-navbar-text-colour">Beginners Pad</p>
          </div>
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
        </div>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="nav navbar-nav">
            <li class="{{ Route::currentRouteNamed('listings.list') || Request::is('listings/*') ? 'active' : '' }}">
              <a href="{{route('listings.list')}}">Listings</a>
            </li>
            @if(!Auth::guest())
              @if (Auth::user()->user_type === 5)
              <li class="{{ Route::currentRouteNamed('customer.myReviews') ? 'active' : '' }}">
                <a href="{{route('customer.myReviews')}}">My Reviews</a>
              </li>
              <li class="{{ Route::currentRouteNamed('customer.waitingList') ? 'active' : '' }}">
                <a href="{{route('customer.waitingList')}}">Waiting List</a>
              </li>
              <li class="{{ Route::currentRouteNamed('listing.myFavourites') ? 'active' : '' }}">
                <a href="{{route('listing.myFavourites')}}">My Favourites</a>
              </li>
              <li class="{{ Route::currentRouteNamed('listing.myApplications') ? 'active' : '' }}">
                <a href="{{route('listing.myApplications')}}">Property History</a>
              </li>
              @elseif (Auth::user()->user_type === 4)
              <li class="{{ Route::currentRouteNamed('lister.myApplications') ? 'active' : '' }}">
                <a href="{{route('lister.myApplications')}}">My Applications</a>
              </li>
              <li class="{{ Route::currentRouteNamed('lister.manageListings') ? 'active' : '' }}">
                <a href="{{route('lister.manageListings')}}">Manage Listings</a>
              </li>
              @elseif (Auth::user()->user_type === 3 || Auth::user()->user_type === 2 || Auth::user()->user_type === 1)
              <li class="{{ Route::currentRouteNamed('admin.listUsers') || Request::is('manage_user/*') ? 'active' : '' }}">
                <a href="{{route('admin.listUsers')}}">Manage Users</a>
              </li>
              <li class="{{ Route::currentRouteNamed('admin.manageListings') ? 'active' : '' }}">
                <a href="{{route('admin.manageListings',['status'=>'pending'])}}">Applications</a>
              </li>
              <li class="{{ Route::currentRouteNamed('admin.manageBookmarks') ? 'active' : '' }}">
                <a href="{{route('admin.manageBookmarks')}}">Bookmarks</a>
              </li>
              <li class="{{ Route::currentRouteNamed('admin.zones') ? 'active' : '' }}">
                <a href="{{route('admin.zones')}}">Zones</a>
              </li>
              <li class="{{ Route::currentRouteNamed('admin.topics') ? 'active' : '' }}">
                <a href="{{route('admin.topics')}}">Topics</a>
              </li>
              <li class="">
                <a href="{{route('listings.list')}}">Reports</a>
              </li>
              @endif
            @endif
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="{{ Route::currentRouteNamed('help') || Request::is('help/*') ? 'active' : '' }}">
              <a href="{{url('/help')}}"><span class="glyphicon glyphicon-question-sign"></span> Help</a>
            </li>
            @if (Auth::guest())
            <li class="{{ Request::is('register') ? 'active' : '' }}">
              <a href="{{url('/register')}}"><span class="glyphicon glyphicon-user"></span> Register</a>
            </li>
            <li class="{{ Request::is('login') ? 'active' : '' }}">
              <a href="{{url('/login')}}"><span class="glyphicon glyphicon-log-in"></span> Login</a>
            </li>
            @else
            <li class="{{ Route::currentRouteNamed('manageAccount') || Request::is('account/*') ? 'active' : '' }}">
              <div class="btn-group pull-xs-right">
                <button type="button" class="btn btn-primary dropdown-toggle" style="background-color:transparent;border:0px;margin-top:7px;"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  &nbsp <span class="text-muted">Account</span>
                  <div style="float:left">
                    @if (Auth::user()->avatar != null)
                      <img style="width:25px;height:25px; float:left; border-radius:50%; border:2px solid white;" src="/images/avatar/{{Auth::user()->id}}/{{Auth::user()->avatar}}" alt="">
                    @elseif (Auth::user()->avatar == null)
                      <img style="width:25px;height:25px; float:left; border-radius:50%; border:2px solid white;" src="/images/avatar/avatar.png" alt="">
                    @endif
                  <div>
                </button>
                <ul class="dropdown-menu">
                  <div class="list-group">
                    <li class="dropdown-header"><span style="display: inline-block;width: 160px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"><strong>{{Auth::user()->name}}</strong></span></li>
                    <a href="{{route('manageAccount')}}" class="list-group-item">Manage Account</a>
                    <a class="list-group-item" role="button" onclick="location.href='{{route('logout')}}';" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">Logout</a>
                    <form action="{{route('logout')}}" id="logout-form" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>
                  </div>
                </ul>
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
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="{{asset('js/jquery.bxslider.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/tooltip.js')}}"></script>
  @yield('bottom_scripts')
</body>

