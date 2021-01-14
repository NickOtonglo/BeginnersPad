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
        
        <form method="post" action="{{route('help')}}" enctype="multipart/form-data" id="help_form">
            {{csrf_field()}}
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input class="form-control" name="email" type="text" id="email">
            </div>
            <div class="form-group">
                <label for="name">Help Category *</label>
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
                <label for="name">Text (Describe your problem in detail) *</label>
                <textarea class="form-control" name="description" type="text" id="description" rows="10"></textarea>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" value="Submit" type="submit" >
            </div>
        </form>
    </div>
</div>
@endsection

@section ('bottom_scripts')
<script src="{{asset('js/help.js')}}"></script>
@endsection