@extends('layouts.base_no_panel')

@section('title')
    <title>Add User | Beginners Pad</title>
@endsection

@section('content')

	<section class="flex-sect">
         <div class="container-width">
            <div class="flex-title">Create new user</div>
            <div class="flex-desc">Fill in the required details in the fields below:</div>

            <div class="container">

            	<div class="container-width">
					@if(count($errors)>0)
				        <ul>
				            @foreach($errors->all() as $error)
				            	<li class="alert alert-danger">{{$error}}</li>
				            @endforeach
				        </ul>
				    @endif
				</div>

				<form action="/manage_users/create" method="post" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<label for="name">User name</label>
						<input class="form-control" type="text" name="name">
					</div>

					<div class="form-group">
						<label for="email">Email</label>
						<input class="form-control" type="text" name="email">
					</div>

					<div class="form-group">
						<label for="telephone">Phone Number (+254xxxxxxxxx)</label>
						<input id="telephone" type="number" class="form-control" name="telephone" onfocusout="telephoneValidation(document.getElementById('telephone').value)" required>
						<!-- @if ($errors->has('telephone'))
							<span class="help-block">
								<strong class="text-danger">{{ $errors->first('telephone') }}</strong><br>
							</span>
						@endif -->
					</div>

					@if (Auth::user()->user_type === 2)
						<div class="form-group">
							<label for="user_type">User type</label>
							<select class="form-control" name="user_type">
								<option value="3">Representative</option>
							</select>
						</div>
					@elseif (Auth::user()->user_type === 1)
						<div class="form-group">
							<label for="user_type">User type</label>
							<select class="form-control" name="user_type">
								<option value="3">Representative</option>
								<option value="2">Super Administrator</option>
							</select>
						</div>
					@endif

					<input class="btn btn-primary" type="submit" value="Create"></input>
				</form>

			</div>
            
         </div>
      </section>

@endsection