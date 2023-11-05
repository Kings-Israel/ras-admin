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
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('financing.requests.update', ['financing_request' => $financing_request, 'status' => 'approve']) }}" class="btn btn-md btn-primary btn-round">Approve</a>
                            <a href="{{ route('financing.requests.update', ['financing_request' => $financing_request, 'status' => 'reject']) }}" class="btn btn-md btn-danger btn-round">Reject</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Invoice</h6>
                    </div>
                    <div class="body">
                        <h5><span class="mr-2">Invoice ID:</span><strong>{{ $financing_request->invoice->invoice_id }}</strong></h5>
                        <h6><span class="mr-2">Number of Orders:</span><strong class="text-danger">{{ $financing_request->invoice->orders->count() }}</strong></h6>
                        <h6><span class="mr-2">Delivery Location:</span><strong class="text-danger">{{ $financing_request->invoice->delivery_location_address }}</strong></h6>
                        <h6><span class="mr-2">Created On:</span><strong class="text-danger">{{ $financing_request->created_at->format('d M Y') }}</strong></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">User</h6>
                        <a href="{{ route('users.show', ['user' => $financing_request->invoice->user]) }}" class="btn btn-primary btn-sm mb-2">View User</a>
                    </div>
                    <div class="body">
                        <h5><span class="mr-2">Name:</span><strong>{{ $financing_request->invoice->user->first_name }} {{ $financing_request->invoice->user->last_name }}</strong></h5>
                        <h5><span class="mr-2">Email:</span><strong>{{ $financing_request->invoice->user->email }}</strong></h5>
                        <h5><span class="mr-2">Phone Number:</span><strong>{{ $financing_request->invoice->user->phone_number }}</strong></h5>
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
                            <th>Price</th>
                            <th>Business</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($financing_request->invoice->orders as $order)
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>USD {{ $item->product->price ? $item->product->price : $item->product->min_price.' - '.$item->product->max_price }}</td>
                                    <td>{{ $item->product->business->name }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary btn-round waves-effect">DETAILS</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
