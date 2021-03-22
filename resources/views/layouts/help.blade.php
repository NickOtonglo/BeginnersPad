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
                <a class="btn btn-mid btn-default" href="{{route('viewTicketHistory')}}" role="button">Ticket History</a>
            </div>
        @endif
    @endif
	</div>
</div>
<br>
@endsection

@section ('col_left')
<div class="jumbotron">
    <div class="row" style="margin: 10px;">
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
    <div class="row" style="margin: 5px;">
        <a class="pull-right" style="color:deepskyblue;text-decoration: underline deepskyblue;" href="{{route('helpFAQ')}}">View all FAQs</a>
    </div>
</div>

<div class="jumbotron">
    <div class="row" style="margin: 10px;">
        <div class="flex-desc"><h3>Help topics</h3></div>
        <dl>
            @forelse($topics as $topic)
            <dt>{{$topic->title}}?</dt>
            <dd>{{$topic->text}}.</dd>
            @empty
            <dd>Unavailable</dd>
            @endforelse
        </dl>
    </div>
    <div class="row" style="margin: 5px;">
        <a class="pull-right" style="color:deepskyblue;text-decoration: underline deepskyblue;" href="">View all help topics</a>
    </div>
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
        
        <form method="post" action="{{route('help')}}" enctype="multipart/form-data" id="help_form">
            {{csrf_field()}}
            <div class="form-group">
                @if (!Auth::check())
                <label for="email">Email Address *</label>
                <div class="alert alert-danger" id="alert_email" hidden></div>
                <input class="form-control" name="email" type="text" id="email">
                @else
                <label for="email">Email Address *</label>
                <div class="alert alert-danger" id="alert_email" hidden></div>
                <input class="form-control" name="email" type="text" id="email" value="{{Auth::user()->email}}" readonly>
                @endif
            </div>
            <div class="form-group">
                <label for="category">Help Category *</label>
                <div class="alert alert-danger" id="alert_category" hidden></div>
                <select class="form-control" id="category" name="category">
                    <option value="">Select Category</option>
                    @forelse($helpCats as $category)
                    <option value="{{$category->name}}">{{$category->name}}</option>
                    @empty
                    <option value="">-no categories available-</option>
                    @endforelse
                </select>
            </div>
            <div class="form-group">
                <label for="description">Text (Describe your problem in detail) *</label>
                <div class="alert alert-danger" id="alert_description" hidden></div>
                <textarea class="form-control" name="description" type="text" id="description" rows="10"></textarea>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" value="Submit" type="submit" id="btn_submit">
            </div>
        </form>
    </div>
</div>
@endsection

@section ('bottom_scripts')
<script src="{{asset('js/help.js')}}"></script>
@endsection