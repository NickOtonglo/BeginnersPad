@extends('layouts.base_listing_entry_view')

@section('title')
<title>Manage Listing - {{$entry->listing_name}} | Beginners Pad</title>
@endsection

@section('lister_controls')
@if(Auth::user()->user_type === 4)
<br>
<form method="post" action="{{route('lister.updateListingEntry',['listingId'=>$entry->listing->id,'entryId'=>$entry->id])}}" enctype="multipart/form-data">
    {{csrf_field()}}
    {{method_field('PUT')}}
    @if($entry->status == 'active')
    <input class="btn btn-lg btn-danger btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Make Inactive (hide)" name="btn_submit">
    @elseif($entry->status == 'inactive')
    <input class="btn btn-lg btn-success btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Activate" name="btn_submit">
    @elseif($entry->status == 'occupied')
    <input class="btn btn-lg btn-danger btn-block btn-entry-edit" style="margin-top:5px" type="submit" value="Declare Vacant" name="btn_submit">
    @endif
</form>
<input class="btn btn-lg btn-danger btn-block btn-entry-delete" style="margin-top:5px" type="submit" value="Delete Listing" name="btn_submit" disabled>
@endif
@endsection

@section('entries_scripts')
<script src="{{asset('js/listings.js')}}"></script>
<script src="{{asset('js/listing-entries.js')}}"></script>
@endsection