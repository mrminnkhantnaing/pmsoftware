<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="color-sidebar sidebarcolor2">

<head>
	{{-- Required Meta Tags --}}
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- Favicon --}}
	<link rel="icon" href="{{ asset('images/default/tkd_logo_element.png') }}" type="image/png" />
    {{-- Page Specific Head Scripts --}}
    @yield('page-specific-head-scripts')
	<title>@yield('title')</title>
</head>

<body style="background-color: transparent;">
    @yield('content')

    {{-- Page Specific JS --}}
    @yield('page-specific-js')

</body>

</html>
