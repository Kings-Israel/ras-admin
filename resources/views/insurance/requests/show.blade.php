@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chatapp.css') }}">
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
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('insurance.requests.buyer.details', ['order_request' => $order_request]) }}" class="btn btn-sm btn-round btn-secondary">View Buyer Insurance Proposal Details</a>
                            <a href="#uploadInsuranceDocuments" data-toggle="modal" data-target="#uploadInsuranceDocuments" class="btn btn-primary btn-sm btn-round">Upload Reports</a>
                        </div>
                        @can('view insurance report')
                            <div class="modal fade" id="uploadInsuranceDocuments" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="title" id="uploadInsuranceDocumentsLabel">Add Insurance Report Documents</h4>
                                        </div>
                                        {{-- <form action="{{ route('inspection.requests.reports.store', ['order_request' => $order_request]) }}" method="POST" enctype="multipart/form-data">
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
                        <a href="{{ route('orders.show', ['order' => $order_request->orderItem->order]) }}" class="btn btn-sm btn-secondary mb-2 btn-round">View Order</a>
                    </div>
                    <div class="body">
                        <div class="d-flex">
                            <span class="mr-2">Order ID:</span><h6><strong>{{ $order_request->orderItem->order->order_id }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Business:</span>
                            <h6><strong>{{ $order_request->orderItem->order->business->name }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Business Location(Country):</span>
                            <h6><strong>{{ $order_request->orderItem->order->business->country->name }}</strong></h6>
                        </div>
                        @if ($order_request->orderItem->order->business->city)
                            <div class="d-flex">
                                <span class="mr-2">Business Location(City):</span>
                                <h6><strong>{{ $order_request->orderItem->order->business->city->name }}</strong></h6>
                            </div>
                        @endif
                        <div class="d-flex">
                            <span class="mr-2">Delivery Location:</span>
                            <h6><strong>{{ $order_request->orderItem->order->invoice->delivery_location_address }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Quantity:</span>
                            <h6><strong>{{ $order_request->orderItem->quantity }}</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Buyer</h6>
                        @role('admin')
                            <a href="{{ route('users.show', ['user' => $order_request->orderItem->order->user]) }}" class="btn btn-primary btn-sm mb-2 btn-round">View User</a>
                        @endrole
                    </div>
                    <div class="body">
                        <div class="d-flex">
                            <span class="mr-2">Name:</span>
                            <h6><strong>{{ $order_request->orderItem->order->user->first_name }} {{ $order_request->orderItem->order->user->last_name }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Email:</span>
                            <h6><strong>{{ $order_request->orderItem->order->user->email }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Phone Number:</span>
                            <h6><strong>{{ $order_request->orderItem->order->user->phone_number }}</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Product</h6>
                    </div>
                    <div class="body">
                        <div class="d-flex">
                            <span class="mr-2">Name:</span>
                            <h6><strong>{{ $order_request->orderItem->product->name }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Category:</span>
                            <h6><strong>{{ $order_request->orderItem->product->category->name }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Color:</span>
                            <h6><strong>{{ $order_request->orderItem->product->color }}</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Vendor/Seller</h6>
                        @role('admin')
                            <a href="{{ route('vendors.show', ['business' => $order_request->orderItem->product->business]) }}" class="btn btn-primary btn-sm mb-2 btn-round">View Vendor</a>
                        @endrole
                    </div>
                    <div class="body">
                        <div class="d-flex">
                            <span class="mr-2">Name:</span>
                            <h6><strong>{{ $order_request->orderItem->product->business->name }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Email:</span>
                            <h6><strong>{{ $order_request->orderItem->product->business->user->email }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Phone Number:</span>
                            <h6><strong>{{ $order_request->orderItem->product->business->user->phone_number }}</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="col-12">
                                <h6><span>Insurance Request Status: </span><strong>{{ Str::title($order_request->status) }}</strong></h6>
                            </div>
                            <div class="col-12 row">
                                @if ($order_request->cost)
                                    <div class="col-12">
                                        <span>Insurance Request Cost: </span>
                                        <h6>
                                            <strong>{{ number_format($order_request->cost) }}</strong>
                                        </h6>
                                    </div>
                                @endif
                                @if ($order_request->cost_description)
                                    <div class="col-6">
                                        <span>Insurance Request Cost Description: </span><br>
                                        <span>
                                            <strong>{{ $order_request->cost_description }}</strong>
                                        </span>
                                    </div>
                                @endif
                                @if ($order_request->hasCostDescriptionFile())
                                    <div class="col-6">
                                        <span>Insurance Request Pro-forma: </span>
                                        <h6>
                                            <a href="{{ $order_request->cost_description_file }}" class="btn btn-sm btn-primary btn-round">View Pro-forma</a>
                                        </h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @can('update insurance request')
                <div class="col-md-5 col-sm-12">
                    <form action="{{ route('order.request.update', ['order_request' => $order_request]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="body">
                                <h6>Enter/Update Insurance Cost</h6>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="cost">Enter Insurance Cost</label>
                                            <input type="number" min="0" class="form-control" placeholder="Enter Cost of Insurance" name="cost" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="cost_description_file">Upload Pro-forma</label>
                                            <input type="file" accept=".pdf" name="cost_description_file" class="form-control" id="" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="cost_description_file">Enter Cost Description</label>
                                            <textarea name="cost_description" id="" rows="6" class="form-control" placeholder="Enter Cost Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-round waves-effect">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-7 col-sm-12">
                    <div class="card">
                        <div class="body overflowhidden" id="app">
                            <order-chat-component
                                email={{ $order_request->requesteable->email }}
                                type='App\Models\InsuranceCompany'
                                sender={{ $order_request->requesteable->id }}
                                conversation={{ $conversation_id }}
                            ></order-chat-component>
                        </div>
                    </div>
                </div>
            @endcan
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
