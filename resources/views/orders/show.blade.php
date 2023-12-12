@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
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
                        <h6 class="card-title">Business Details</h6>
                        <a href="{{ route('vendors.show', ['business' => $order->business]) }}" class="btn btn-sm btn-round btn-secondary mb-2">View Vendor</a>
                    </div>
                    <div class="body">
                        <div class="d-flex">
                            <span class="mr-2">Name:</span>
                            <h6><strong>{{ $order->business->name }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Country:</span>
                            <h6><strong>{{ $order->business->country->name }}</strong></h6>
                        </div>
                        @if ($order->business->city)
                            <div class="d-flex">
                                <span class="mr-2">City:</span>
                                <h6><strong>{{ $order->business->city->name }}</strong></h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">User</h6>
                        <a href="{{ route('users.show', ['user' => $order->user]) }}" class="btn btn-primary btn-sm btn-round mb-2">View User</a>
                    </div>
                    <div class="body">
                        <div class="d-flex">
                            <span class="mr-2">Name:</span>
                            <h6><strong>{{ $order->user->first_name }} {{ $order->user->last_name }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Email:</span>
                            <h6><strong>{{ $order->user->email }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Phone Number:</span>
                            <h6><strong>{{ $order->user->phone_number }}</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if ($order->invoice->financingRequest)
                @can('view', $order->invoice->financingRequest)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="body">
                                <div class="d-flex">
                                    <span>Financing Request Status: </span>
                                    <h6><strong>{{ Str::title($order->invoice->financingRequest->status) }}</strong></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            @endif
            <div class="col-md-6">
                <div class="card">
                    <div class="body">
                        <div class="d-flex">
                            <span class="mr-2">Payment Status: </span>
                            <h6><strong>{{ Str::title($order->invoice->payment_status) }}</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <h6 class="card-title">Products</h6>
            <div class="body">
                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="products">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Warehouse</th>
                            <th>Order Quantity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->order->warehouse->warehouse ? $item->order->warehouse->warehouse->name : '' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary btn-round waves-effect">Details</a>
                                    @if ($item->productReleaseRequest && $item->productReleaseRequest->status == 'pending')
                                        @can('update', $item->productReleaseRequest)
                                            <a class="btn btn-sm btn-round btn-secondary" href="#release-product-{{ $item->id }}" data-toggle="modal" data-target="#release-product-{{ $item->id }}">Release Product</a>
                                            <div class="modal fade" id="release-product-{{ $item->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-md" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('warehouses.orders.product.release', ['release_product_request' => $item->productReleaseRequest]) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="order_id" value="{{ $item->order->id }}">
                                                            <div class="modal-body">
                                                                <div class="">
                                                                    <label for="role_name">Select Driver</label>
                                                                    <select class="form-control show-tick" name="driver_id" style="width: 50% !important">
                                                                        @foreach ($drivers as $driver)
                                                                            <option value="{{ $driver->id }}">{{ $driver->first_name }} {{ $driver->last_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary btn-round waves-effect">Submit</button>
                                                                <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
