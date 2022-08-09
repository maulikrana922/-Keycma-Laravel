@extends('layouts.auth-master')

@section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <img src="{{ asset('vendors/images/forgot-password.png') }}" alt="">
        </div>
        <div class="col-md-6">
            <div class="login-box bg-white box-shadow border-radius-10">
                <div class="login-title">
                    <h2 class="text-center text-primary">Reset Password</h2>
                </div>
                <h6 class="mb-20">Enter your new password, confirm and submit</h6>
                @include('layouts.partials.messages')
            {{ Form::open(array('route' => 'reset-password.post', 'method' => 'POST')) }}
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="input-group custom d-block">
                    {{ Form::password(
                        'password',
                        ['class' => 'form-control form-control-lg', 'id' => 'password', 'placeholder' => 'Enter New Password']
                    ) }}
                    <div class="input-group-append custom">
                        <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                    </div>
                    @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="input-group custom d-block">
                    {{ Form::password(
                        'password_confirmation',
                        ['class' => 'form-control form-control-lg', 'id' => 'password_confirmation', 'placeholder' => 'Enter Confirm New Password']
                    ) }}
                    <div class="input-group-append custom">
                        <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="input-group mb-0">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Reset Password</button>
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection