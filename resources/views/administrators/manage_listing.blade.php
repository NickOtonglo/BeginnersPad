@extends('layouts.base_view_listing')

@section('title')
    <title>Manage Reviews | Beginners Pad</title>
@endsection

@section('upper_buttons')
	@if (Auth::user()->user_type === 3 || Auth::user()->user_type === 2 || Auth::user()->user_type === 1)
		<div class="pull-xs-right">
			<a class="btn btn-mid btn-info" href="{{route('admin.manageReviews',$listing->id)}}" role="button">
				Manage Reviews
			</a>
		</div>
	@endif
@endsection

@section('action_buttons')
	<form action="/manage_listings/all/{{$listing->id}}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		@if (Auth::user()->user_type === 3 || Auth::user()->user_type === 2 || Auth::user()->user_type === 1)
			<div class="container-width" style="border:1px dashed grey; padding:16px; margin-bottom:25px;text-align:center;">
				@if($listing->status == "approved")
					Status: <strong style="color: green; ">{{$listing->status}}</strong>
				@elseif($listing->status == "rejected")
					Status: <strong style="color: red; ">{{$listing->status}}</strong>
				@else
					Status: <strong>{{$listing->status}}</strong>
				@endif
			</div>
			@if ($listing->status == "rejected" || $listing->status == "pending")
				<div class="flex-sect">
					<input class="btn btn-lg btn-info btn-block" type="submit" value="Approve Application" name="btn_submit"></input>
					@if ($listing->status == "approved" || $listing->status == "pending")
						<input class="btn btn-lg btn-danger btn-block" type="submit" value="Reject Application" name="btn_submit"></input>
					@endif
				</div>
			@endif
		@endif
		@if (Auth::user()->user_type === 3 || Auth::user()->user_type === 2 || Auth::user()->user_type === 1)
			@if ($adminBookmark != null)
				<input class="btn btn-lg btn-primary btn-block" type="submit" value="Remove Bookmark" name="btn_submit"></input>
			@else
				<input class="btn btn-lg btn-primary btn-block" type="submit" value="Bookmark" name="btn_submit"></input>
			@endif
			@if ($listing->status == "approved")
				<input class="btn btn-lg btn-info btn-block" type="submit" value="Suspend" name="btn_submit"></input>
			@elseif($listing->status == "suspended")
				<input class="btn btn-lg btn-info btn-block" type="submit" value="Unsuspend" name="btn_submit"></input>
			@endif
			<input class="btn btn-lg btn-danger btn-block" type="submit" value="Delete" name="btn_submit"></input>
		@endif
	</form>
@endsection