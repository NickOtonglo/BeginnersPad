@extends('auth.base_auth')

@section('title')
<title>Forgot Password | Beginners Pad</title>
@endsection

@section('col_main')
<div class="card">
    <div class="card-header">Reset Password</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <div class="mb-3 container-width {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-12 control-label">E-Mail Address</label>
                
                <div class="col-md-12">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                    <br>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                    @endif
                </div>
            </div>
            <br>
            <div class="mb-3 container-width ">
                <div class="row" style="padding-left: 12px; padding-right: 12px;">
                    <button type="submit" class="btn btn-outline-primary">Send Password Reset Link</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
