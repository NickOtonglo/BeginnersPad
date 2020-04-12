@extends('layouts.base_no_panel')

@section('title')
    <title>All Listings | Beginners Pad</title>
@endsection

@section ('content')
    <!-- Main component for call to action -->
    <div class="container">
        <div class="flex-sect">

            <section class="flex-sect">
                <div class="container-width">

                    <div class="flex-title">All Listings</div>

                    @forelse($listings as $listing)
                    <div class="card-big-clickable card-block" role="button" onclick="location.href='/manage_listings/all/{{$listing->id}}';">
                        <a>
                            <div class="flex-desc">
                                <strong> {{$listing->property_name}} ({{$listing->lister_name}}) </strong>
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
                                @if($listing->status == "approved")
                                    Status: <strong style="color: green; ">{{$listing->status}}</strong>
                                @elseif($listing->status == "rejected")
                                    Status: <strong style="color: red; ">{{$listing->status}}</strong>
                                @elseif($listing->status == "suspended")
                                    Status: <strong class="text-danger">{{$listing->status}}</strong>
                                @else
                                    Status: <strong>{{$listing->status}}</strong>
                                @endif
                            </h6>
                        </h6>                           
                    </div>
                    @empty
                        <h4 style="text-align:center;">No listings available</h4>
                    @endforelse

                </div>
            </section>
        </div>
    </div>
@endsection