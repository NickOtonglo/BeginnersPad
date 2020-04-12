@extends('layouts.base_no_panel')

@section('top_scripts')
    <script src="{{asset('js/telephone-validation.js')}}"></script>
@endsection

@section ('content')
<h6>Help</h6>
@if(Auth::check())
    @if(Auth::user()->user_type === 4 || Auth::user()->user_type === 5)
        <div class="container-width">
            @yield('top_buttons')
        </div>
    @endif
@endif
<section class="flex-sect">
    <div class="container container-width">
        <div class="flex-desc"><h3>Frequently asked questions</h3></div>
        <dl>
            @forelse($faqs as $faq)
            <dt>$faq->question</dt>
            <dd>$faq->answer</dd>
            @empty
            <dd>Unavailable</dd>
            @endforelse
        </dl>
    </div>
</section>
<section class="flex-sect">
    <div class="container container-width">
        <div class="flex-desc"><h3>Contact a representative</h3></div>
        @if(count($errors)>0)
            <ul>
                @foreach($errors->all() as $error)
                    <li class="alert alert-danger">{{$error}}</li>
                @endforeach
            </ul>
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        {{ Form::open(array('url'=>'/help')) }}
            <div class="form-group">
                @if(Auth::guest())
                    {{ Form::label('email','Email Address') }}
                    {{ Form::text('email','',['class'=>'form-control']) }}
                @endif
            </div>
            <div class="form-group">
                {{ Form::label('topic','Help Topic') }}
                {{ Form::select('topic',[null=>'Select Topic']+['topic1'=>'Topic 1','topic2'=>'Topic 2','topic3'=>'Topic 3','topic4'=>'Topic 4','topic5'=>'Topic 5'],null,['class'=>'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('description','Description') }}
                {{ Form::textarea('description','',['class'=>'form-control']) }}
            </div>
            {{ Form::submit('Submit', ['class'=>'btn btn-primary','value'=>'Submit']) }}
        {{ Form::close() }}
    </div>
</section>
@endsection