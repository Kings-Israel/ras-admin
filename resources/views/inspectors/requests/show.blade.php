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
                        <a href="#uploadInspectionDocuments" data-toggle="modal" data-target="#uploadInspectionDocuments" class="btn btn-primary btn-sm btn-round">Upload Reports</a>
                        @can('create inspection report')
                            <div class="modal fade" id="uploadInspectionDocuments" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="title" id="uploadInspectionDocumentsLabel">Add Inspection Report Documents for each product</h4>
                                        </div>
                                        <form action="{{ route('inspection.requests.reports.store', ['inspection_request' => $inspection_request]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <div class="col-sm-6">
                                                        <label for="role_name">Inspection Cost</label>
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
                                        </form>
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
                        <a href="{{ route('orders.show', ['order' => $inspection_request->orderItem->order]) }}" class="btn btn-sm btn-secondary mb-2 btn-round">View Order</a>
                    </div>
                    <div class="body">
                        <h6><span class="mr-2">Order ID:</span><strong>{{ $inspection_request->orderItem->order->order_id }}</strong></h6>
                        <h6><span class="mr-2">Business:</span><strong>{{ $inspection_request->orderItem->order->business->name }}</strong></h6>
                        <h6><span class="mr-2">Business Location(Country):</span><strong>{{ $inspection_request->orderItem->order->business->country->name }}</strong></h6>
                        @if ($inspection_request->orderItem->order->business->city)
                            <h6><span class="mr-2">Business Location(City):</span><strong>{{ $inspection_request->orderItem->order->business->city->name }}</strong></h6>
                        @endif
                        <h6><span class="mr-2">Delivery Location:</span><strong>{{ $inspection_request->orderItem->order->invoice->delivery_location_address }}</strong></h6>
                        <h6><span class="mr-2">Quantity:</span><strong>{{ $inspection_request->orderItem->quantity }}</strong></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Buyer</h6>
                        @role('admin')
                            <a href="{{ route('users.show', ['user' => $inspection_request->orderItem->order->user]) }}" class="btn btn-primary btn-sm mb-2 btn-round">View User</a>
                        @endrole
                    </div>
                    <div class="body">
                        <h6><span class="mr-2">Name:</span><strong>{{ $inspection_request->orderItem->order->user->first_name }} {{ $inspection_request->orderItem->order->user->last_name }}</strong></h6>
                        <h6><span class="mr-2">Email:</span><strong>{{ $inspection_request->orderItem->order->user->email }}</strong></h6>
                        <h6><span class="mr-2">Phone Number:</span><strong>{{ $inspection_request->orderItem->order->user->phone_number }}</strong></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Product</h6>
                        <a href="#" class="btn btn-secondary btn-sm mb-2 btn-round">View Product</a>
                    </div>
                    <div class="body">
                        <h6><span class="mr-2">Name:</span><strong>{{ $inspection_request->orderItem->product->name }}</strong></h6>
                        <h6><span class="mr-2">Category:</span><strong>{{ $inspection_request->orderItem->product->category->name }}</strong></h6>
                        <h6><span class="mr-2">Color:</span><strong>{{ $inspection_request->orderItem->product->color }}</strong></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Vendor/Seller</h6>
                        @role('admin')
                            <a href="{{ route('vendors.show', ['business' => $inspection_request->orderItem->product->business]) }}" class="btn btn-primary btn-sm mb-2 btn-round">View Vendor</a>
                        @endrole
                    </div>
                    <div class="body">
                        <h6><span class="mr-2">Name:</span><strong>{{ $inspection_request->orderItem->product->business->name }}</strong></h6>
                        <h6><span class="mr-2">Email:</span><strong>{{ $inspection_request->orderItem->product->business->user->email }}</strong></h6>
                        <h6><span class="mr-2">Phone Number:</span><strong>{{ $inspection_request->orderItem->product->business->user->phone_number }}</strong></h6>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="col-12">
                                <h6><span>Inspection Request Status: </span><strong>{{ Str::title($inspection_request->status) }}</strong></h6>
                            </div>
                            <div class="col-12 row">
                                @if ($inspection_request->cost)
                                    <div class="col-12">
                                        <span>Inspection Request Cost: </span>
                                        <h6>
                                            <strong>{{ number_format($inspection_request->cost) }}</strong>
                                        </h6>
                                    </div>
                                @endif
                                @if ($inspection_request->cost_description)
                                    <div class="col-6">
                                        <span>Inspection Request Cost Description: </span><br>
                                        <span>
                                            <strong>{{ $inspection_request->cost_description }}</strong>
                                        </span>
                                    </div>
                                @endif
                                @if ($inspection_request->cost_description_file)
                                    <div class="col-6">
                                        <span>Inspection Request Pro-forma: </span>
                                        <h6>
                                            <a href="{{ $inspection_request->cost_description_file }}" class="btn btn-sm btn-primary btn-round">View Pro-forma</a>
                                        </h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @can('update inspection request')
                <div class="col-md-12 col-sm-12">
                    <form action="{{ route('inspection.requests.cost.update', ['inspection_request' => $inspection_request]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="body">
                                <h6>Enter/Update Inspection Cost</h6>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="cost">Enter Inspection Cost</label>
                                            <input type="number" min="0" class="form-control" placeholder="Enter Cost of Inspection" name="inspection_cost" autocomplete="off" />
                                        </div>
                                        <div class="form-group">
                                            <label for="cost_description_file">Upload Pro-forma</label>
                                            <input type="file" accept=".pdf" name="cost_description_file" class="form-control" id="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <textarea name="cost_description" id="" rows="6" class="form-control" placeholder="Enter Cost Description"></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-round waves-effect">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endcan
        </div>
        {{-- <div class="card">
            <div class="body">
                @can('create inspection report')
                    <div class="modal fade" id="uploadInspectionDocuments" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="title" id="uploadInspectionDocumentsLabel">Add Inspection Report Documents for each product</h4>
                                </div>
                                <form action="{{ route('inspection.requests.reports.store', ['inspection_request' => $inspection_request]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row clearfix">
                                            <div class="col-sm-6">
                                                <label for="role_name">Inspection Cost</label>
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
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        </div> --}}
        {{-- <div class="card">
            <h6 class="card-title">Order Products</h6>
            <div class="body">
                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="products">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Warehouse</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inspection_request->order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->product->category->name }}</td>
                                <td>{{ $item->product->brand }}</td>
                                <td>{{ $item->product->price ? $item->product->price : $item->product->min_price.' - '.$item->product->max_price }}</td>
                                <td>{{ $item->product->warehouse ? $item->product->warehouse->name : '' }}</td>
                                <td>
                                    <div class="btn-group" x-data="{ open: false }">
                                        <button class="mr-2 btn btn-primary btn-sm dropdown-toggle btn-round" type="button"
                                            x-on:click="open = ! open">
                                            <i data-feather="eye"></i>
                                            Action
                                        </button>
                                        <div
                                            x-cloak
                                            x-show="open"
                                            x-transition
                                            @click.away="open = false"
                                            @keydown.escape.window = "open = false"
                                            class="actions-dropdown"
                                        >
                                            @can('update inspection report')
                                                <a class="dropdown-item" href="#updateInspectionReport_{{ $item->id }}" data-toggle="modal" data-target="#updateInspectionReport_{{ $item->id }}">
                                                    <span>Upload Inspection Report</span>
                                                </a>
                                            @endcan
                                            @if ($item->inspectionReport()->exists())
                                                @can('view inspection report')
                                                    <a class="dropdown-item" href="#viewInspectionReport_{{ $item->id }}" data-toggle="modal" data-target="#viewInspectionReport_{{ $item->id }}">
                                                        <span>View Report</span>
                                                    </a>
                                                @endcan
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @can('update inspection report')
                                <div class="modal fade" id="updateInspectionReport_{{ $item->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="updateInspectionDocumentsLabel">Add Inspection Report Documents for {{ $item->product->name }}</h4>
                                            </div>
                                            <form action="{{ route('inspection.requests.reports.store', ['inspection_request' => $inspection_request]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row clearfix">
                                                        <div class="col-sm-6">
                                                            <label for="role_name">{{ $item->product->name }}</label>
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control" placeholder="Name" name="order_item[{{ $item->id }}]" value="{{ $item->id }}" required autocomplete="off" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="file" accept=".pdf" name="order_item_report[{{ $item->id }}]" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary btn-round waves-effect">UPLOAD</button>
                                                    <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                            @can('view inspection report')
                                @if ($item->inspectionReport()->exists())
                                    <div class="modal fade" id="viewInspectionReport_{{ $item->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title" id="uploadInspectionDocumentsLabel">{{ $item->product->name }} Inspection Reprt</h4>
                                                </div>
                                                <iframe src="{{ $item->inspectionReport->report_file }}" class="w-[100%]" style="height: 600px"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endcan
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}
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
