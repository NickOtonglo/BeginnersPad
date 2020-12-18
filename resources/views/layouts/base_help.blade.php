@extends('layouts.base_no_panel')

@section('content')
    <br>
    @yield('top_buttons')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-0">
                @yield('col_left')
            </div>
            <div class="col-md-5 col-md-offset-1">
                @yield('col_right')
            </div>
        </div>
    </div>
@endsection

@section('bottom_scripts')

@endsection