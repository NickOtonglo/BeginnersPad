@extends('layouts.base_help')

@section('title')
    <title>Help | Beginners Pad</title>
@endsection

@section ('top_buttons')
<div class="container">
	<div class="pull-right">
    @if(Auth::check())
        @if(Auth::user()->user_type === 4 || Auth::user()->user_type === 5)
            <div style="float: right;">
                <a class="btn btn-mid btn-default" href="/help/my_tickets" role="button">Ticket History</a>
            </div>
        @endif
    @endif
	</div>
</div>
<br>
@endsection

@section ('col_left')
<div class="jumbotron">
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

<div class="jumbotron">
    <div class="flex-desc"><h3>Help topics</h3></div>
    <dl>
        @forelse($faqs as $faq)
        <dt>{{$faq->question}}?</dt>
        <dd>{{$faq->answer}}.</dd>
        @empty
        <dd>Unavailable</dd>
        @endforelse
    </dl>
</div>
@endsection

@section ('col_right')
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
@endsection