<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Real Africa Sources') }}</title>

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
        <link rel="stylesheet" href="{{ asset('assets/plugins/nouislider/nouislider.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}">
        @yield('css')
    </head>
    <body class="theme-black">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img src="{{ asset('assets/images/logo-alt.png') }}" style="object-fit: contain"alt="Alpino"></div>
                <p>Please wait...</p>
            </div>
        </div>
        @include('layouts.inner-nav')
        @include('layouts.nav')
        @yield('content')
    </body>
    <!-- Jquery Core Js -->
    <script src={{ asset('assets/bundles/libscripts.bundle.js') }}></script>
    <script src={{ asset('assets/bundles/vendorscripts.bundle.js') }}></script>
    <script src="{{ asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>

    <script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script>
    {{-- <script src="{{ asset('assets/bundles/doughnut.bundle.js') }}"></script> --}}
    <script src="{{ asset('assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/nouislider/nouislider.js') }}"></script>

    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
    <!-- Lib Scripts Plugin Js -->
    @stack('scripts')
</html>
