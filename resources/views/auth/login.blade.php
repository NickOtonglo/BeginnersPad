@extends('auth.base_auth')

@section('title')
<title>Login | Beginners Pad</title>
@endsection

@section('col_main')
<div class="card">
    <div class="card-header">Login</div>
    
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            
            <div class="container-width">
                @if(session()->has('error_login'))
                <div class="alert alert-danger alert-dismissible">
                    <strong>Error!</strong> {{ session()->get('error_login') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
            
            <div class="container-width mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                <br>
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
                @endif
            </div>
            
            <div class="container-width mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
                @if ($errors->has('password'))
                <br>
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
                @endif
            </div>
            
            <div class="mb-3 container-width">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexCheckDefault">Remember Me</label>
                </div>
            </div>
            <br>
            <div class="mb-3 container-width">
                <div class="row" style="padding-left: 12px; padding-right: 12px;">
                    <button type="submit" class="btn btn-outline-primary">Login</button>
                </div>
            </div>
            
            <div class="mb-3 container-width">
                <div class="row" style="padding-left: 12px; padding-right: 12px;">
                    <a class="link-primary" style="width: inherit; margin: auto" href="{{ route('password.request') }}">Forgot Your Password?</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
