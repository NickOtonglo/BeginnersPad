@extends('layouts.base_manage_listing')

@section('title')
<title>Manage Property - {{$listing->property_name}} | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="pull-right">
	<form method="post" action="{{route('admin.addListingBookmark',['listingId'=>$listing->id])}}" enctype="multipart/form-data">
		{{csrf_field()}}
		@if($bookmark != '')
		<input class="btn btn-sm btn-outline-secondary" type="submit" name="btn_bookmark" value="- Remove Bookmark" id="btn_remove_bookmark">
		@else
		<input class="btn btn-sm btn-outline-info" type="submit" name="btn_bookmark" value="+ Add Bookmark">
		@endif
	</form>
</div>
@endsection

@section('action_controls')
@if (Auth::user()->user_type === 3 || Auth::user()->user_type === 2 || Auth::user()->user_type === 1)
<form method="post" action="{{route('admin.performListingAction',['id'=>$listing->id])}}" enctype="multipart/form-data" id="action_form">
    {{csrf_field()}}
	{{method_field('PUT')}}
	<div class="mb-3">
		<div class="input-group mb-3">
			<select class="form-select" id="listing_action" name="listing_action">	
				<option value="" selected>-select action to perform-</option>
				@if(count($entries)>=1)
					@if($listing->status=='pending' || $listing->status=='suspended')
						@forelse($actions->where('action','!=','suspend')->where('action','!=','delete') as $action)
						<option class="text-capitalize" value="{{$action->action}}">{{$action->action}} listing</option>
						@empty
						<option value="" selected>(-no actions available-)</option>
						@endforelse
					@elseif($listing->status=='approved')
						@forelse($actions->where('action','suspend')->where('action','!=','delete') as $action)
						<option class="text-capitalize" value="{{$action->action}}">{{$action->action}} listing</option>
						@empty
						<option value="" selected>(-no actions available-)</option>
						@endforelse
					@elseif($listing->status=='rejected')
						@forelse($actions->where('action','!=','suspend') as $action)
						<option class="text-capitalize" value="{{$action->action}}">{{$action->action}} listing</option>
						@empty
						<option value="" selected>(-no actions available-)</option>
						@endforelse
					@endif
				@endif
			</select>
			<input class="btn btn-lg btn-outline-secondary btn-block" type="button" value="Confirm Action" name="btn_submit" id="btn_confirm">
		</div>
		<div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="modalLabel">Respond to Application</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<label for="action_reason">Give a brief but detailed reason for this action</label>
							<div class="alert alert-danger" id="alert_action_reason" hidden></div>
							<textarea class="form-control" name="action_reason" type="text" id="action_reason"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-outline-primary" id="btn_act">Confirm Action</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

@endif
@endsection

@section('management_script')
<script src="{{asset('js/listings-management-admin.js')}}"></script>
@endsection