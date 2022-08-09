@extends('layouts.auth-master')

@section('content')
	<div class="rivu-form">
		<div class="login-box bg-white box-shadow border-radius-10">
			<div class="login-title">
				<h2 class="text-center text-primary">Register</h2>
			</div>
			@include('layouts.partials.messages')
			{{ Form::open(array('route' => 'register.post', 'method' => 'POST')) }}
				<div class="input-group custom d-block">
					{{ Form::text( 
						'firstname', 
						old( 'firstname') , 
						['class' => 'form-control form-control-lg', 'id' => 'firstname', 'placeholder' => 'Enter First Name']
					) }}
					@if ($errors->has('firstname'))
						<span class="text-danger text-left">{{ $errors->first('firstname') }}</span>
					@endif
				</div>
				<div class="input-group custom d-block">
					{{ Form::text( 
						'lastname', 
						old( 'lastname') , 
						['class' => 'form-control form-control-lg', 'id' => 'lastname', 'placeholder' => 'Enter Last Name']
					) }}
					@if ($errors->has('lastname'))
						<span class="text-danger text-left">{{ $errors->first('lastname') }}</span>
					@endif
				</div>
				<div class="input-group custom d-block">
					{{ Form::text( 
						'username', 
						old( 'username') , 
						['class' => 'form-control form-control-lg', 'id' => 'username', 'placeholder' => 'Enter Username/Email Address']
					) }}
					@if ($errors->has('username'))
						<span class="text-danger text-left">{{ $errors->first('username') }}</span>
					@endif
				</div>
				<div class="input-group custom d-block">
					{{ Form::email( 
						'email', 
						old( 'email') , 
						['class' => 'form-control form-control-lg', 'id' => 'email', 'placeholder' => 'Enter Email Address']
					) }}
					@if ($errors->has('email'))
						<span class="text-danger text-left">{{ $errors->first('email') }}</span>
					@endif
				</div>
				<div class="input-group custom d-block">
					{{ Form::password(
						'password',
						['class' => 'form-control form-control-lg', 'id' => 'password', 'placeholder' => 'Enter Password']
					) }}
					<div class="input-group-addon">
						<i class="fa fa-eye" aria-hidden="true"></i>
					</div>
					@if ($errors->has('password'))
						<span class="text-danger text-left">{{ $errors->first('password') }}</span>
					@endif
				</div>
				<div class="input-group custom d-block">
					{{ Form::password(
						'password_confirmation',
						['class' => 'form-control form-control-lg', 'id' => 'password_confirmation', 'placeholder' => 'Enter Confirm Password']
					) }}
					<div class="input-group-addon">
						<i class="fa fa-eye" aria-hidden="true"></i>
					</div>
					@if ($errors->has('password_confirmation'))
						<span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
					@endif
				</div>
				<div class="row pb-20">
					<div class="col-12">
						<div class="forgot-password"><a href="{{ route('forgot-password') }}">Forgot Password</a></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="input-group mb-0">
							<button class="btn btn-primary btn-lg btn-block" type="submit">Register</button>
						</div>
						<div class="r-here text-right">Already have account ? <a href="{{ route('login') }}">Login here</a></div>
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@endsection