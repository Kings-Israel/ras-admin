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

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Buyer</h6>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
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
                                <div class="d-flex">
                                    <span class="mr-2">Gender:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->user->metaData->gender }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Marital Status:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->user->metaData->marital_status }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Nationality:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->user->metaData->nationality }}</strong></h6>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="d-flex">
                                    <span class="mr-2">Postal Address:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->user->metaData->postal_address }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Postal Code:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->user->metaData->postal_code }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">City:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->user->metaData->city }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Residential Address:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->user->metaData->residential_address }}</strong></h6>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="d-flex">
                                    <span class="mr-2">Next of Kin Name:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->user->metaData->next_of_kin_name }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Next of Kin Email:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->user->metaData->next_of_kin_email }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Next of Kin Phone Number:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->user->metaData->next_of_kin_phone_number }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Next of Kin Relationship:</span>
                                    <h6><strong></strong></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">LEGAL ENTITY, CORPORATE OR SME CUSTOMER DETAILS</h6>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="d-flex">
                                    <span class="mr-2">Trade Name:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->trade_name }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Registered Name:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->registered_name }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Registration Number:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->registration_number }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Country of Incorporation:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->country_of_incorporation }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Parent Company Country:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->country_of_parent_company }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Email:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->email }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Phone Number:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->phone_number }}</strong></h6>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex">
                                    <span class="mr-2">Postal Address:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->postal_code }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Postal Code:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->postal_code }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">City:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->city }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Physical Address:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->physical_location }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Nature of Business:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->nature_of_business }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Sector:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->first()->sector }}</strong></h6>
                                </div>
                            </div>
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
    <script>
        $('#products').DataTable({
            paging: true,
            ordering: true,
        })
    </script>
@endpush
