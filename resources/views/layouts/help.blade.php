@extends('layouts.base_help')

@section('title')
    <title>Help | Beginners Pad</title>
@endsection

@section ('top_buttons')
<div class="container">
	<div class="pull-right">
    @if(Auth::check())
        @if(Auth::user()->user_type === 4 || Auth::user()->user_type === 5)
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-sm btn-outline-secondary" href="{{route('viewTicketHistory')}}" role="button">Ticket History</a>
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
            <dd class="bp-text-line-clamp">{{$faq->answer}}.</dd>
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
        <a class="pull-right" style="color:deepskyblue;text-decoration: underline deepskyblue;" href="#">View all help topics</a>
    </div>
</div>
@endsection

@section ('col_right')
<div class="card">
    <div class="card-header">Contact a representative</div>
    <div class="card-body">
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
            <div class="mb-3">
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
            <div class="mb-3">
                <label for="category">Help Category *</label>
                <div class="alert alert-danger" id="alert_category" hidden></div>
                <select class="form-select" id="category" name="category">
                    <option value="">Select Category</option>
                    @forelse($helpCats as $category)
                    <option value="{{$category->name}}">{{$category->name}}</option>
                    @empty
                    <option value="">-no categories available-</option>
                    @endforelse
                </select>
            </div>
            <div class="mb-3">
                <label for="description">Text (Describe your problem in detail) *</label>
                <div class="alert alert-danger" id="alert_description" hidden></div>
                <textarea class="form-control" name="description" type="text" id="description" rows="10"></textarea>
            </div>
            <div class="mb-3">
                <input class="btn btn-outline-primary" value="Submit" type="submit" id="btn_submit">
            </div>
        </form>
    </div>
</div>
@endsection

@section ('bottom_scripts')
<script src="{{asset('js/help.js')}}"></script>
@endsection