<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Real Africa Sources Admin') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">

        <!-- Custom Css -->
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        @yield('css')
    </head>
    <body class="theme-black">
        <div class="authentication">
            <div class="container">
                <div class="col-md-12 content-center">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="company_detail">
                                <h4 class="logo"><img src="assets/images/logo.svg" alt=""> Real African Sources</h4>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12 offset-lg-1">
                            @yield('auth')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <!-- Jquery Core Js -->
    <script src={{ asset('assets/bundles/libscripts.bundle.js') }}></script>
    <script src={{ asset('assets/bundles/vendorscripts.bundle.js') }}></script>
    <!-- Lib Scripts Plugin Js -->
    @stack('scripts')
</html>
