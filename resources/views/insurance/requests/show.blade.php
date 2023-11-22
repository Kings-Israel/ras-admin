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
                        <a href="#uploadInsuranceDocuments" data-toggle="modal" data-target="#uploadInsuranceDocuments" class="btn btn-primary btn-sm btn-round">Upload Reports</a>
                        @can('create insurance report')
                            <div class="modal fade" id="uploadInsuranceDocuments" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="title" id="uploadInsuranceDocumentsLabel">Add Insurance Report Documents</h4>
                                        </div>
                                        {{-- <form action="{{ route('inspection.requests.reports.store', ['insurance_request' => $insurance_request]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <div class="col-sm-6">
                                                        <label for="role_name">Insurance Cost</label>
                                                        <div class="form-group">
                                                            <input type="number" min="0" class="form-control" placeholder="Enter Cost of Inspection" name="inspection_code" autocomplete="off" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary btn-round waves-effect">UPLOAD</button>
                                                <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                            </div>
                                        </form> --}}
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Order Details</h6>
                        <a href="{{ route('orders.show', ['order' => $insurance_request->orderItem->order]) }}" class="btn btn-sm btn-secondary mb-2">View Order</a>
                    </div>
                    <div class="body">
                        <h6><span class="mr-2">Order ID:</span><strong>{{ $insurance_request->orderItem->order->order_id }}</strong></h6>
                        <h6><span class="mr-2">Business:</span><strong>{{ $insurance_request->orderItem->order->business->name }}</strong></h6>
                        <h6><span class="mr-2">Business Location(Country):</span><strong>{{ $insurance_request->orderItem->order->business->country->name }}</strong></h6>
                        @if ($insurance_request->orderItem->order->business->city)
                            <h6><span class="mr-2">Business Location(City):</span><strong>{{ $insurance_request->orderItem->order->business->city->name }}</strong></h6>
                        @endif
                        <h6><span class="mr-2">Delivery Location:</span><strong>{{ $insurance_request->orderItem->order->invoice->delivery_location_address }}</strong></h6>
                        <h6><span class="mr-2">Quantity:</span><strong>{{ $insurance_request->orderItem->quantity }}</strong></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Buyer</h6>
                        <a href="{{ route('users.show', ['user' => $insurance_request->orderItem->order->user]) }}" class="btn btn-primary btn-sm mb-2">View User</a>
                    </div>
                    <div class="body">
                        <h6><span class="mr-2">Name:</span><strong>{{ $insurance_request->orderItem->order->user->first_name }} {{ $insurance_request->orderItem->order->user->last_name }}</strong></h6>
                        <h6><span class="mr-2">Email:</span><strong>{{ $insurance_request->orderItem->order->user->email }}</strong></h6>
                        <h6><span class="mr-2">Phone Number:</span><strong>{{ $insurance_request->orderItem->order->user->phone_number }}</strong></h6>
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
                        <h6><span class="mr-2">Name:</span><strong>{{ $insurance_request->orderItem->product->name }}</strong></h6>
                        <h6><span class="mr-2">Category:</span><strong>{{ $insurance_request->orderItem->product->category->name }}</strong></h6>
                        <h6><span class="mr-2">Color:</span><strong>{{ $insurance_request->orderItem->product->color }}</strong></h6>
                    </div>
                </div>
            </div>
            @can('update insurance request')
                <div class="col-md-6 col-sm-12">
                    <form action="{{ route('insurance.requests.cost.update', ['insurance_request' => $insurance_request]) }}" method="post">
                        @csrf
                        <div class="card">
                            <div class="body">
                                <h6>Enter/Update Insurance Cost</h6>
                                <input type="number" min="0" class="form-control" placeholder="Enter Cost of Insurance" name="insurance_cost" autocomplete="off" />
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
                        <h6><span>Inspection Request Status: </span><strong>{{ Str::title($insurance_request->status) }}</strong></h6>
                    </div>
                    @if ($insurance_request->cost)
                        <div class="col-6">
                            <h6><span>Insurance Request Cost: </span><strong>{{ number_format($insurance_request->cost) }}</strong></h6>
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
