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
                        <a href="{{ route('vendors.show', ['business' => $order->business]) }}" class="btn btn-sm btn-secondary mb-2">View Vendor</a>
                    </div>
                    <div class="body">
                        <h5><span class="mr-2">Name:</span><strong>{{ $order->business->name }}</strong></h5>
                        <h5><span class="mr-2">Country:</span><strong>{{ $order->business->country->name }}</strong></h5>
                        @if ($order->business->city)
                            <h5><span class="mr-2">City:</span><strong>{{ $order->business->city->name }}</strong></h5>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">User</h6>
                        <a href="{{ route('users.show', ['user' => $order->user]) }}" class="btn btn-primary btn-sm mb-2">View User</a>
                    </div>
                    <div class="body">
                        <h5><span class="mr-2">Name:</span><strong>{{ $order->user->first_name }} {{ $order->user->last_name }}</strong></h5>
                        <h5><span class="mr-2">Email:</span><strong>{{ $order->user->email }}</strong></h5>
                        <h5><span class="mr-2">Phone Number:</span><strong>{{ $order->user->phone_number }}</strong></h5>
                    </div>
                </div>
            </div>
        </div>
        @if ($order->invoice->financingRequest)
            <div class="card">
                <div class="body">
                    <h6><span>Financing Request Status: </span><strong>{{ Str::title($order->invoice->financingRequest->status) }}</strong></h6>
                </div>
            </div>
        @endif
        <div class="card">
            <h6 class="card-title">Products</h6>
            <div class="body">
                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="products">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Warehouse</th>
                            <th>Added On</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->product->price ? $item->product->price : $item->product->min_price.' - '.$item->product->max_price }}</td>
                                <td>{{ $item->product->warehouse }}</td>
                                <td>{{ $item->product->created_at->format('d M Y H:i A') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary btn-round waves-effect">DETAILS</a>
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
