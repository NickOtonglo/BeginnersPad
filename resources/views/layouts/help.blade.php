@extends('layouts.base_no_panel')

@section('title')
    <title>Help | Beginners Pad</title>
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endsection

@section ('content')
<div class="container">
    <h1>Help</h1>
    @if(Auth::check())
        @if(Auth::user()->user_type === 4 || Auth::user()->user_type === 5)
            <div style="float: right;">
                <a class="btn btn-mid btn-info" href="/help/my_tickets" role="button">Ticket History</a>
            </div>
        @endif
    @endif
</div>
<hr>
<div class="container jumbotron">
    <div class="flex-desc"><h3>Frequently asked questions</h3></div>
    <dl>
        @forelse($faqs as $faq)
        <dt>{{$faq->question}}?</dt>
        <dd>{{$faq->answer}}.</dd>
        @empty
        <dd>Unavailable</dd>
        @endforelse
    </dl>
</div>
<div class="container">
    <div class="panel panel-info">
        <div class="panel-heading">Contact a representative</div>
        <div class="panel-body">
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
    </div>
</div>
@endsection