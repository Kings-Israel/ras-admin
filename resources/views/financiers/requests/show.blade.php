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
                        @can('update', $financing_request)
                            @if (!$financing_request->invoice->orderFinancing)
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('financing.requests.update', ['financing_request' => $financing_request, 'status' => 'approve']) }}" class="btn btn-md btn-primary btn-round">Approve</a>
                                    <a href="{{ route('financing.requests.update', ['financing_request' => $financing_request, 'status' => 'reject']) }}" class="btn btn-md btn-danger btn-round">Reject</a>
                                </div>
                            @elseif ($financing_request->invoice->orderFinancing)
                                @if ($financing_request->invoice->orderFinancing->second_approval_by != null)
                                    <h6>Invoice has been fully approved</h6>
                                @else
                                    @if ($financing_request->invoice->orderFinancing->first_approval_by == auth()->id())
                                        <h6>You have already acted on this Invoice. (First Approver)</h6>
                                    @else
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('financing.requests.update', ['financing_request' => $financing_request, 'status' => 'approve']) }}" class="btn btn-md btn-primary btn-round">Approve</a>
                                            <a href="{{ route('financing.requests.update', ['financing_request' => $financing_request, 'status' => 'reject']) }}" class="btn btn-md btn-danger btn-round">Reject</a>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        @endcan
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
                        <div class="d-flex">
                            <span class="mr-2">Total Amount:</span>
                            <h6><strong>{{ number_format($financing_request->invoice->calculateTotalAmount()) }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Number of Orders:</span>
                            <h6><strong>{{ $financing_request->invoice->orders->count() }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Delivery Location:</span>
                            <h6><strong>{{ $financing_request->invoice->delivery_location_address }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Created On:</span>
                            <h6><strong>{{ $financing_request->created_at->format('d M Y') }}</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">User</h6>
                        <a href="{{ route('users.show', ['user' => $financing_request->invoice->user]) }}" class="btn btn-primary btn-round btn-sm mb-2">View User</a>
                    </div>
                    <div class="body">
                        <div class="d-flex">
                            <span class="mr-2">Name:</span>
                            <h6><strong>{{ $financing_request->invoice->user->first_name }} {{ $financing_request->invoice->user->last_name }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Email:</span>
                            <h6><strong>{{ $financing_request->invoice->user->email }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Phone Number:</span>
                            <h6><strong>{{ $financing_request->invoice->user->phone_number }}</strong></h6>
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
                                                <a class="dropdown-item" href="#">
                                                    <span>Product Details</span>
                                                </a>
                                                @if ($item->inspectionReport()->exists())
                                                    <a class="dropdown-item" href="#viewInspectionReport_{{ $item->id }}" data-toggle="modal" data-target="#viewInspectionReport_{{ $item->id }}">
                                                        <span>View Inspection Report</span>
                                                    </a>
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
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Company Details --}}
        <div class="card">
            <h6 class="card-title">Company Details</h6>
            @if ($financing_request->company)
                <div class="body">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="d-flex">
                                <span class="mr-2">Name:</span>
                                <h6><strong>{{ $financing_request->company->name }}</strong></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="d-flex">
                                <span class="mr-2">Registration Number:</span>
                                <h6><strong>{{ $financing_request->company->registration_number }}</strong></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="d-flex">
                                <span class="mr-2">Date Started Trading:</span>
                                <h6><strong>{{ $financing_request->company->date_trade_started }}</strong></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="d-flex">
                                <span class="mr-2">Country:</span>
                                <h6><strong>{{ $financing_request->company->country }}</strong></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="d-flex">
                                <span class="mr-2">Country of Incorporation:</span>
                                <h6><strong>{{ $financing_request->company->country_of_incorporation }}</strong></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="d-flex">
                                <span class="mr-2">PIN No:</span>
                                <h6><strong>{{ $financing_request->company->pin_number }}</strong></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="d-flex">
                                <span class="mr-2">Postal Address:</span>
                                <h6><strong>{{ $financing_request->company->postal_address }}</strong></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="d-flex">
                                <span class="mr-2">Postal Code:</span>
                                <h6><strong>{{ $financing_request->company->postal_code }}</strong></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="d-flex">
                                <span class="mr-2">Town/City:</span>
                                <h6><strong>{{ $financing_request->company->city }}</strong></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="d-flex">
                                <span class="mr-2">Tel/Mobile Number:</span>
                                <h6><strong>{{ $financing_request->company->phone_number }}</strong></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="d-flex">
                                <span class="mr-2">Email:</span>
                                <h6><strong>{{ $financing_request->company->email }}</strong></h6>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <h6>Company Details not entered</h6>
            @endif
        </div>
        {{-- Company Documents --}}
        <div class="card">
            <h6 class="card-title">Company Documents</h6>
            @if (count($financing_request->documents) > 0)
                <div class="body">
                    <div class="row">
                        @foreach ($financing_request->documents as $document)
                            <div class="col-sm-12 col-md-6">
                                <h6><strong>{{ $document->document_name }}</strong></h6>
                            </div>
                            <div class="col-sm-12-col-md-6">
                                <a href="{{ $document->document_url }}" class="btn btn-round btn-sm btn-secondary">View Document</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <h6>No Documents Uploaded</h6>
            @endif
        </div>
        {{-- Bankers --}}
        <div class="card">
            <h6 class="card-title">Bankers</h6>
            @if (count($financing_request->bankers) > 0)
                <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="products">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Account Number</th>
                            <th>Period With Bank (YRS)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($financing_request->bankers as $banker)
                            <tr>
                                <td>{{ $banker->bank_name }}</td>
                                <td>{{ $banker->bank_branch }}</td>
                                <td>{{ $banker->account_number }}</td>
                                <td>{{ $banker->period_with_bank }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h5>Bankers information was not entered</h5>
            @endif
        </div>
        {{-- Capital Structure --}}
        <div class="card">
            <h6 class="card-title">Capital Structure</h6>
            @if ($financing_request->capitalStructure)
                <div class="body">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            Authorized Capital:
                        </div>
                        <div class="col-sm-12 col-md-3">
                            {{ $financing_request->capitalStructure->authorized_capital_amount }}
                        </div>
                        <div class="col-sm-12 col-md-3">
                            divided into {{ $financing_request->capitalStructure->authorized_capital_shares }}
                        </div>
                        <div class="col-sm-12 colmd-3">
                            of {{ $financing_request->capitalStructure->authorized_capital_share_value }} each
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            Paid Up Capital:
                        </div>
                        <div class="col-sm-12 col-md-3">
                            {{ $financing_request->capitalStructure->paid_up_capital_amount }}
                        </div>
                        <div class="col-sm-12 col-md-3">
                            divided into {{ $financing_request->capitalStructure->paid_up_capital_shares }}
                        </div>
                        <div class="col-sm-12 colmd-3">
                            of {{ $financing_request->capitalStructure->paid_up_capital_share_value }} each
                        </div>
                    </div>
                </div>
            @else
                <h5>Capital Structure was not uploaded</h5>
            @endif
        </div>
        {{-- Shareholders --}}
        <div class="card">
            <h6 class="card-title">Shareholders/Partners/Proprietors</h6>
            @if (count($financing_request->shareholders) > 0)
                <div class="body">
                    <div class="row">
                        @foreach ($financing_request->shareholders as $shareholder)
                            <div class="col-sm-12 col-md-4">
                                {{ $shareholder->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <h5>Shareholders were not entered</h5>
            @endif
        </div>
        {{-- Key Management --}}
        <div class="card">
            <h6 class="card-title">Key Management</h6>
            @if (count($financing_request->companyManagers) > 0)
                <div class="body">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Duration (YRS)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($financing_request->companyManagers as $manager)
                                <tr>
                                    <td>{{ $manager->name }}</td>
                                    <td>{{ $manager->position }}</td>
                                    <td>{{ $manager->duration }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h5>Management information was not added</h5>
            @endif
        </div>
        {{-- Current Bank Indebtness --}}
        <div class="card">
            <h6 class="card-title">Details of Current Bank Indebtness</h6>
            @if (count($financing_request->bankDebts) > 0)
                <div class="body">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>Bank Name</th>
                                <th>Facility Limits</th>
                                <th>Current Outstanding Amount</th>
                                <th>Reason For Debt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($financing_request->bankDebts as $bank_debt)
                                <tr>
                                    <td>{{ $bank_debt->bank_name }}</td>
                                    <td>{{ $bank_debt->facility_limits }}</td>
                                    <td>{{ $bank_debt->outstanding_amounts }}</td>
                                    <td>{{ $bank_debt->debt_reason }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h5>Details of Current Bank Indebtness not added</h5>
            @endif
        </div>
        {{-- Current Operating Indebtness --}}
        <div class="card">
            <h6 class="card-title">Details of Current Operating Indebtness</h6>
            @if (count($financing_request->operatingDebts) > 0)
                <div class="body">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>Bank Name</th>
                                <th>Facility Limits</th>
                                <th>Current Outstanding Amount</th>
                                <th>Reason For Debt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($financing_request->operatingDebts as $bank_debt)
                                <tr>
                                    <td>{{ $bank_debt->creditor_name }}</td>
                                    <td>{{ $bank_debt->facility_limit }}</td>
                                    <td>{{ $bank_debt->outstanding_amount }}</td>
                                    <td>{{ $bank_debt->debt_reason }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h5>Details of Current Operating Indebtness not added</h5>
            @endif
        </div>
        {{-- Anchor History --}}
        <div class="card">
            <h6 class="card-title">History With Anchor (Customer)</h6>
            @if ($financing_request->anchorHistory)
                <div class="col-12">
                    <span><strong>Transaction Description:</strong></span><br>
                    {{ $financing_request->anchorHistory->transaction_description }}
                </div>
                <br>
                <div class="col-12">
                    <span><strong>Transaction Terms:</strong></span><br>
                    {{ $financing_request->anchorHistory->transaction_terms }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
