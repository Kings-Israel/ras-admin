<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Real Sources Africa') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:200,400,500,600,1100&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/morrisjs/morris.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css') }}">
        <!-- Custom Css -->
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/multi-select/css/multi-select.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/nouislider/nouislider.min.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}">

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @yield('css')
    </head>
    <body class="theme-black">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img src="{{ asset('assets/images/logo-alt.png') }}" style="object-fit: contain"alt="Real Sources Africa"></div>
                <p>Please wait...</p>
            </div>
        </div>
        @include('layouts.inner-nav')
        @include('layouts.nav')
        @yield('content')
        <!-- Jquery Core Js -->
        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>

        <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>

        <script src="{{ asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>

        <script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script>
        {{-- <script src="{{ asset('assets/bundles/doughnut.bundle.js') }}"></script> --}}
        <script src="{{ asset('assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script>
        <script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
        {{-- <script src="{{ asset('assets/plugins/nouislider/nouislider.js') }}"></script> --}}
        <script src="{{ asset('assets/bundles/flotchartsscripts.bundle.js') }}"></script>
        {{-- <script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script> --}}

        {{-- <script src="https://maps.google.com/maps/api/js?v=3&key=AIzaSyCisnVFSnc5QVfU2Jm2W3oRLqMDrKwOEoM"></script> <!-- Google Maps API Js -->
        <script src="{{ asset('assets/plugins/gmaps/gmaps.js') }}"></script> <!-- GMaps PLugin Js -->
        <script src="{{ asset('assets/js/pages/maps/google.js') }}"></script> --}}
        <!-- Lib Scripts Plugin Js -->
        @stack('scripts')
    </body>
</html>
