@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <style>
        .actions-dropdown {
            position: absolute;
            z-index: 99;
            background: #c2c2c2;
            border-radius: 10px;
            width: 210px;
            margin-top: 28px;
            margin-left: -15px;
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
                        <h6 class="card-title">Order Details</h6>
                        <a href="{{ route('orders.show', ['order' => $warehouse_storage_request->orderItem->order]) }}" class="btn btn-sm btn-secondary mb-2">View Order</a>
                    </div>
                    <div class="body">
                        <h6><span class="mr-2">Order ID:</span><strong>{{ $warehouse_storage_request->orderItem->order->order_id }}</strong></h6>
                        <h6><span class="mr-2">Business:</span><strong>{{ $warehouse_storage_request->orderItem->order->business->name }}</strong></h6>
                        <h6><span class="mr-2">Business Location(Country):</span><strong>{{ $warehouse_storage_request->orderItem->order->business->country->name }}</strong></h6>
                        @if ($warehouse_storage_request->orderItem->order->business->city)
                            <h6><span class="mr-2">Business Location(City):</span><strong>{{ $warehouse_storage_request->orderItem->order->business->city->name }}</strong></h6>
                        @endif
                        <h6><span class="mr-2">Delivery Location:</span><strong>{{ $warehouse_storage_request->orderItem->order->invoice->delivery_location_address }}</strong></h6>
                        <h6><span class="mr-2">Quantity:</span><strong>{{ $warehouse_storage_request->orderItem->quantity }}</strong></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Buyer</h6>
                        <a href="{{ route('users.show', ['user' => $warehouse_storage_request->orderItem->order->user]) }}" class="btn btn-primary btn-sm mb-2">View User</a>
                    </div>
                    <div class="body">
                        <h6><span class="mr-2">Name:</span><strong>{{ $warehouse_storage_request->orderItem->order->user->first_name }} {{ $warehouse_storage_request->orderItem->order->user->last_name }}</strong></h6>
                        <h6><span class="mr-2">Email:</span><strong>{{ $warehouse_storage_request->orderItem->order->user->email }}</strong></h6>
                        <h6><span class="mr-2">Phone Number:</span><strong>{{ $warehouse_storage_request->orderItem->order->user->phone_number }}</strong></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Product</h6>
                        <a href="#" class="btn btn-primary btn-sm mb-2">View Product</a>
                    </div>
                    <div class="body">
                        <h6><span class="mr-2">Name:</span><strong>{{ $warehouse_storage_request->orderItem->product->name }}</strong></h6>
                        <h6><span class="mr-2">Category:</span><strong>{{ $warehouse_storage_request->orderItem->product->category->name }}</strong></h6>
                        <h6><span class="mr-2">Color:</span><strong>{{ $warehouse_storage_request->orderItem->product->color }}</strong></h6>
                    </div>
                </div>
            </div>
            @can('update Warehouse')
                <div class="col-md-6 col-sm-12">
                    <form action="{{ route('insurance.requests.cost.update', ['warehouse_storage_request' => $warehouse_storage_request]) }}" method="post">
                        @csrf
                        <div class="card">
                            <div class="body">
                                <h6>Enter/Update Storage Cost</h6>
                                <input type="number" min="0" class="form-control" placeholder="Enter Cost of Storage" name="storage_cost" autocomplete="off" />
                                <button type="submit" class="btn btn-primary btn-round waves-effect">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endcan
        </div>
        <div class="card">
            <div class="body">
                <div class="row">
                    <div class="col-6">
                        <h6><span>Warehouse Storage Request Status: </span><strong>{{ Str::title($warehouse_storage_request->status) }}</strong></h6>
                    </div>
                    @if ($warehouse_storage_request->cost)
                        <div class="col-6">
                            <h6><span>Warehouse Storage Request Cost: </span><strong>{{ number_format($warehouse_storage_request->cost) }}</strong></h6>
                        </div>
                    @endif
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
    <script>
        $('#products').DataTable({
            paging: true,
            ordering: true,
        })
    </script>
@endpush
