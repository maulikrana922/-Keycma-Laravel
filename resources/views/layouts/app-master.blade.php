<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		@include('includes.head')
	</head>
	<body>
		<!-- Header -->
		<div class="header">
			@include('includes.header')
		</div>

		<!-- Right sidebar -->
		<div class="right-sidebar">
			@include('includes.right-sidebar')
		</div>

		<!-- Left sidebar -->
		<div class="left-side-bar">
			@include('includes.left-sidebar')
		</div>

		<div class="mobile-menu-overlay"></div>

		<!-- Main content -->
		<div class="main-container">
			<div class="pd-ltr-20">
				@yield('content')

				<!-- Footer -->
				@include('includes.footer')
			</div>
		</div>

		<!-- Footer -->
		@include('includes.scripts')
	</body>
</html>