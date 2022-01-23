<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="color-sidebar sidebarcolor2">

<head>
	{{-- Required Meta Tags --}}
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- Favicon --}}
	<link rel="icon" href="{{ asset('images/default/tkd_logo_element.png') }}" type="image/png" />
	{{-- Plugins --}}
	<link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
	<link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    {{-- Page Specific Head Scripts --}}
    @yield('page-specific-head-scripts')
	{{-- Loader --}}
	<link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('assets/js/pace.min.js') }}"></script>
	{{-- Bootstrap CSS --}}
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
	{{-- Theme Style CSS --}}
	<link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />

	<title>@yield('title')</title>
</head>

<body>
	{{-- Wrapper --}}
	<div class="wrapper">
		{{-- Sidebar --}}
        @include('inc.sidebar')

        {{-- Header --}}
        @include('inc.header')

		{{-- Page Wrapper --}}
		<div class="page-wrapper">
			<div class="page-content">
                @include('inc.messages')

                @yield('content')
			</div>
		</div>

		{{-- Overlay --}}
		<div class="overlay toggle-icon"></div>

		{{-- Back To Top Button --}}
		  <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>

		{{-- Footer --}}
        @include('inc.footer')
	</div>

	{{-- Start Switcher --}}
	{{-- @include('inc.switcher') --}}

	{{-- Bootstrap JS --}}
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
	{{-- Plugins --}}
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<script src="{{ asset('assets/plugins/chartjs/js/Chart.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
	<script src="{{ asset('assets/js/index.js') }}"></script>

    {{-- Page Specific JS --}}
    @yield('page-specific-js')

	{{-- App JS --}}
	<script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
