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
            <div class="col-12">
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
                                <div class="d-flex">
                                    <span class="mr-2">Income Tax No:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerDetails->income_tax_pin_number }}</strong></h6>
                                </div>
                                @php($file_exists = explode('.', $order_request->insuranceRequestBuyerDetails->income_tax_pin_file))
                                @if (end($file_exists) == 'pdf')
                                    <a href="{{ $order_request->insuranceRequestBuyerDetails->income_tax_pin_file }}" target="_blank" class="btn btn-sm btn-secondary btn-round">
                                        View PIN Certificate
                                    </a>
                                @endif
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
                                <hr>
                                <div class="d-flex">
                                    <span class="mr-2">Is Employed:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerDetails->is_employed ? 'Yes' : 'No' }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Is Self Employed:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerDetails->is_self_employed ? 'Yes' : 'No' }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Current Employer:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerDetails->employer_state }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Occupation:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerDetails->occupation }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Sector:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerDetails->occupation_sector }}</strong></h6>
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
                                    <h6><strong>{{ $order_request->orderItem->order->user->metaData->next_of_kin_relationship }}</strong></h6>
                                </div>
                            </div>
                            @if ($order_request->insuranceRequestBuyerDetails->wealth_sources && count($order_request->insuranceRequestBuyerDetails->wealth_sources) > 0)
                                <div class="col-md-6 col-sm-12">
                                    <span class="mr-2">Sources in Wealth</span>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($order_request->insuranceRequestBuyerDetails->wealth_sources as $wealth_source)
                                            @if ($loop->last)
                                                <h6>{{ $wealth_source }}</h6>
                                            @else
                                                <h6 class="mr-2">{{ $wealth_source.',' }}</h6>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($order_request->insuranceRequestBuyerDetails->income_sources && count($order_request->insuranceRequestBuyerDetails->income_sources) > 0)
                                <div class="col--sm-12 col-md-6">
                                    <span class="mr-2">Sources in Income</span>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($order_request->insuranceRequestBuyerDetails->income_sources as $income_source)
                                            @if ($loop->last)
                                                <h6>{{ $income_source }}</h6>
                                            @else
                                                <h6 class="mr-2">{{ $income_source.', ' }}</h6>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Legal Entity, Corporate or SME Customer Details</h6>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="d-flex">
                                    <span class="mr-2">Trade Name:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->trade_name }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Registered Name:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->registered_name }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Registration Number:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->registration_number }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Country of Incorporation:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->country_of_incorporation }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Parent Company Country:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->country_of_parent_company }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Email:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->email }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Phone Number:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->phone_number }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Income Tax No:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->income_tax_pin }}</strong></h6>
                                </div>
                                @php($file_exists = explode('.', $order_request->insuranceRequestBuyerCompanyDetails->income_tax_document))
                                @if (end($file_exists) == 'pdf')
                                    <a href="{{ $order_request->insuranceRequestBuyerCompanyDetails->income_tax_document }}" target="_blank" class="btn btn-sm btn-secondary btn-round">
                                        View PIN Certificate
                                    </a>
                                @endif
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex">
                                    <span class="mr-2">Postal Address:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->postal_code }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Postal Code:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->postal_code }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">City:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->city }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Physical Address:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->physical_location }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Nature of Business:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->nature_of_business }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Sector:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestBuyerCompanyDetails->sector }}</strong></h6>
                                </div>
                            </div>
                            @if ($order_request->insuranceRequestBuyerCompanyDetails->sources_of_wealth && count($order_request->insuranceRequestBuyerCompanyDetails->sources_of_wealth) > 0)
                                <div class="col-md-6 col-sm-12">
                                    <span class="mr-2">Sources in Wealth</span>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($order_request->insuranceRequestBuyerCompanyDetails->sources_of_wealth as $wealth_source)
                                            @if ($loop->last)
                                                <h6>{{ $wealth_source }}</h6>
                                            @else
                                                <h6 class="mr-2">{{ $wealth_source.',' }}</h6>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($order_request->insuranceRequestBuyerCompanyDetails->sources_of_income && count($order_request->insuranceRequestBuyerCompanyDetails->sources_of_income) > 0)
                                <div class="col-md-6 col-sm-12">
                                    <span class="mr-2">Sources in Income</span>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($order_request->insuranceRequestBuyerCompanyDetails->sources_of_income as $income_source)
                                            @if ($loop->last)
                                                <h6>{{ $income_source }}</h6>
                                            @else
                                                <h6 class="mr-2">{{ $income_source.', ' }}</h6>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Proposal Details</h6>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="d-flex">
                                    <span class="mr-2">Period of Insurance:</span>
                                    <h6 class="mr-2">From: <strong>{{ Carbon\Carbon::parse($order_request->insuranceRequestProposalDetails->period_from)->format('d M Y') }}</strong></h6>
                                    <h6>- To: <strong>{{ Carbon\Carbon::parse($order_request->insuranceRequestProposalDetails->period_end)->format('d M Y') }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Mode of Conveyance:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->mode_of_conveyance }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Territorial Limits:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->territorial_limits }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Packaging:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->packaging }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Will Use Hired Vehicles:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->use_hired_vehicles ? 'Yes' : 'No' }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Details of Hired Vehicles:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->hired_vehicles_details }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Transporting Wines and Spirits:</span>
                                    @if (in_array('Wines and Spirits', $order_request->insuranceRequestProposalDetails->transported_products))
                                        <h6><strong>Yes</strong></h6>
                                    @else
                                        <h6><strong>No</strong></h6>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Transporting Fragile Goods:</span>
                                    @if (in_array('Fragile Goods', $order_request->insuranceRequestProposalDetails->transported_products))
                                        <h6><strong>Yes</strong></h6>
                                    @else
                                        <h6><strong>No</strong></h6>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Transporting Explosive or Hazardous goods:</span>
                                    @if (in_array('Explosive and Hazardous Goods', $order_request->insuranceRequestProposalDetails->transported_products))
                                        <h6><strong>Yes</strong></h6>
                                    @else
                                        <h6><strong>No</strong></h6>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex">
                                    <span class="mr-2">Details of Safety of goods during transit:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->goods_safety_details }}</strong></h6>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <span class="mr-2">Vehicle Safety Features:</span>
                                    @foreach ($order_request->insuranceRequestProposalDetails->vehicle_features as $item)
                                        @if ($loop->last)
                                            <h6><strong>{{ $item }}</strong></h6>
                                        @else
                                            <h6 class="mr-2"><strong>{{ $item.',' }}</strong></h6>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="">
                                    <span class="mr-2">Limit of Liability:</span><br>
                                    <span>In respect to any one consignement:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->liability_limit_one_consignment }}</strong></h6>
                                    <span>In respect to any one period of insurance:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->liability_limit_period_of_insurance }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Annual your Estimated Annual Carry:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->liability_limit_estimated_annual_carry }}</strong></h6>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <h6 class="card-title">Vehicles that require insurance</h6>
                                </div>
                                <table class="table table-hover dataTable js-exportable table-dark" id="vehicles">
                                    <thead>
                                        <tr>
                                            <th>Make and Description</th>
                                            <th>Reg Number</th>
                                            <th>Carrying Capacity</th>
                                            <th>Sum Insured</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_request->insuranceRequestProposalVehicleDetails->where('type', 'Vehicle') as $vehicle)
                                            <tr>
                                                <td>{{ $vehicle->description }}</td>
                                                <td>{{ $vehicle->registration_number }}</td>
                                                <td>{{ $vehicle->carrying_capacity }}</td>
                                                <td>{{ $vehicle->sum_insured }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <h6 class="card-title">Trailers that require insurance</h6>
                                </div>
                                <table class="table table-hover dataTable js-exportable table-dark" id="trailers">
                                    <thead>
                                        <tr>
                                            <th>Make and Description</th>
                                            <th>Reg Number</th>
                                            <th>Carrying Capacity</th>
                                            <th>Sum Insured</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_request->insuranceRequestProposalVehicleDetails->where('type', 'Trailer') as $vehicle)
                                            <tr>
                                                <td>{{ $vehicle->description }}</td>
                                                <td>{{ $vehicle->registration_number }}</td>
                                                <td>{{ $vehicle->carrying_capacity }}</td>
                                                <td>{{ $vehicle->sum_insured }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Insurace Loss History</h6>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="d-flex">
                                    <span class="mr-2">Has had similar insurance:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->had_previous_insurance ? 'Yes' : 'No' }}</strong></h6>
                                </div>
                                <span class="mr-2">Previous Insurer Details:</span>
                                <div class="d-flex">
                                    <span class="mr-2">Insurer:</span>
                                    <h6 class="mr-3"><strong>{{ $order_request->insuranceRequestProposalDetails->previous_insurer['Insurer'] }}</strong></h6>
                                    <span class="mr-2">Policy Number:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->previous_insurer['Policy Number'] }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Precautions Engaged:</span>
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->current_precautions }}</strong></h6>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <span class="mr-2">Insurance Company has:</span>
                                <div class="d-flex">
                                    <span class="mr-2">Cancelled your Policy:</span>
                                    @if (in_array('Cancelled Policy', $order_request->insuranceRequestProposalDetails->previous_insurance_data))
                                        <h6><strong>Yes</strong></h6>
                                    @else
                                        <h6><strong>No</strong></h6>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Declined to insurer:</span>
                                    @if (in_array('Insurance Declined', $order_request->insuranceRequestProposalDetails->previous_insurance_data))
                                        <h6><strong>Yes</strong></h6>
                                    @else
                                        <h6><strong>No</strong></h6>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Declined to renew your policy:</span>
                                    @if (in_array('Declined Policy Renewal', $order_request->insuranceRequestProposalDetails->previous_insurance_data))
                                        <h6><strong>Yes</strong></h6>
                                    @else
                                        <h6><strong>No</strong></h6>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Imposed any special claims:</span>
                                    @if (in_array('Special Terms Imposed', $order_request->insuranceRequestProposalDetails->previous_insurance_data))
                                        <h6><strong>Yes</strong></h6>
                                    @else
                                        <h6><strong>No</strong></h6>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Declined any claim:</span>
                                    @if (in_array('Denied Claim', $order_request->insuranceRequestProposalDetails->previous_insurance_data))
                                        <h6><strong>Yes</strong></h6>
                                    @else
                                        <h6><strong>No</strong></h6>
                                    @endif
                                </div>
                                <span class="mr-2">Previous Insurance Details:</span>
                                <div class="d-flex">
                                    <h6><strong>{{ $order_request->insuranceRequestProposalDetails->previous_insurance_details }}</strong></h6>
                                </div>
                            </div>
                            @if (count($order_request->insuranceRequestBuyerInuranceLossHistories) > 0)
                                <div class="col-12 mt-4">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="card-title">Previous Losses</h6>
                                    </div>
                                    <table class="table table-hover dataTable js-exportable table-dark" id="trailers">
                                        <thead>
                                            <tr>
                                                <th>Year</th>
                                                <th>Cause of Loss</th>
                                                <th>Detials</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order_request->insuranceRequestBuyerInuranceLossHistories as $history)
                                                <tr>
                                                    <td>{{ $history->year }}</td>
                                                    <td>{{ $history->cause_of_loss }}</td>
                                                    <td>{{ $history->description }}</td>
                                                    <td>{{ $history->amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
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
