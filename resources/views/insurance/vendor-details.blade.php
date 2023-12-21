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
                        <h6 class="card-title">Vendor</h6>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="d-flex">
                                    <span class="mr-2">Name:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->business->name }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Email:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->business->contact_email }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Phone Number:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->business->contact_phone_number }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Registration Number:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->business->metaData->registration_number }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">PIN Number:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->business->metaData->pin_number }}</strong></h6>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="d-flex">
                                    <span class="mr-2">Postal Address:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->business->metaData->postal_address }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Postal Code:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->business->metaData->postal_code }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">City:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->business->city ? $order_request->orderItem->order->business->city->name : '' }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Residential Address:</span>
                                    <h6><strong>{{ $order_request->orderItem->order->business->metaData->physical_location }}</strong></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Subsidiaries to be Insured</h6>
                    </div>
                    <div class="body">
                        <table class="table table-hover dataTable js-exportable table-dark" id="vehicles">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_request->businessSubsidiaries as $subsidiary)
                                    <tr>
                                        <td>{{ $subsidiary->name }}</td>
                                        <td>{{ $subsidiary->address }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Information on the Business</h6>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="d-flex">
                                    <span class="mr-2">General Description:</span>
                                    <h6><strong>{{ $order_request->businessInformation->general_information }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Number of Employees:</span>
                                    <h6><strong>{{ $order_request->businessInformation->number_of_employees }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Goods to be Insured:</span>
                                    <h6><strong>{{ $order_request->businessInformation->goods_to_insure }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Normal Payment Terms:</span>
                                    <h6><strong>{{ $order_request->businessInformation->normal_payment_terms }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Maximum Payment Terms:</span>
                                    <h6><strong>{{ $order_request->businessInformation->maximum_payment_terms }}</strong></h6>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex">
                                    <span class="mr-2">Requires Pre-delivery cover:</span>
                                    <h6><strong>{{ $order_request->businessInformation->requires_pre_delivery_cover ? 'Yes' : 'No' }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Pre credit risk details:</span>
                                    <h6><strong>{{ $order_request->businessInformation->pre_credit_risk_details }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Manufactures the goods:</span>
                                    <h6><strong>{{ $order_request->businessInformation->manufactures_goods ? 'Yes' : 'No' }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Manufacturing Details:</span>
                                    <h6><strong>{{ $order_request->businessInformation->manufacturing_details }}</strong></h6>
                                </div>
                                <div class="">
                                    <span class="mr-2">Details of any Security, Guarantees, non-recourse financing and credit insurance in place:</span>
                                    <h6><strong>{{ $order_request->businessInformation->in_place_security_details }}</strong></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Information on Sales</h6>
                    </div>
                    <div class="body">
                        <div class="d-flex">
                            <span class="mr-2">Estimated Current Year Sales:</span>
                            <h6><strong>{{ $order_request->businessSales->estimated_year_sales }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Seasonal Sales:</span>
                            <h6><strong>{{ $order_request->businessSales->seasonal_sales ? 'Yes' : 'No' }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Seasonal Sales Details:</span>
                            <h6><strong>{{ $order_request->businessSales->seasonal_sales_details }}</strong></h6>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title">Bad Debts</h6>
                        </div>
                        <table class="table table-hover dataTable js-exportable table-dark">
                            <thead>
                                <tr>
                                    <th>Period (Last Year to)</th>
                                    <th>Sales</th>
                                    <th>Total Bad Debts</th>
                                    <th>Largest Bad Debt</th>
                                    <th>No. of bad debts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_request->businessSalesBadDebts as $debt)
                                    <tr>
                                        <td>{{ $debt->period }}</td>
                                        <td>{{ $debt->sales }}</td>
                                        <td>{{ $debt->total_bad_debts }}</td>
                                        <td>{{ $debt->largest_bad_debt }}</td>
                                        <td>{{ $debt->bad_debts_number }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title">Largest Bad Debts</h6>
                        </div>
                        <table class="table table-hover dataTable js-exportable table-dark">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Name of Buyer</th>
                                    <th>Country</th>
                                    <th>Registration Number</th>
                                    <th>Amount of Loss</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_request->businessSalesLargeBadDebts as $debt)
                                    <tr>
                                        <td>{{ $debt->year }}</td>
                                        <td>{{ $debt->buyer_name }}</td>
                                        <td>{{ $debt->country }}</td>
                                        <td>{{ $debt->registration_number }}</td>
                                        <td>{{ $debt->loss_amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Information on Securities</h6>
                    </div>
                    <div class="body">
                        <div class="d-flex">
                            <span class="mr-2">Contracts your customers allow you to be the principle entitled to take recovery action:</span>
                            <h6><strong>{{ $order_request->businessSecurity->contract_allow_recovery_action ? 'Yes' : 'No' }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">If no, Explanation:</span>
                            <h6><strong>{{ $order_request->businessSecurity->recovery_action_details }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">Standard terms and conditions contain and “All Monies” retention and title clause?:</span>
                            <h6><strong>{{ $order_request->businessSecurity->terms_contain_monies_retention_clause ? 'Yes' : 'No' }}</strong></h6>
                        </div>
                        <div class="d-flex">
                            <span class="mr-2">If no, Explanation:</span>
                            <h6><strong>{{ $order_request->businessSecurity->retention_clause_details }}</strong></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Information on Credit Management</h6>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="d-flex">
                                    <span class="mr-2">Has separate credit management department:</span>
                                    <h6><strong>{{ $order_request->businessCreditManagement->separate_credit_management_dept ? 'Yes' : 'No' }}</strong></h6>
                                </div>
                                <div class="">
                                    <span class="mr-2">Person in company responsible for credit management:</span>
                                    <h6 class="mr-2">Name: <strong>{{ $order_request->businessCreditManagement->person_responsible_name }}</strong></h6>
                                    <h6>Position: <strong>{{ $order_request->businessCreditManagement->person_responsible_position }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Asses customer credit worthiness?:</span>
                                    <h6><strong>{{ $order_request->businessCreditManagement->asses_customer_creditworthiness ? 'Yes' : 'No' }}</strong></h6>
                                </div>
                                <div class="">
                                    <span class="mr-2">Methods used in assessment:</span>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($order_request->businessCreditManagement->methods_of_assessment as $method)
                                            @if ($loop->last)
                                                <h6><strong>{{ $method }}</strong></h6>
                                            @else
                                                <h6 class="mr-2"><strong>{{ $method.',' }}</strong></h6>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Assessment Agencies:</span>
                                    <h6><strong>{{ $order_request->businessCreditManagement->assessing_agencies }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Credit Scores Buyers:</span>
                                    <h6><strong>{{ $order_request->businessCreditManagement->credit_score_buyers ? 'Yes' : 'No' }}</strong></h6>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="d-flex">
                                    <span class="mr-2">Credit Information Update Frequency:</span>
                                    <h6><strong>{{ $order_request->businessCreditManagement->credit_information_update_frequency }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Currently has credit insurance policy:</span>
                                    <h6><strong>{{ $order_request->businessCreditManagement->has_credit_insurance_policy ? 'Yes' : 'No' }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Current credit insurance policy details:</span>
                                    <h6><strong>{{ $order_request->businessCreditManagement->credit_insurance_policy_details }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Has been refused a policy or had a policy voided:</span>
                                    <h6><strong>{{ $order_request->businessCreditManagement->has_credit_insurance_policy_voided ? 'Yes' : 'No' }}</strong></h6>
                                </div>
                                <div class="d-flex">
                                    <span class="mr-2">Voided Policy Details:</span>
                                    <h6><strong>{{ $order_request->businessCreditManagement->voided_insurance_policy_details }}</strong></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Additional Information</h6>
                    </div>
                    <div class="body">
                        <div class="card-title">Sales Information</div>
                        <table class="table table-hover dataTable js-exportable table-dark">
                            <thead>
                                <tr>
                                    <th>Country</th>
                                    <th>Sales in Past 12 Months</th>
                                    <th>Projected Sales (nex 12 months)</th>
                                    <th>Terms of Payment</th>
                                    <th>Country Limit Required</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_request->businessSalesInformation as $info)
                                    <tr>
                                        <td>{{ $info->country }}</td>
                                        <td>{{ $info->sales_in_twelve_months }}</td>
                                        <td>{{ $info->projected_sales_in_twelve_months }}</td>
                                        <td>{{ $info->terms_of_payment }}</td>
                                        <td>{{ $info->country_limit_required }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="card-title">Credit Limit Requirement</div>
                        <table class="table table-hover dataTable js-exportable table-dark">
                            <thead>
                                <tr>
                                    <th>Buyer Details</th>
                                    <th>Annual Sales</th>
                                    <th>Credit Limit Requirements</th>
                                    <th>Terms of Payment</th>
                                    <th>Length of Relationship</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_request->businessCreditLimits as $info)
                                    <tr>
                                        <td>{{ $info->buyer_details }}</td>
                                        <td>{{ $info->annual_sales }}</td>
                                        <td>{{ $info->credit_management_requirement }}</td>
                                        <td>{{ $info->terms_of_payment }}</td>
                                        <td>{{ $info->length_of_relationship }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
