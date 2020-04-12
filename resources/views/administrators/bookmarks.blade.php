@extends('layouts.base_no_panel')

 @section('title')
    <title>My Bookmarks | Beginners Pad</title>
@endsection

 @section('content')
            <!-- /navbar -->
            <!-- Main component for call to action -->
            <section class="flex-sect">
                <div class="container">
                    <div class="flex-title">Bookmarks</div>
                    
                    <div class="clearfix">
                    </div>
                    <!--============= notes=========== -->
                    <div class="list-group notes-group">

                        @forelse($bookmarks as $bookmark)
                        <div class="card-big-clickable card-block" role="button" onclick="location.href='/manage_listings/all/{{$bookmark->property_id}}';">
                            <a class='text-primary'>

                            <form action="/manage_listings/bookmarks/{{$bookmark->property_id}}/remove" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <input class="btn btn-sm btn-danger pull-xs-right" type="submit" value="Remove" name="btn_delete"></input>
                            </form>
                                
                                <div class="flex-desc">
                                    <strong> {{$bookmark->property_name}} ({{$bookmark->lister_name}}) </strong>
                                </div>
                            </a>
                            <h6 class="card-text">
                                <a class="text-primary">
                                    Saved on {{$bookmark->updated_at}}
                                </a>
                                <br><br>
                            </h6>
                        </div>
                        @empty
                            <h4 style="text-align:center;">No bookmarks</h4>
                        @endforelse

                    </div>
                </div>
            
            </section>
@endsection