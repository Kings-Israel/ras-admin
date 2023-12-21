@extends('layouts.app')
@section('css')
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<style>
    body{
        margin-top:40px;
    }

    .stepwizard-step p {
        margin-top: 10px;
    }

    .stepwizard-row {
        display: table-row;
    }
    .select2 {
        display: block;
        padding: 5px;
        background-color: rgba(255, 255, 255, 0.8); /* Adjust opacity as needed */
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }

    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-order: 0;

    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }
</style>
@endsection
@section('content')
    <section class="content home">
        <div class="container-fluid">
            <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
{{--                            <h2><strong>{{ Str::title($page) }}</strong></h2>--}}
                            <h2><strong>Create Product</strong></h2>
                        </div>
                        <div class="body">
{{--                            <livewire:product.step-manager :'$step'=2/>--}}
                            <livewire:product.step-manager :step="2" :wire:key="'stepManagerKey'" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <!-- Include any additional scripts you may need -->
{{--        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        @livewireScripts
{{--        <script>--}}
{{--            document.addEventListener('livewire:load', function () {--}}
{{--                Livewire.on('goToNextStep', function () {--}}
{{--                    console.log('goToNextStep event triggered');--}}
{{--                    Livewire.emit('refreshLivewireComponents');--}}
{{--                });--}}

{{--                Livewire.on('goToPreviousStep', function () {--}}
{{--                    console.log('goToPreviousStep event triggered');--}}
{{--                    Livewire.emit('refreshLivewireComponents');--}}
{{--                });--}}
{{--            });--}}
{{--        </script>--}}
    @endpush
@endsection


