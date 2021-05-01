@extends('auth.base_auth')

@section('title')
<title>Register | Beginners Pad</title>
@endsection

@section('col_main')
<div class="card">
    <div class="card-header">Register</div>

    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('register') }}" onsubmit="return validateForm();">
            {{ csrf_field() }}

            <div class="mb-3 container-width {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-12 control-label">Full Name</label>
                <div class="alert alert-danger" id="alert_name" hidden></div>
                <div class="col-md-12">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                    <br>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>{{ $errors->first('name') }}</strong>
                    </div>
                    @endif
                </div>
            </div>

            <div class="mb-3 container-width {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-12 control-label">E-Mail Address</label>
                <div class="alert alert-danger" id="alert_email" hidden></div>
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

            <div class="mb-3 container-width {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-12 control-label">Password</label>
                <div class="alert alert-danger" id="alert_password" hidden></div>
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

            <div class="mb-3 container-width ">
                <label for="password_confirmation" class="col-md-12 control-label">Confirm Password</label>
                <div class="alert alert-danger" id="alert_password_confirmation" hidden></div>
                <div class="col-md-12">
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="mb-3 container-width {{ $errors->has('telephone') ? ' has-error' : '' }}">
                <label for="telephone" class="col-md-12 control-label">Phone Number (+254xxxxxxxxx)</label>
                <div class="alert alert-danger" id="alert_phone" hidden></div>
                <div class="col-md-12">
                    <input id="telephone" type="text" class="form-control" name="telephone" required>
                    @if ($errors->has('telephone'))
                    <br>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>{{ $errors->first('telephone') }}</strong>
                    </div>
                    @endif
                </div>
            </div>

            <div class="mb-3 container-width ">
                <label for="user_type" class="col-md-12 control-label">Account Type</label>

                <div class="col-md-12">
                    <select id="user_type" class="form-select" name="user_type">
                        <option value="5">Customer</option>
                        <option value="4">Property Lister</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 container-width ">
                <label for="username" class="col-md-12 control-label">Username (must be unique)</label>
                <div class="alert alert-danger" id="alert_username" hidden></div>
                <input id="username" type="text" class="form-control" name="username" autocomplete="off">
                @if ($errors->has('username'))
                <br>
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>{{ $errors->first('username') }}</strong>
                </div>
                @endif
                </div>
            </div>

            <div class="mb-3 container-width">
                <div class="alert alert-danger" id="alert_terms" hidden></div>
                <div class="form-check" style="max-width: 420px; margin: auto">
                    <input class="form-check-input" type="checkbox" name="terms" id="terms" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexCheckDefault">
                        I agree to the <a class="link-primary" href="#">Terms and Conditions of Beginners Pad</a>
                    </label>
                </div>
            </div>
            <br>
            <div class="mb-3 container-width ">
                <div class="row" style="padding-left: 12px; padding-right: 12px;">
                    <button type="submit" id="btn_submit" class="btn btn-outline-primary">Register</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('bottom_scripts')
<script src="{{asset('js/auth-register.js')}}"></script>
@endsection