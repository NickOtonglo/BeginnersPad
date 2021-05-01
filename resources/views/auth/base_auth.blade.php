@extends('layouts.base_no_panel')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 col-md-offset-3">
            @yield('col_main')
        </div>
    </div>
</div>
@endsection
