<!doctype html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title>KeyCMA | Auth</title>

		<!-- Site favicon -->
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendors/images/apple-touch-icon.png') }}">
		<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendors/images/favicon-32x32.png') }}">
		<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendors/images/favicon-16x16.png') }}">

		<!-- Mobile Specific Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<!-- Google Font -->
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/rivu.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/responsive.css') }}" />
	</head>
	<body class="login-page">
		<div class="{{$authClasses['class_1']}}">
			<div class="logo-form">
				<a href="{{ route('home') }}">
					<img src="{{ asset('src/images/rivu-logo.png') }}" class="img-fluid" alt="logo" />
				</a>
			</div>
			<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
				<div class="container r-container">
					@yield('content')
				</div>
			</div>
			<div class="bottom-form">
				<p>Powered By Rivu<br>
				<span>&#169</span> 2021 All Rights Reserved</p>
			</div>
		</div>

		<!-- Scripts -->
		<script src="{{ asset('vendors/scripts/core.js') }}"></script>
		<script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
		<script src="{{ asset('vendors/scripts/process.js') }}"></script>
		<script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>
	</body>
</html>