@extends('layouts.base_no_panel')

@section('stylesheets')
  <link rel="shortcut icon" href="/assets/images/icon-star.png?v=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
      height: 100%;
    }
    /* Optional: Makes the sample page fill the window. */
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
  </style>
@endsection

@section('top_scripts')
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
@endsection

@section('content')
  @yield('listing-form')
  
@endsection

@section('bottom_scripts')
  <script src="https://maps.googleapis.com/maps/api/js?key={{$API_KEY}}&callback=initMap"async defer></script>
  <script src="{{asset('js/map-script.js')}}"></script>
@endsection