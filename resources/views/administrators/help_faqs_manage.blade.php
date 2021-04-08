@extends('layouts.base_no_panel')

@section('title')
    <title>Manage FAQs | Beginners Pad</title>
@endsection

@section ('content')
<div class="container">
    <div class="row">
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
        <div class="pull-right">
            <a class="btn btn-mid btn-info" role="button" 
            data-toggle="modal" data-target="#modalCreateEntry">+ Add FAQ Entry</a>
        </div>
        <div class="modal fade" id="modalCreateEntry" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalLabel">New Entry</h4>
                    </div>
                    <form method="post" action="{{route('admin.addHelpFAQ')}}" enctype="multipart/form-data" onsubmit="return validateEntryCreateForm();" id="formEntryCreate">
                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="qn_create">Question *</label>
                                <div class="alert alert-danger" id="alert_qn_create" hidden></div>
                                <input class="form-control" type="text" id="qn_create" name="qn_create">
                            </div>
                            <div class="form-group">
                                <label for="ans_create">Answer *</label>
                                <div class="alert alert-danger" id="alert_ans_create" hidden></div>
                                <textarea class="form-control" type="text" rows="3" step="any" id="ans_create" name="ans_create"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="cat_create">Category *</label>
                                <div class="alert alert-danger" id="alert_cat_create" hidden></div>
                                <input class="form-control" type="text" step="any" id="cat_create" name="cat_create">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input id="btn_create" class="btn btn-primary" value="Save" type="submit" name="btn_create">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalUpdateEntry" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalLabel">Edit Entry</h4>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data"  id="formEntryUpdate" onsubmit="return validateEntryUpdateForm();">
                        <div class="modal-body">
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <div class="form-group">
                                <label for="question">Question *</label>
                                <div class="alert alert-danger" id="alert_qn" hidden></div>
                                <input class="form-control" type="text" id="question" name="question">
                            </div>
                            <div class="form-group">
                                <label for="answer">Answer *</label>
                                <div class="alert alert-danger" id="alert_ans" hidden></div>
                                <textarea class="form-control" type="text" rows="6" step="any" id="answer" name="answer"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="category">Category *</label>
                                <div class="alert alert-danger" id="alert_cat" hidden></div>
                                <input class="form-control" type="text" step="any" id="category" name="category">
                            </div>
                            <div class="form-group">
                                <label for="time">Timestamp</label>
                                <div class="alert alert-danger" id="alert_time" hidden></div>
                                <input class="form-control" type="text" step="any" id="time" name="time" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input id="btn_update" class="btn btn-primary" value="Update" type="submit" name="btn_action">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{route('admin.viewHelpFAQLogs','all')}}" class="list-group-item">FAQ Logs</a>
                <a href="" class="list-group-item">Help Topics</a>
                <a href="{{route('admin.viewHelpCategories')}}" class="list-group-item">Help Categories</a>
            </div>
        </div>
        <div class="col-md-7 col-md-offset-2">
            <div class="row">
                <div class="flex-title" style="text-align:left;">FAQs</div>
                @forelse($entries as $entry)
                <a class="card-big-clickable card-block" style="margin:16px;">
                    <form action="{{route('admin.deleteHelpFAQ',$entry->id)}}" method="post" enctype="multipart/form-data" id="formEntryDelete" onsubmit="return true">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input class="btn btn-sm btn-outline-danger btn-top-delete btn-delete" type="submit" value="x" name="btn_action" data-toggle="tooltip"
                         title="Delete" id="btn_delete">
                    </form>
                    <div role="button" data-toggle="modal" data-target="#modalUpdateEntry" onclick="populateEntryUpdateForm('{{$entry->id}}',this);">
                        <div class="row">
                            <div class="col-md-8"><h4 class="text-capitalize">{{$entry->question}}</h4></div>
                            <row  class="col-md-4">
                                <br><small class="pull-right">{{$entry->created_at}}</small>
                            </row>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 col-md-offset-0" style="margin:2px">
                                <p style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                    {{($entry->answer)}}
                                </p>
                            </div>
                        </div>
                    </div>                    
                </a>
                @empty
                <h4 style="text-align:center;">No entries currently available</h4>
                @endforelse
            </div>
        </div>
        
    </div>
</div>
@endsection

@section ('bottom_scripts')
<script>
    let entriesObj = {!!json_encode($entries)!!};
</script>
<script src="{{asset('js/help-faq-management-admin.js')}}"></script>
@endsection