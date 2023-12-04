@extends('layouts.app')
@section('content')
<section class="content home">
    <div class="container-fluid">
        <x-breadcrumbs :items="$breadcrumbs"></x-breadcrumbs>
        <div class="d-flex justify-content-end mb-2 mt-0">
            <form method="get" action="{{ route('dashboard') }}" class="form-inline" id="dateFilterForm">
                <label class="mr-2" for="date_filter">Select Date Range:</label>
                <select class="form-control mr-2" name="date_filter" id="date_filter">
                    <option value="all" {{ (request('date_filter') == 'all' || old('date_filter') == 'all') ? 'selected' : '' }}>All</option>
                    <option value="today" {{ (request('date_filter') == 'today' || old('date_filter') == 'today') ? 'selected' : '' }}>Today</option>
                    <option value="last_week" {{ (request('date_filter') == 'last_week' || old('date_filter') == 'last_week') ? 'selected' : '' }}>Last Week</option>
                    <option value="this_month" {{ (!request('date_filter') || request('date_filter') == 'this_month' || old('date_filter') == 'this_month') ? 'selected' : '' }}>This Month</option>
                    <option value="last_month" {{ (request('date_filter') == 'last_month' || old('date_filter') == 'last_month') ? 'selected' : '' }}>Last Month</option>
                </select>
            </form>
        </div>
        @role('admin')
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-balance zmdi-hc-3x col-amber"></i></p>
                            <span class="font-bold">Total Revenue</span>
                            <h3 class="m-b-10"><span class="number count-to" data-from="0" data-to="0" data-speed="2000" data-fresh-interval="700">0</span></h3>
                            <small class="text-muted">0% lower growth</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-assignment zmdi-hc-3x col-blue"></i></p>
                            <span class="font-bold">Total Orders</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $total_orders }}" data-speed="2000" data-fresh-interval="700">{{ $total_orders }}</h3>
                            <small class="text-muted">{{ $total_orders_rate }}% {{ $total_orders_direction }} growth</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-shopping-basket zmdi-hc-3x"></i></p>
                            <span class="font-bold">Total Sales</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $total_paid_orders }}" data-speed="2000" data-fresh-interval="700">{{ $total_paid_orders }}</h3>
                            <small class="text-muted">{{ $total_paid_orders_rate }}% {{ $total_paid_orders_direction }} growth</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <p class="m-b-20"><i class="zmdi zmdi-account-box zmdi-hc-3x col-green"></i></p>
                            <span class="font-bold">Users</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $total_users_count }}" data-speed="300" data-fresh-interval="100">{{ $total_users_count }}</h3>
                            <small class="text-muted">{{ $user_registration_rate }}% {{ $user_registration_direction }} growth</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Orders</strong> & Sales</h2>
                    </div>
                    <div class="body">
                        <canvas id="bar_chart" height="100"></canvas>
                    </div>
                </div>
            </div>
        @endrole
        <div class="row clearfix">
            @can('view warehouse')
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <span class="font-bold">Total Warehouses</span>
                            <h3 class="m-b-10"><span class="number count-to" data-from="0" data-to="{{ $warehouses_count }}" data-speed="10" data-fresh-interval="5">{{ $warehouses_count }}</span></h3>
                        </div>
                    </div>
                </div>
            @endcan
            @can('view product')
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <span class="font-bold">Total Products</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $products_count }}" data-speed="10" data-fresh-interval="5">{{ $products_count }}</h3>
                        </div>
                    </div>
                </div>
            @endcan
            {{-- @can('view stocklift requests')
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="body">
                            <span>Total Stocklift Requests</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="0" data-speed="100" data-fresh-interval="200">{{ $total_stocklift_requests }}</h3>
                        </div>
                    </div>
                </div>
            @endcan --}}
            @role('admin')
                <div class="col-lg-3 col-md-3">
                    <div class="card text-center">
                        <div class="header">
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li><a href="javascript:void(0);" onclick="changeBusinessesView('total-businesses-number')">Total Number of Businesses</a></li>
                                        <li><a href="javascript:void(0);" onclick="changeBusinessesView('businesses-pending-approval')">Businesses Pending Approval</a></li>
                                        <li><a href="javascript:void(0);" onclick="changeBusinessesView('approved-businesses')">Approved Businesses</a></li>
                                        <li><a href="javascript:void(0);" onclick="changeBusinessesView('rejected-businesses')">Rejected Businesses</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div id="total-businesses-number" style="display: block">
                                <span class="font-bold">Total Businesses</span>
                                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $total_businesses_count }}" data-speed="300" data-fresh-interval="100">{{ $total_businesses_count }}</h3>
                            </div>
                            <div id="businesses-pending-approval" style="display: none">
                                <span class="font-bold">Business Pending Approval</span>
                                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $pending_businesses_count }}" data-speed="300" data-fresh-interval="100">{{ $pending_businesses_count }}</h3>
                            </div>
                            <div id="approved-businesses" style="display: none">
                                <span class="font-bold">Approved Businesses</span>
                                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $approved_businesses_count }}" data-speed="300" data-fresh-interval="100">{{ $approved_businesses_count }}</h3>
                            </div>
                            <div id="rejected-businesses" style="display: none">
                                <span class="font-bold">Rejected Businesses</span>
                                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $rejected_businesses_count }}" data-speed="300" data-fresh-interval="100">{{ $rejected_businesses_count }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="header">
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li><a href="javascript:void(0);" onclick="changeUsersView('total-vendors')">Total Number of Vendors</a></li>
                                        <li><a href="javascript:void(0);" onclick="changeUsersView('total-buyers')">Total Number of Buyers</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body" id="total-vendors" style="display: block">
                            <span class="font-bold">Vendors</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $total_vendors_count }}" data-speed="300" data-fresh-interval="100">{{ $total_vendors_count }}</h3>
                        </div>
                        <div class="body" id="total-buyers" style="display: none">
                            <span class="font-bold">Buyers</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $total_buyers_count }}" data-speed="300" data-fresh-interval="100">{{ $total_buyers_count }}</h3>
                        </div>
                    </div>
                </div>
            @endrole
        </div>
        <div class="row clearfix">
            @can('view warehouse')
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="header">
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li><a href="javascript:void(0);" onclick="changeStorageRequestsView('pending-storage-requests')">Pending</a></li>
                                        <li><a href="javascript:void(0);" onclick="changeStorageRequestsView('approved-storage-requests')">Approved</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body" id="pending-storage-requests" style="display: block">
                            <span class="font-bold">Pending Storage Requests</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $pending_storage_requests }}" data-speed="100" data-fresh-interval="200">{{ $pending_storage_requests }}</h3>
                        </div>
                        <div class="body" id="approved-storage-requests" style="display: none">
                            <span class="font-bold">Approved Storage Requests</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $approved_storage_requests }}" data-speed="100" data-fresh-interval="200">{{ $approved_storage_requests }}</h3>
                        </div>
                    </div>
                </div>
            @endcan
            @can('view financing request')
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="header">
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li><a href="javascript:void(0);" onclick="changeFinancingRequestsView('pending-financing-requests')">Pending</a></li>
                                         <li><a href="javascript:void(0);" onclick="changeFinancingRequestsView('approved-financing-requests')">Approved</a></li>
                                        <li><a href="javascript:void(0);" onclick="changeFinancingRequestsView('rejected-financing-requests')">Rejected</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body" id="pending-financing-requests" style="display: block">
                            <span class="font-bold">Pending Financing Requests</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $financing_requests_count }}" data-speed="100" data-fresh-interval="200">{{ $financing_requests_count }}</h3>
                        </div>
                        <div class="body" id="approved-financing-requests" style="display: none">
                            <span class="font-bold">Approved Financing Requests</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="0" data-speed="100" data-fresh-interval="200">0</h3>
                        </div>
                        <div class="body" id="rejected-financing-requests" style="display: none">
                            <span class="font-bold">Rejected Financing Requests</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="0" data-speed="100" data-fresh-interval="200">0</h3>
                        </div>
                    </div>
                        </div>
                   @endcan
                @role('financier')
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="header">
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li><a href="javascript:void(0);" onclick="changeFinancingRequestsView('financing-limit')">Financing Limit</a></li>
                                       </ul>
                                </li>
                            </ul>
                        </div>

                        <div class="body" id="financing-limit" style="display: block">
                            <span class="font-bold">Financing Limit</span> {{$financing_total_limit ?? 0.00}}
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{!! number_format($financing_total_limit, 2) !!}"
                                data-speed="100" data-fresh-interval="200">"{!! number_format($financing_total_limit, 2) !!}"
                            </h3>
                        </div>
                </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="header">
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li><a href="javascript:void(0);" onclick="changeFinancingRequestsView('financing-disbursed')">Disbursed Amount</a></li>
                                       </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body" id="financing-disbursed" style="display: block">
                            <span class="font-bold">Disbursed Amount</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{!! number_format($financing_total_invoices, 2) !!}"
                                data-speed="100" data-fresh-interval="200">"{!! number_format($financing_total_invoices, 2) !!}"
                            </h3>
                        </div>
                </div>
                </div>
                @endrole
            @can('view inspection request')
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="header">
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li><a href="javascript:void(0);" onclick="changeInspectionRequestsView('accpeted-inspection-requests')">Accepted</a></li>
                                        <li><a href="javascript:void(0);" onclick="changeInspectionRequestsView('pending-inspection-requests')">Pending</a></li>
                                        <li><a href="javascript:void(0);" onclick="changeInspectionRequestsView('rejected-inspection-requests')">Rejected</a></li>
                                        <li><a href="javascript:void(0);" onclick="changeInspectionRequestsView('completed-inspection-requests')">Completed</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body" id="accpeted-inspection-requests" style="display: block">
                            <span class="font-bold">Accepted Inspection Requests</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $accepted_inspection_requests_count }}" data-speed="100" data-fresh-interval="200">{{ $accepted_inspection_requests_count }}</h3>
                        </div>
                        <div class="body" id="pending-inspection-requests" style="display: none">
                            <span class="font-bold">Pending Inspection Requests</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $pending_inspection_requests_count }}" data-speed="100" data-fresh-interval="200">{{ $pending_inspection_requests_count }}</h3>
                        </div>
                        <div class="body" id="rejected-inspection-requests" style="display: none">
                            <span class="font-bold">Rejected Inspection Requests</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $rejected_inspection_requests_count }}" data-speed="100" data-fresh-interval="200">{{ $rejected_inspection_requests_count }}</h3>
                        </div>
                        <div class="body" id="completed-inspection-requests" style="display: none">
                            <span class="font-bold">Completed Inspection Reports</span>
                            <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $completed_inspection_reports_count }}" data-speed="100" data-fresh-interval="200">{{ $completed_inspection_reports_count }}</h3>
                        </div>
                    </div>
                </div>
            @endcan
            @can('view inspection report')
            <div class="col-lg-4 col-md-6">
                <div class="card text-center">
                    <div class="header">
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu slideUp">
                                    <li><a href="javascript:void(0);" onclick="changeInspectionReportsView('completed-inspection-reports')">Completed</a></li>
                                    <li><a href="javascript:void(0);" onclick="changeInspectionReportsView('pending-inspection-reports')">Pending</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body" id="completed-inspection-reports" style="display: block">
                        <span class="font-bold">Completed Inspection Reports</span>
                        <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $completed_inspection_reports_count }}" data-speed="100" data-fresh-interval="200">{{ $completed_inspection_reports_count }}</h3>
                    </div>
                    <div class="body" id="pending-inspection-reports" style="display: none">
                        <span class="font-bold">Pending Inspection Reports</span>
                        <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $pending_inspection_reports_count }}" data-speed="100" data-fresh-interval="200">{{ $pending_inspection_reports_count }}</h3>
                    </div>
                </div>
            </div>
        @endcan
        </div>
        @can('view financing request')
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card visitors-map">
                        <div class="header">
                            <h2><strong>Financing</strong> Requests</h2>
                        </div>
                        <div class="body m-b-10">
                            <canvas id="financing_request_rate" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('view inspection report')
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card visitors-map">
                        <div class="header">
                            <h2><strong>Inspection</strong> Requests</h2>
                        </div>
                        <div class="body m-b-10">
                            <canvas id="inspection_requests_rate" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card visitors-map">
                        <div class="header">
                            <h2><strong>Completed</strong> Inspection Reports</h2>
                        </div>
                        <div class="body m-b-10">
                            <canvas id="completed_reports_rate" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @role('admin')
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card visitors-map">
                        <div class="header">
                            <h2><strong>Buyers</strong> & Vendors Registration Rate</h2>
                        </div>
                        <div class="body m-b-10">
                            <canvas id="user_registration_rate" height="100"></canvas>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-8 col-md-12">
                                    <div id="world-map-markers2" class="m-b-10"></div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-b-0">
                                            <tbody>
                                                @foreach ($countries as $country)
                                                    <tr title="{{ $country->name }}">
                                                        <th><i class="zmdi zmdi-circle {{ $country->color }}"></i></th>
                                                        @if (strlen($country->name) > 12)
                                                            <td>{{ $country->iso_three }}</td>
                                                        @else
                                                            <td>{{ Str::title($country->name) }}</td>
                                                        @endif
                                                        <td><span>{{ $country->warehouses_count }} WHs</span></td>
                                                        <td><span>{{ $country->businesses_count }} BSs</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole
        @role('admin')
            <div class="row clearfix">
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Top</strong> Businesses</h2>
                        </div>
                        <div class="body m-b-10">
                            <div class="progress-container l-black">
                                <span class="progress-badge">New Stores</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;">
                                        <span class="progress-value">68%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body m-b-10">
                            <div class="progress-container progress-info">
                                <span class="progress-badge">Hekima Goods</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100" style="width: 91%;">
                                        <span class="progress-value">91%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body m-b-20">
                            <div class="progress-container progress-warning">
                                <span class="progress-badge">Cement Ltd</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
                                        <span class="progress-value">35%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2><strong>Top</strong> Categories by Products</h2>
                        </div>
                        <div class="body align-center">
                            <div class="row">
                                @foreach ($product_categories_ratio['labels'] as $key => $label)
                                    <div class="col-4">
                                        <h4 class="margin-0">{{ $product_categories_ratio['percentage'][$key] }}%</h4>
                                        <p>{{ $label }}</p>
                                    </div>
                                @endforeach
                                {{-- <div class="col-4">
                                    <h4 class="margin-0">20%</h4>
                                    <p>Weekly</p>
                                </div>
                                <div class="col-4">
                                    <h4 class="margin-0">30%</h4>
                                    <p>Daily</p>
                                </div> --}}
                            </div>
                            @php($product_categories = implode(', ', $product_categories_ratio['series']))
                            <div class="sparkline-pie">{{ $product_categories }}</div>
                        </div>
                    </div>
                </div>
                @can('view warehouse', 'update warehouse')
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Warehouses</strong></h2>
                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table table-hover m-b-0 m-t-20">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <small>Page Views</small>
                                                    <h5 class="m-b-0">32,211</h5>
                                                </td>
                                                <td>
                                                    <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="30px" data-bar-Width="3" data-bar-Spacing="7" data-bar-Color="#2b314a">2,3,5,6,9,8,7,8,7</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <small>Site Visitors</small>
                                                    <h5 class="m-b-0">2,516</h5>
                                                </td>
                                                <td>
                                                    <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="30px" data-bar-Width="3" data-bar-Spacing="7" data-bar-Color="#2b314a">8,5,3,2,2,3,5,6,4</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <small>Total Clicks</small>
                                                    <h5 class="m-b-0">4,536</h5>
                                                </td>
                                                <td>
                                                    <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="30px" data-bar-Width="3" data-bar-Spacing="7" data-bar-Color="#2b314a">6,5,4,6,5,1,8,4,2</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <small>Total Returns</small>
                                                    <h5 class="m-b-0">516</h5>
                                                </td>
                                                <td>
                                                    <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="30px" data-bar-Width="3" data-bar-Spacing="7" data-bar-Color="#2b314a">8,2,3,5,6,4,5,7,5</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Site</strong> Traffic</h2>
                        </div>
                        <div class="body m-b-10">
                            <h5 class="m-b-0 number count-to" data-from="0" data-to="2651" data-speed="2000" data-fresh-interval="700">2651</h5>
                            <p class="text-muted">Direct <span class="float-right">48%</span></p>
                            <div class="progress m-b-20">
                                <div class="progress-bar l-dark" role="progressbar" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100" style="width: 48%;"></div>
                            </div>

                            <h5 class="m-b-0 number count-to" data-from="0" data-to="251" data-speed="2000" data-fresh-interval="700">251</h5>
                            <p class="text-muted">Referrals <span class="float-right">18%</span></p>
                            <div class="progress m-b-20">
                                <div class="progress-bar l-amber" role="progressbar" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100" style="width: 18%;"></div>
                            </div>

                            <h5 class="m-b-0 number count-to" data-from="0" data-to="941" data-speed="2000" data-fresh-interval="700">941</h5>
                            <p class="text-muted">Search Engines <span class="float-right">67%</span></p>
                            <div class="progress">
                                <div class="progress-bar l-green" role="progressbar" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100" style="width: 67%;"></div>
                            </div>
                        </div>
                        <div class="body">
                            <p class="m-b-10">Page View <small class="float-right">3,665</small></p>
                            <div id="sparkline14"></div>
                            <p class="m-b-10 m-t-30">Bounce Rate <small class="float-right">2,925</small></p>
                            <div id="sparkline15"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole
        @role('admin')
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Product</strong> Sales </h2>
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                        <li><a href="javascript:void(0);" class="boxs-close">Deletee</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body sales_report">
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Business</th>
                                            <th>Change</th>
                                            <th>Sales</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h6>Alpino 4.1</h6>
                                                <span>WrapTheme To By Again</span>
                                            </td>
                                            <td>
                                                <ul class="list-unstyled team-info">
                                                    <li><img src="assets/images/xs/avatar1.jpg" alt="Avatar"></li>
                                                    <li><img src="assets/images/xs/avatar2.jpg" alt="Avatar"></li>
                                                    <li><img src="assets/images/xs/avatar3.jpg" alt="Avatar"></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="sparkline text-left" data-type="line" data-width="8em" data-height="20px" data-line-Width="1.5" data-line-Color="#00c5dc"
                                                data-fill-Color="transparent">3,5,1,6,5,4,8,3</div>
                                            </td>
                                            <td>11,200</td>
                                            <td>$83</td>
                                            <td><strong>$22,520</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>Compass 2.0</h6>
                                                <span>WrapTheme To By Again</span>
                                            </td>
                                            <td>
                                                <ul class="list-unstyled team-info">
                                                    <li><img src="assets/images/xs/avatar2.jpg" alt="Avatar"></li>
                                                    <li><img src="assets/images/xs/avatar3.jpg" alt="Avatar"></li>
                                                    <li><img src="assets/images/xs/avatar4.jpg" alt="Avatar"></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="sparkline text-left" data-type="line" data-width="8em" data-height="20px" data-line-Width="1.5" data-line-Color="#f4516c"
                                                data-fill-Color="transparent">4,6,3,2,5,6,5,4</div>
                                            </td>
                                            <td>11,200</td>
                                            <td>$66</td>
                                            <td><strong>$13,205</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>Nexa 1.1</h6>
                                                <span>WrapTheme To By Again</span>
                                            </td>
                                            <td>
                                                <ul class="list-unstyled team-info">
                                                    <li><img src="assets/images/xs/avatar4.jpg" alt="Avatar"></li>
                                                    <li><img src="assets/images/xs/avatar6.jpg" alt="Avatar"></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="sparkline text-left" data-type="line" data-width="8em" data-height="20px" data-line-Width="1.5" data-line-Color="#31db3d"
                                                data-fill-Color="transparent">7,3,2,1,5,4,6,8</div>
                                            </td>
                                            <td>12,080</td>
                                            <td>$93</td>
                                            <td><strong>$17,700</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>Oreo 2.2</h6>
                                                <span>ThemeMakker To By Again</span>
                                            </td>
                                            <td>
                                                <ul class="list-unstyled team-info">
                                                    <li><img src="assets/images/xs/avatar1.jpg" alt="Avatar"></li>
                                                    <li><img src="assets/images/xs/avatar3.jpg" alt="Avatar"></li>
                                                    <li><img src="assets/images/xs/avatar2.jpg" alt="Avatar"></li>
                                                    <li><img src="assets/images/xs/avatar9.jpg" alt="Avatar"></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="sparkline text-left" data-type="line" data-width="8em" data-height="20px" data-line-Width="1.5" data-line-Color="#2d342e"
                                                data-fill-Color="transparent">3,1,2,5,4,6,2,3</div>
                                            </td>
                                            <td>18,200</td>
                                            <td>$178</td>
                                            <td><strong>$17,700</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole
        <div class="row clearfix">
            @role('admin')
                <div class="col-md-6 col-lg-4">
                    @php($visits_series = implode(", ", $site_visits_series['visit_log']))
                    <div class="card">
                        <div class="header">
                            <h2><strong>Traffic</strong> this month <small>{{ $site_visits_series['site_visits_rate'] }}% {{ $site_visits_series['site_visits_direction'] }} than last Month</small></h2>
                        </div>
                        <div class="body m-b-10">
                            <div class="text-center">
                                <h3 class="m-b-0">{{ $site_visits_series['current_month_site_visits'] }} Visit(s)</h3>
                                <small>in current month</small>
                            </div>
                        </div>
                        <div class="body l-coral overflowhidden">
                            <p class="m-b-0">Bandwidth for past 9 months</p>
                            <h3>{{ $site_visits_series['visits_bandwidth'] }}</h3>
                            <div class="sparkline" data-type="line" data-spot-Radius="4" data-highlight-Spot-Color="#fff" data-highlight-Line-Color="#222"
                                data-min-Spot-Color="#fff" data-max-Spot-Color="#fff" data-spot-Color="#fff"
                                data-offset="90" data-width="100%" data-height="135px" data-line-Width="2" data-line-Color="#fff"
                                data-fill-Color="transparent">{{ $visits_series }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Invoice</strong></h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-12">
                                    <address>
                                        <strong>New Stores</strong> <small class="float-right">27/10/2023</small><br>
                                        <abbr title="Phone">P:</abbr> (123) 456-34636
                                    </address>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>COMPASS 2.0</td>
                                            <td>$930</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>OREO 2.2</td>
                                            <td>$525</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><strong>$1455</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole
        </div>
    </div>
</section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/plugins/chartjs/Chart.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/charts/chartjs.js') }}"></script>
    @role('admin')
    <script>
        $(function () {
            let user_registration_graph_data = {!! json_encode($user_registration_rate_graph_data) !!}
            let vendor_registration_graph_data = {!! json_encode($vendor_registration_rate_graph_data) !!}
            let total_orders_graph_rate = {!! json_encode($total_orders_graph_rate) !!}
            let months = {!! json_encode($months) !!}
            let warehouses = {!! json_encode($warehouses) !!}
            let countries = {!! json_encode($countries) !!}
            console.log(total_orders_graph_rate)

            new Chart(document.getElementById("user_registration_rate").getContext("2d"),
            config = {
                type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: "Users",
                            data: user_registration_graph_data,
                            borderColor: 'rgba(241,95,121, 0.2)',
                            backgroundColor: 'rgba(241,95,121, 0.5)',
                            pointBorderColor: 'rgba(241,95,121, 0.3)',
                            pointBackgroundColor: 'rgba(241,95,121, 0.2)',
                            pointBorderWidth: 1
                        }, {
                            label: "Vendors",
                            data: vendor_registration_graph_data,
                            borderColor: 'rgba(140,147,154, 0.2)',
                            backgroundColor: 'rgba(140,147,154, 0.2)',
                            pointBorderColor: 'rgba(140,147,154, 0)',
                            pointBackgroundColor: 'rgba(140,147,154, 0.9)',
                            pointBorderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: false,

                    }
                }
            );

            new Chart(document.getElementById("bar_chart").getContext("2d"), getChartJs('bar'));

            "use strict";

            /** VectorMap Init */
            var mapData = {};
            let region_values = {}
            let country_warehouses = []

            let value_colors = [
                '#FFA500',
                '#00FF00',
                '#800080',
                '#FFC0CB',
                '#808080',
                '#008000',
                '#000000',
                '#FF00FF',
                '#FFFF00',
            ]

            countries.forEach((country, key) => {
                let country_iso = country.iso
                mapData[country_iso] = country.warehouses_count
                region_values[country_iso] = value_colors[key]
            });


            warehouses.forEach((warehouse, key) => {
                if (warehouse.latitude != null && warehouse.longitude != null) {
                    country_warehouses[key] = { latLng: [warehouse.latitude, warehouse.longitude], name: warehouse.name }
                }
            })

            if( $('#world-map-markers2').length > 0 ){
                $('#world-map-markers2').vectorMap(
                {
                    map: 'world_mill_en',
                    backgroundColor: 'transparent',
                    borderColor: '#fff',
                    borderOpacity: 0.25,
                    borderWidth: 0,
                    color: '#e6e6e6',
                    regionStyle : {
                        initial : {
                            fill : '#e9eef0'
                        }
                    },

                    markerStyle: {
                        initial: {
                            r: 8,
                            'fill': '#3c434d',
                            'fill-opacity': 0.9,
                            'stroke': '#fff',
                            'stroke-width' : 5,
                            'stroke-opacity': 0.8
                        },
                        hover: {
                            'stroke': '#fff',
                            'fill-opacity': 1,
                            'stroke-width': 5
                        },
                    },

                    markers : country_warehouses,

                    series: {
                        regions: [{
                            values: region_values,
                            attribute: 'fill'
                        }]
                    },
                    hoverOpacity: null,
                    normalizeFunction: 'linear',
                    zoomOnScroll: true,
                    scaleColors: ['#000000', '#000000'],
                    selectedColor: '#000000',
                    selectedRegions: [],
                    enableZoom: true,
                    hoverColor: '#fff',
                });
            }
        });

        $(function () {
            $('.sparkline-pie').sparkline('html', {
                type: 'pie',
                offset: 90,
                width: '138px',
                height: '138px',
                sliceColors: ['#454c56', '#61ccb7', '#5589cd']
            })

            $("#sparkline14").sparkline([8,2,3,7,6,5,2,1,4,8], {
                type: 'line',
                width: '100%',
                height: '28',
                lineColor: '#3f7dc5',
                fillColor: 'transparent',
                spotColor: '#000',
                lineWidth: 1,
                spotRadius: 2,

            });
            $("#sparkline15").sparkline([2,3,9,1,2,5,4,7,8,2], {
                type: 'line',
                width: '100%',
                height: '28',
                lineColor: '#e66990',
                fillColor: 'transparent',
                spotColor: '#000',
                lineWidth: 1,
                spotRadius: 2,
            });

            $('.sparkbar').sparkline('html', {
                type: 'bar',
                height: '100',
                width: '100%',
                barSpacing: '20',
                barColor: '#e56590',
                negBarColor: '#4ac2ae',
                responsive: true,
            });
        });

        //======
        $(window).on('scroll',function() {
            $('.card .sparkline').each(function() {
                var imagePos = $(this).offset().top;

                var topOfWindow = $(window).scrollTop();
                if (imagePos < topOfWindow + 400) {
                    $(this).addClass("pullUp");
                }
            });
        });

        function getChartJs(type) {
            let total_orders_graph_rate = {!! json_encode($total_orders_graph_rate) !!}
            var config = null;

            if (type === 'line') {
                config = {
                    type: 'line',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            data: [28, 58, 39, 45, 30, 55, 68],
                            borderColor: 'rgba(241,95,121, 0.2)',
                            backgroundColor: 'rgba(241,95,121, 0.5)',
                            pointBorderColor: 'rgba(241,95,121, 0.3)',
                            pointBackgroundColor: 'rgba(241,95,121, 0.2)',
                            pointBorderWidth: 1
                        }, {
                            label: "My Second dataset",
                            data: [40, 28, 50, 48, 63, 39, 41],
                            borderColor: 'rgba(140,147,154, 0.2)',
                            backgroundColor: 'rgba(140,147,154, 0.2)',
                            pointBorderColor: 'rgba(140,147,154, 0)',
                            pointBackgroundColor: 'rgba(140,147,154, 0.9)',
                            pointBorderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: false,

                    }
                }
            }
            else if (type === 'bar') {
                config = {
                    type: 'bar',
                    data: {
                        labels: total_orders_graph_rate.Period,
                        datasets: [{
                            label: "Orders",
                            data: total_orders_graph_rate.Orders,
                            backgroundColor: '#26c6da',
                            strokeColor: "rgba(255,118,118,0.1)",
                        },
                        {
                            label: "Sales",
                            data: total_orders_graph_rate.Sales,
                            backgroundColor: '#8a8a8b',
                            strokeColor: "rgba(255,118,118,0.1)",
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            else if (type === 'radar') {
                config = {
                    type: 'radar',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            data: [65, 25, 90, 81, 56, 55, 40],
                            borderColor: 'rgba(241,95,121, 0.8)',
                            backgroundColor: 'rgba(241,95,121, 0.5)',
                            pointBorderColor: 'rgba(241,95,121, 0)',
                            pointBackgroundColor: 'rgba(241,95,121, 0.8)',
                            pointBorderWidth: 1
                        }, {
                                label: "My Second dataset",
                                data: [72, 48, 40, 19, 96, 27, 100],
                                borderColor: 'rgba(140,147,154, 0.8)',
                                backgroundColor: 'rgba(140,147,154, 0.5)',
                                pointBorderColor: 'rgba(140,147,154, 0)',
                                pointBackgroundColor: 'rgba(140,147,154, 0.8)',
                                pointBorderWidth: 1
                            }]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            else if (type === 'pie') {
                config = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: [150, 53, 121, 87, 45],
                            backgroundColor: [
                                "#2a8ceb",
                                "#58a3eb",
                                "#6fa6db",
                                "#86b8e8",
                                "#9dc7f0"
                            ],
                        }],
                        labels: [
                            "Pia A",
                            "Pia B",
                            "Pia C",
                            "Pia D",
                            "Pia E"
                        ]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            return config;
        }
    </script>
    @endrole
    @can('view financing request')
        <script>
            $(function () {
                let financing_requests_graph_data = {!! json_encode($financing_requests_graph_data) !!}
                let months = {!! json_encode($months) !!}
                new Chart(document.getElementById("financing_request_rate").getContext("2d"),
                    config = {
                        type: 'line',
                        data: {
                            labels: months,
                            datasets: [{
                                label: "Financing Requests",
                                data: financing_requests_graph_data,
                                borderColor: 'rgba(241,95,121, 0.2)',
                                backgroundColor: 'rgba(241,95,121, 0.5)',
                                pointBorderColor: 'rgba(241,95,121, 0.3)',
                                pointBackgroundColor: 'rgba(241,95,121, 0.2)',
                                pointBorderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: false,
                        }
                    }
                );
            });
        </script>
    @endcan
    @can('view inspection report')
        <script>
            let months = {!! json_encode($months) !!}
            let pending_inspection_requests_graph_data = {!! json_encode($pending_inspection_requests_graph_data) !!}
            let accepted_inspection_requests_graph_data = {!! json_encode($accepted_inspection_requests_graph_data) !!}
            let rejected_inspection_requests_graph_data = {!! json_encode($rejected_inspection_requests_graph_data) !!}
            let inspection_reports_graph_data = {!! json_encode($inspection_reports_graph_data) !!}
            // console.log(financing_requests_graph_data)

            new Chart(document.getElementById("inspection_requests_rate").getContext("2d"),
            config = {
                type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: "Pending",
                            data: pending_inspection_requests_graph_data,
                            borderColor: 'rgba(241,95,121, 0.2)',
                            backgroundColor: 'rgba(241,95,121, 0.5)',
                            pointBorderColor: 'rgba(241,95,121, 0.3)',
                            pointBackgroundColor: 'rgba(241,95,121, 0.2)',
                            pointBorderWidth: 1
                        }, {
                            label: "Accepted",
                            data: accepted_inspection_requests_graph_data,
                            borderColor: 'rgba(140,147,154, 0.2)',
                            backgroundColor: 'rgba(140,147,154, 0.2)',
                            pointBorderColor: 'rgba(140,147,154, 0)',
                            pointBackgroundColor: 'rgba(140,147,154, 0.9)',
                            pointBorderWidth: 1
                        }, {
                            label: "Rejected",
                            data: rejected_inspection_requests_graph_data,
                            borderColor: 'rgba(49,55,64, 0.2)',
                            backgroundColor: 'rgba(49,55,64, 0.2)',
                            pointBorderColor: 'rgba(49,55,64, 0)',
                            pointBackgroundColor: 'rgba(49,55,64, 0.9)',
                            pointBorderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: false,

                    }
                }
            );

            new Chart(document.getElementById("completed_reports_rate").getContext("2d"),
                config = {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: "Completed Reports",
                            data: inspection_reports_graph_data,
                            borderColor: 'rgba(241,95,121, 0.2)',
                            backgroundColor: 'rgba(241,95,121, 0.5)',
                            pointBorderColor: 'rgba(241,95,121, 0.3)',
                            pointBackgroundColor: 'rgba(241,95,121, 0.2)',
                            pointBorderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: false,
                    }
                }
            );
        </script>
    @endcan
    <script>
        function changeBusinessesView(view) {
            const total_businesses_number = document.getElementById('total-businesses-number');
            const businesses_pending_approval = document.getElementById('businesses-pending-approval');
            const approved_businesses = document.getElementById('approved-businesses');
            const rejected_businesses = document.getElementById('rejected-businesses');

            if (view == 'total-businesses-number') {
                total_businesses_number.style.display = 'block';
                businesses_pending_approval.style.display = 'none';
                approved_businesses.style.display = 'none';
                rejected_businesses.style.display = 'none';
            } else if (view == 'approved-businesses') {
                total_businesses_number.style.display = 'none';
                businesses_pending_approval.style.display = 'none';
                approved_businesses.style.display = 'block';
                rejected_businesses.style.display = 'none';
            } else if (view == 'businesses-pending-approval') {
                total_businesses_number.style.display = 'none';
                businesses_pending_approval.style.display = 'block';
                approved_businesses.style.display = 'none';
                rejected_businesses.style.display = 'none';
            } else if (view == 'rejected-businesses') {
                total_businesses_number.style.display = 'none';
                businesses_pending_approval.style.display = 'none';
                approved_businesses.style.display = 'none';
                rejected_businesses.style.display = 'block';
            }
        }

        function changeInspectionRequestsView(view) {
            const accepted_inspection_requests = document.getElementById('accpeted-inspection-requests');
            const pending_inspection_requests = document.getElementById('pending-inspection-requests');
            const rejected_inspection_requests = document.getElementById('rejected-inspection-requests');
            const completed_inspection_requests = document.getElementById('completed-inspection-requests');

            if (view == 'accpeted-inspection-requests') {
                accepted_inspection_requests.style.display = 'block';
                pending_inspection_requests.style.display = 'none';
                rejected_inspection_requests.style.display = 'none';
                completed_inspection_requests.style.display = 'none';
            } else if (view == 'rejected-inspection-requests') {
                accepted_inspection_requests.style.display = 'none';
                pending_inspection_requests.style.display = 'none';
                rejected_inspection_requests.style.display = 'block';
                completed_inspection_requests.style.display = 'none';
            } else if (view == 'pending-inspection-requests') {
                accepted_inspection_requests.style.display = 'none';
                pending_inspection_requests.style.display = 'block';
                rejected_inspection_requests.style.display = 'none';
                completed_inspection_requests.style.display = 'none';
            } else if (view == 'completed-inspection-requests') {
                accepted_inspection_requests.style.display = 'none';
                pending_inspection_requests.style.display = 'none';
                rejected_inspection_requests.style.display = 'none';
                completed_inspection_requests.style.display = 'block';
            }
        }

        function changeInspectionReportsView(view) {
            const accepted_inspection_reports = document.getElementById('completed-inspection-reports');
            const pending_inspection_reports = document.getElementById('pending-inspection-reports');

            if (view == 'completed-inspection-reports') {
                pending_inspection_reports.style.display = 'none';
                completed_inspection_reports.style.display = 'block';
            } else if (view == 'pending-inspection-reports') {
                pending_inspection_reports.style.display = 'block';
                completed_inspection_reports.style.display = 'none';
            }
        }

        function changeUsersView(view) {
            const total_vendors = document.getElementById('total-vendors');
            const total_buyers = document.getElementById('total-buyers');

            if (view == 'total-vendors') {
                total_vendors.style.display = 'block';
                total_buyers.style.display = 'none';
            } else if (view == 'total-buyers') {
                total_vendors.style.display = 'none';
                total_buyers.style.display = 'block';
            }
        }

        function changeStorageRequestsView(view) {
            const pending_requests = document.getElementById('pending-storage-requests');
            const approved_requests = document.getElementById('approved-storage-requests');

            if (view == 'pending-storage-requests') {
                pending_requests.style.display = 'block';
                approved_requests.style.display = 'none';
            } else if (view == 'approved-storage-requests') {
                pending_requests.style.display = 'none';
                approved_requests.style.display = 'block';
            }
        }

        function changeFinancingRequestsView(view) {
            const pending_financing_requests = document.getElementById('pending-financing-requests');
            const approved_financing_requests = document.getElementById('approved-financing-requests');
            const rejected_financing_requests = document.getElementById('rejected-financing-requests');

            if (view == 'pending-financing-requests') {
                pending_financing_requests.style.display = 'block';
                approved_financing_requests.style.display = 'none';
                rejected_financing_requests.style.display = 'none';
            } else if (view == 'rejected-financing-requests') {
                pending_financing_requests.style.display = 'none';
                approved_financing_requests.style.display = 'none';
                rejected_financing_requests.style.display = 'block';
            } else if (view == 'approved-financing-requests') {
                pending_financing_requests.style.display = 'none';
                approved_financing_requests.style.display = 'block';
                rejected_financing_requests.style.display = 'none';
            }
        }
        $(document).ready(function() {
            // Listen for the change event on the select element
            $('#date_filter').change(function() {
                // Submit the form when an option is selected
                $('#dateFilterForm').submit();
            });
        });
    </script>
@endpush
