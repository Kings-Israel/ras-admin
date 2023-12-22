@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <style>
        #super{
            vertical-align:super;
            font-size: smaller;
        }
        .search-results {
            position: absolute;
            z-index: 99;
            background: #c2c2c2;
            border-radius: 10px;
            width: 200px;
            margin-top: 15px;
            margin-left: -10px;
        }
    </style>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection
@section('content')
    <section class="content home">
        <div class="container-fluid">
            <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header d-flex justify-content-between">
                            <h2><strong>{{ Str::title($page) }}</strong></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title">Invoice Details</h6>
                        </div>
                        <div class="body">

                            <div class="row">
                                <p class="col-md-6"><strong>Payment Status:  </strong> {{$invoice->payment_status ?? 'N/A' }}</p>
                                <p class="col-md-6"><strong>Total Amount:  </strong> {{$invoice->total_amount ?? 'N/A' }}</p>
                                <p class="col-md-6"><strong>Delivery Location Address:  </strong> {{$invoice->delivery_location_address ?? 'N/A' }}</p>
                                <p class="col-md-6"><strong>Requested On:  </strong> {{$invoice->created_at ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title">Order and Products Information</h6>
                        </div>
                        <div class="body col-8">
                           @foreach($orders as $order)
                            <p class="card-text mr-2"><strong> Order Status:</strong>{{ $order->status ?? '' }}</p>
                            <p class="card-text mr-2"><strong>Delivery Status:</strong>{{ $order->delivery_status ?? ''}}</p>
                            <p class="card-text mr-2"><strong>Requested On:</strong>{{ $order->created_at ?? ''}}</p>
                            @endforeach
                        </div>
                        <br/>
                        <div class="body col-8">
                            @foreach ($order->orderItems as $orderItem)
                            <p class="card-text mr-2"><strong>Product Name:</strong> {{$orderItem->product->name ?? '' }}</p>
                            <p class="card-text mr-2"><strong>Product Description:</strong> {{$orderItem->product->description ?? '' }}</p>
                            <p class="card-text mr-2"><strong>Product Category:</strong> {{$orderItem->product->category->name ?? '' }}</p>
                            <p class="card-text mr-2"><strong>Requested Quantity:</strong> {{$orderItem->quantity ?? '' }}</p>
                            <p class="card-text mr-2"><strong>Amount Value:</strong> {{$orderItem->amount ?? '' }}</p>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-title">Product Vendor</h6>
                            </div>
                            <div class="body col-12">
                                @foreach ($order->orderItems as $orderItem)
                                <p class="card-text mr-2"><strong>Name: </strong> {{ $orderItem->product->business->name ?? 'N/A' }}</p>
                                <p class="card-text mr-2"><strong>Country: </strong> {{$orderItem->product->business->country->name ?? 'N/A' }}</p>
                                @endforeach
                            </div>
<<<<<<< HEAD
                        <div class="body">
=======
>>>>>>> c260d165703ea9a534cdbd2ec6e64ad73b229a99
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script> --}}
@endpush
