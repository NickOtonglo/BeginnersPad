@extends('auth.base_auth')

@section('title')
<title>Reset Password | Beginners Pad</title>
@endsection

@section('col_main')
<div class="card">
    <div class="card-header">Reset Password</div>
    
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}
            
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-3 container-width {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-12 control-label">E-Mail Address</label>
                
                <div class="col-md-12">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                    <br>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="mb-3 container-width {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-12 control-label">Password</label>
                
                <div class="col-md-12">
                    <input id="password" type="password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                    <br>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="mb-3 container-width {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm" class="col-md-12 control-label">Confirm Password</label>
                
                <div class="col-md-12">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    @if ($errors->has('password_confirmation'))
                    <br>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </div>
                    @endif
                </div>
            </div>
            <br>
            <div class="mb-3 container-width ">
                <div class="row" style="padding-left: 12px; padding-right: 12px;">
                    <button type="submit" class="btn btn-outline-primary">Reset Password</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
