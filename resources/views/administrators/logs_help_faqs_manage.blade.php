@extends('layouts.base_admin_tables')

@section('title')
    <title>Logs - FAQ Management | Beginners Pad</title>
@endsection

@section('top_buttons')
<div class="container">
	<div class="pull-right">
        @if($target=='all')
        <a class="btn btn-sm btn-outline-secondary" role="button" href="{{route('admin.viewHelpFAQLogs',['target'=>'me'])}}">My Management History</a>
        @endif
	</div>
</div>
<br>
@endsection

@section ('col_centre')
<div class="table-responsive">
    <h5>Activity History</h5>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">FAQ #</th>
                <th scope="col">Question</th>
                <th id="t_head_admin" scope="col">Admin</th>
                <th scope="col">Action</th>
                <th scope="col">Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr class="row-clickable" role="button" data-bs-toggle="modal" data-bs-target="#modalLog" onclick="populateModal('{{$log->id}}',this);">
                <th id="t_body_id" scope="row">{{$log->id}}</th>
                <td id="t_body_parent">{{$log->entry_id}}</td>
                <td id="t_body_question" style="white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:200px;">{{$log->question}}</td>
                @isset($log->actionBy->name)
                <td id="t_body_admin">{{$log->actionBy->name}}</td>
                @else
                <td id="t_body_admin">deleted [id {{$log->action_by}}]</td>
                @endif
                <td id="t_body_action">{{$log->action}}</td>
                <td id="t_body_time">{{$log->created_at}}</td>
            </tr>
            @empty
            <tr>No history</tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalLog" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">View Log</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <label for="parent" class="text-muted">FAQ #</label>
                    <h4 id="parent" type="text" name="parent">Loading...</h4>
                </div>
                <hr>
                <div>
                    <label for="question" class="text-muted">Question</label>
                    <p id="question" type="text" name="question">Loading...</p>
                </div>
                <hr>
                <div>
                    <label for="answer" class="text-muted">Answer</label>
                    <p id="answer" type="text" name="answer">Loading...</p>
                </div>
                <hr>
                <div>
                    <label for="category" class="text-muted">Category</label>
                    <p id="category" type="text" name="category">Loading...</p>
                </div>
                <hr>
                <div>
                    <label for="action" class="text-muted">Action</label>
                    <p id="action" type="text" name="action">Loading...</p>
                </div>
                <hr>
                <div>
                    <label for="admin" class="text-muted">Action by (Admin)</label>
                    <p id="admin" type="text" name="admin">Loading...</p>
                </div>
                <hr>
                <div>
                    <label for="timestamp" class="text-muted">Timestamp</label>
                    <p id="timestamp" type="text" name="timestamp">Loading...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_scripts')
<script>
    let logsObj = {!!json_encode($logs)!!};
</script>
<script src="{{asset('js/help-faq-management-log-admin.js')}}"></script>
@endsection