@extends('layouts.base_no_panel')

@section('title')
<title>Help - Frequently Asked Questions | Beginners Pad</title>
@endsection

@section ('content')
    @yield('top-msg-area')
<br>

<div class="row">
    <div class="container-width">
        <div class="h3"><strong>Frequently Asked Questions</strong></div>
    </div>
</div>
<br>

@forelse($faqs as $faq)
<div class="container">
    <h3>{{$faq->question}}</h3>
    <br>
    <p>{{$faq->answer}}</p>
    <hr>
</div>
@empty
<div class="container">
    <p>-no entries available currently-</p>
</div>
@endforelse

@endsection