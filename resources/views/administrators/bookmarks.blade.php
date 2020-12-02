@extends('layouts.base_no_panel_no_clutter')

@section('title')
    <title>My Bookmarks | Beginners Pad</title>
@endsection

@section('lister_col_centre')
<div class="panel panel-default">
    <div class="panel-heading">Bookmarks</div>
    <div class="panel-body">
        <div class="post">
            <div class="row">
                @forelse($bookmarks as $bookmark)
                    @if($bookmark->listing_entry_id == null)
                    <a class="card-big-clickable card-block" style="margin:9px;" role="button" href="{{route('admin.manageListing',['listing'=>$bookmark->listing->id])}}">
                        <form action="{{route('admin.removeBookmark',['id'=>$bookmark->id])}}" method="post" enctype="multipart/form-data" >
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input class="btn btn-xs btn-top-delete-xs btn-delete" type="submit" value="x" name="btn_delete" data-toggle="tooltip" title="Delete" id="btnDelete">
                        </form>
                        <div class="col-md-8 col-md-offset-0">
                            <span style="display: inline-block;width: 210px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"><h4>{{$bookmark->listing->property_name}}</h4></span><br>
                            @if($bookmark->listing->status=='unpublished')
                            <span><small><strong class="text-default">not submitted for publishing</strong></small></span><br>
                            @elseif($bookmark->listing->status=='pending')
                            <span><small><strong class="text-info">pending approval</strong></small></span><br>
                            @elseif($bookmark->listing->status=='approved')
                            <span><small><strong class="text-success">approved</strong></small></span><br>
                            @elseif($bookmark->listing->status=='rejected')
                            <span><small><strong class="text-danger">rejected</strong></small></span><br>
                            @elseif($bookmark->listing->status=='suspended')
                            <span><small><strong class="text-danger">suspended</strong></small></span><br>
                            @else
                            <span><small><strong>invalid status</strong></small></span><br>
                            @endif
                            <span><small>Location: <i>{{$bookmark->listing->zoneEntry->name}} ({{$bookmark->listing->zoneEntry->zone->county}})</i></small></span><br>
                            @if($bookmark->listing->listing_type=='single')
                            <span><small>Type: <i>Single-listing property</i></small></span>
                            @elseif($bookmark->listing->listing_type=='multi')
                            <span><small>Type: <i>Multiple-listing property</i></small></span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            @if($bookmark->listing->thumbnail != null)
                            <img class="img-rounded" style="width:125px;height:100px;float:right;" src="/images/listings/{{$bookmark->listing->id}}/thumbnails/{{$bookmark->listing->thumbnail}}" alt="unable to display image">
                            @elseif($bookmark->listing->thumbnail == null)
                            <img class="img-rounded" style="width:125px;height:100px;float:right;" src="/images/listings/vector-house-icon.jpg" alt="unable to display image">
                            @endif
                        </div>
                    </a>
                    @else
                    <a class="card-big-clickable card-block" style="margin:9px; " role="button" href="{{route('admin.manageListingEntry',['listingId'=>$bookmark->listing->id,'entryId'=>$bookmark->listingEntry->id])}}">
                        <form action="{{route('admin.removeBookmark',['id'=>$bookmark->id])}}" method="post" enctype="multipart/form-data" >
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input class="btn btn-xs btn-top-delete-xs btn-delete" type="submit" value="x" name="btn_delete" data-toggle="tooltip" title="Delete" id="btnDelete">
                        </form>
						<div class="col-md-8 col-md-offset-0">
							<span style="display: inline-block;width: 210px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">
								<h4>{{$bookmark->listingEntry->listing_name}}</h4>
							</span><br>
							@if($bookmark->listingEntry->status=='active')
							<span><small><strong class="text-success">active</strong></small></span><br>
							@elseif($bookmark->listingEntry->status=='inactive')
							<span><small><strong class="text-danger">inactive</strong></small></span><br>
							@elseif($bookmark->listingEntry->status=='occupied')
							<span><small><strong class="text-primary">occupied</strong></small></span><br>
							@endif
							@if($bookmark->listingEntry->initial_deposit<=0)
							<span><small>Initial deposit: <strong>Not required</strong></small></span>
							@elseif($bookmark->listingEntry->initial_deposit>0)
							<span><small>Initial deposit: <strong>Required</strong></small></span>
							@endif
						</div>
						<div class="col-md-4">
							@if($bookmark->listingEntry->listingFile()->where('category','thumbnail')->first() != null)
							<img class="img-rounded" style="width:125px;height:100px;float:right;" src="/images/listings/{{$bookmark->listing->id}}/thumbnails/{{$bookmark->listingEntry->listingFile()->where('category','thumbnail')->first()->file_name}}" alt="unable to display image">
							@else
							<img class="img-rounded" style="width:125px;height:100px;float:right;" src="/images/listings/vector-house-icon.jpg" alt="unable to display image">
							@endif
						</div>
					</a>
                    @endif
                @empty
                    <h4 style="text-align:center;">No bookmarks</h4>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('lister_col_left')
    <small>Bookmark Stats</small>
    <div style="border:1px solid lightgrey; padding:16px">
        Total bookmarks: <strong>{{$bookmarks->count()}}</strong>
        <br>Property bookmarks: <strong>{{$bookmarks->where('listing_entry_id',null)->count()}}</strong>
        <br>Listing bookmarks: <strong>{{$bookmarks->where('listing_entry_id','!=',null)->count()}}</strong>
    </div>
@endsection

@section('bottom_scripts')
<script src="{{asset('js/bookmarks.js')}}"></script>
@endsection