@extends('layouts.base_admin_tables')

@section('title')
<title>Help Categories | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="container">
    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{ session()->get('message') }}
        </div>
    @endif
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ $errors->first() }}
        </div>
    @endforeach
	<div class="pull-right btn-group" role="group">
    <a class="btn btn-mid btn-default" role="button" id="btn_logs" href="{{route('admin.viewHelpCategoryLogs',['target'=>NULL])}}">View Logs</a>
        <a class="btn btn-mid btn-info" role="button" id="btn_add_entry">+ Add Category</a>
	</div>
</div>
<br>
@endsection

@section ('col_centre')
<div class="panel panel-default">
    <div class="panel-heading text-capitalize">Help Categories</div>
    <div class="panel-body">
        <div class="post">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Date Added</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="row-clickable" role="button" onclick="populateEntrySubmitForm('{{$category}}',this);">
                        <th id="t_body_id" scope="row">{{$category->id}}</th>
                        <td id="t_body_name">{{$category->name}}</td>
                        <td id="t_body_description" style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">{{$category->description}}</td>
                        <td id="t_body_priority">{{$category->priority}}</td>
                        <td id="t_body_time">{{$category->created_at}}</td>
                    </tr>
                    @empty
                    <tr>No entries</tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalLabel">Add Entry</h4>
                </div>
                <form method="post" action="{{route('admin.performHelpCategoryTask',['item'=>'x '])}}" enctype="multipart/form-data" onsubmit="return validateEntrySubmitForm();" id="entryForm">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name">Title/Name *</label>
                            <div class="alert alert-danger" id="alert_name" hidden></div>
                            <input id="name" class="form-control" type="text" name="name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <div class="alert alert-danger" id="alert_description" hidden></div>
                            <textarea id="description" class="form-control" type="text" rows="3" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="priority">Priority *</label>
                            <div class="alert alert-danger" id="alert_priority" hidden></div>
                            <select class="form-control" id="priority" name="priority">
                                <option value="1">1 (Lowest)</option>
                                <option value="2">2 (Low)</option>
                                <option value="3">3 (Moderate)</option>
                                <option value="4">4 (High)</option>
                                <option value="5">5 (Highest)</option>
                            </select>
                        </div>
                        <div class="form-group" id="div_timestamp" hidden>
                            <label for="timestamp">Date Added</label>
                            <input id="timestamp" class="form-control" type="text" name="timestamp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input class="btn btn-primary hidden" type="submit" value="Create" id="btn_create" name="btn_task">
                        <div class="pull-left">
                            <input class="btn btn-danger hidden" type="submit" value="Delete" id="btn_delete" name="btn_task">
                        </div>
                        <input class="btn btn-primary hidden" type="submit" value="Update" id="btn_update" name="btn_task">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section ('bottom_scripts')
<script src="{{asset('js/help-category-management-admin.js')}}"></script>
@endsection