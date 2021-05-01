@extends('layouts.base_no_panel')

@section('title')
    <title>Manage FAQs | Beginners Pad</title>
@endsection

@section ('content')
<div class="container-width">
    <div class="row" style="margin-bottom: 16px;">
        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!</strong> {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endforeach
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-sm btn-outline-primary" role="button" data-bs-toggle="modal" data-bs-target="#modalCreateEntry">+ Add FAQ Entry</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3" style="margin-bottom: 16px;">
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
                         data-placement="auto" title="Delete" id="btn_delete">
                    </form>
                    <div role="button" data-bs-toggle="modal" data-bs-target="#modalUpdateEntry" onclick="populateEntryUpdateForm('{{$entry->id}}',this);">
                        <div class="row">
                            <div class="col-md-8">
                                <br><h5>{{$entry->question}}</h5>
                            </div>
                            <div class="col-md-4">
                                <br><small>{{$entry->created_at}}</small>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 col-md-offset-0" style="margin:2px">
                                <p class="bp-text-line-clamp">
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

<div class="modal fade" id="modalCreateEntry" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">New Entry</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{route('admin.addHelpFAQ')}}" enctype="multipart/form-data" onsubmit="return validateEntryCreateForm();" id="formEntryCreate">
                <div class="modal-body">
                    {{csrf_field()}}
                    <div class="mb-3">
                        <label for="qn_create">Question *</label>
                        <div class="alert alert-danger" id="alert_qn_create" hidden></div>
                        <input class="form-control" type="text" id="qn_create" name="qn_create">
                    </div>
                    <div class="mb-3">
                        <label for="ans_create">Answer *</label>
                        <div class="alert alert-danger" id="alert_ans_create" hidden></div>
                        <textarea class="form-control" type="text" rows="3" step="any" id="ans_create" name="ans_create"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="cat_create">Category *</label>
                        <div class="alert alert-danger" id="alert_cat_create" hidden></div>
                        <input class="form-control" type="text" step="any" id="cat_create" name="cat_create">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <input id="btn_create" class="btn btn-outline-primary" value="Save" type="submit" name="btn_create">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalUpdateEntry" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Edit Entry</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data"  id="formEntryUpdate" onsubmit="return validateEntryUpdateForm();">
                <div class="modal-body">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="mb-3">
                        <label for="question">Question *</label>
                        <div class="alert alert-danger" id="alert_qn" hidden></div>
                        <input class="form-control" type="text" id="question" name="question">
                    </div>
                    <div class="mb-3">
                        <label for="answer">Answer *</label>
                        <div class="alert alert-danger" id="alert_ans" hidden></div>
                        <textarea class="form-control" type="text" rows="6" step="any" id="answer" name="answer"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category">Category *</label>
                        <div class="alert alert-danger" id="alert_cat" hidden></div>
                        <input class="form-control" type="text" step="any" id="category" name="category">
                    </div>
                    <div class="mb-3">
                        <label for="time">Timestamp</label>
                        <div class="alert alert-danger" id="alert_time" hidden></div>
                        <input class="form-control" type="text" step="any" id="time" name="time" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <input id="btn_update" class="btn btn-outline-primary" value="Update" type="submit" name="btn_action">
                </div>
            </form>
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