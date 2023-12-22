@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
@endsection
@section('content')
    <section class="content home">
        <div class="container-fluid">
            <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>{{ Str::title($page) }}</strong></h2>
                        </div>
                        <div>

                        </div>
                        <br/>
                        <br/>
                        <div class="body">
                            <form action="{{route('product.restocking')}}" method="POST">
                                @csrf
                                @method('POST')
                                <h5>Product Details</h5>
                                <label class="mr-2 ml-2">Product name:</label>
                                <input type="text" class="border-0 text-dark text-lg-center" value="{{$product->name}}" readonly>
                                <label class="mr-2 ml-2">Current Quantity: </label>
                                <input type="text" class="border-0 text-dark text-lg-center"value="{{$current_quantity->quantity ?? 0}}" readonly>
                                <label class="mr-2 ml-2">Unit Of measurement: </label>
                                <input type="text" class="border-0 text-dark text-lg-center" value="{{$product->unit ?? ''}}" readonly>
                                <input type="hidden" name="product_id" value="{{$product->id ?? ''}}" readonly>
                               <br/>
                                <label>Restocking Quantity</label>
                                <input type="number" name="quantity">
                                <x-primary-button type="submit" class="btn btn-md btn-primary btn-round waves-effect">Restock</x-primary-button>
                            </form>
                            <div class="row">
                                <x-primary-button type="button" class=" float-right btn btn-md btn-secondary btn-round waves-effect">back</x-primary-button>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')

@endpush
