@extends('layouts.base_no_panel')

@section('title')
    <title>Pending Applications | Beginners Pad</title>
@endsection

@section ('content')
    <!-- Main component for call to action -->
    <div class="container">
        <div class="flex-sect">
            <div class="pull-xs-right">
                <a class="btn btn-mid btn-info" href="{{route('admin.allListings')}}" role="button">
                    All Listings
                </a>
            </div>

            <h1>Hello {{ ucfirst(Auth::user()->name) }},</h1>
            <p>Use this portal to manage pending listings.</p>
            
            <section class="flex-sect">
                <div class="container-width">

                    <div class="flex-title">Pending Listings</div>

                    @forelse($listings as $listing)
                    <div class="card-big-clickable card-block" role="button" onclick="location.href='/manage_listings/all/{{$listing->id}}';">
                        <a>
                            <div class="flex-desc">
                                <strong> {{$listing->property_name}} </strong>
                            </div>
                        </a>
                        <h6 class="card-text">
                            <a class="text-primary">
                                Location: <strong class="text-danger">{{$listing->location}}</strong>
                            </a>
                            <small class="pull-xs-right">
                                Posted on {{$listing->created_at}}
                            </small>
                            <br><br>
                            <h6>
                                <strong>Status: {{$listing->status}}</strong>
                            </h6>
                        </h6>                                
                    </div>
                    @empty
                        <h4 style="text-align:center;">No applications</h4>
                    @endforelse

                </div>
            </section>
        </div>
    </div>
@endsection