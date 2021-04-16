@extends('layouts.base_listing_entry_view')

@section('title')
<title>Manage Listing - {{$entry->listing_name}} | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="pull-right">
	<form method="post" action="{{route('admin.addListingEntryBookmark',['listingId'=>$listing->id,'entryId'=>$entry->id])}}" enctype="multipart/form-data">
	{{csrf_field()}}
		@if($bookmark != '')
		<input class="btn btn-sm btn-outline-secondary" type="submit" name="btn_bookmark" value="- Remove Bookmark" id="btn_remove_bookmark">
		@else
		<input class="btn btn-sm btn-outline-primary" type="submit" name="btn_bookmark" value="+ Add Bookmark">
		@endif
	</form>
</div>
@endsection

@section('entries_scripts')
<script src="{{asset('js/listing-entries-management-admin.js')}}"></script>
@endsection