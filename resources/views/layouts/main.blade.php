<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="shortcut icon" href="{{ $favicon ?? url('assets/images/logo/favicon.png') }}" type="image/x-icon"> -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.jpeg') }}">
    <title>@yield('title') || {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @include('layouts.include')
    @yield('css')
    @yield('E-css')
</head>
<body>
<div id="app">
    @include('layouts.sidebar')
    <div id="main" class='layout-navbar'>
        @include('layouts.topbar')
        <div id="main-content">
            <div class="page-heading">
                @yield('page-title')
            </div>
            @yield('content')
        </div>
    </div>
    <div class="wrapper mt-5">
        <div class="content">
            @include('layouts.footer')
        </div>
    </div>
</div>
@include('layouts.footer_script')
@yield('js')
@yield('script')
@yield('E-js')
@yield('E-script')
</body>
</html>
