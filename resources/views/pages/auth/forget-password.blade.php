@extends('layouts.auth-master')

@section('content')
	<div class="rivu-form">
		<div class="login-box bg-white box-shadow border-radius-10">
			<div class="login-title">
				<h2 class="text-center text-primary">Forgot Password ?</h2>
			</div>
			@include('layouts.partials.messages')
			{{ Form::open(array('route' => 'forgot-password.post', 'method' => 'POST')) }}
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
				<div class="r-form-btn">
					<a class="btn btn-primary btn-g-code cancel" href="{{ route('login') }}">BACK</a>
					<input class="btn btn-primary btn-g-cod" type="submit" value="Send Password Reset Link"/>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@endsection