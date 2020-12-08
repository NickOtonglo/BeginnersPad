@extends('layouts.base_no_panel')

@section('content')
    <br>
    @yield('top_buttons')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                @yield('col_centre')
            </div>
            
        </div>
    </div>
@endsection

@section('bottom_scripts')
<script src="{{asset('js/base-listings-applications-management-admin.js')}}"></script>
@endsection