@extends('layouts.app')
@section('content')
<section class="content home">
    <div class="container-fluid">
        <x-breadcrumbs :items="$breadcrumbs"></x-breadcrumbs>
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <div class="card text-center">
                    <div class="body">
                        <span>Total Amount Paid Out</span>
                        <h3 class="m-b-10"><span class="number count-to" data-from="0" data-to="0" data-speed="2000" data-fresh-interval="700">0</span></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center">
                    <div class="body">
                        <span>Total Amount Paid Back</span>
                        <h3 class="m-b-10 number count-to" data-from="0" data-to="0" data-speed="2000" data-fresh-interval="700">0</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center">
                    <div class="body">
                        <span>Requests Awaiting Second Approval</span>
                        <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $first_approved_requests }}" data-speed="2000" data-fresh-interval="700">{{ $first_approved_requests }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-center">
                    <div class="body">
                        <span>Customers</span>
                        <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $customers }}" data-speed="300" data-fresh-interval="100">{{ $customers }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-6">
                <div class="card text-center">
                    <div class="body">
                        <div class="row">
                            <div class="col-3">
                                <span>Total Requests</span>
                                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $total_requests_count }}" data-speed="300" data-fresh-interval="100">{{ $total_requests_count }}</h3>
                            </div>
                            <div class="col-3">
                                <span>Pending</span>
                                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $pending_requests_count }}" data-speed="300" data-fresh-interval="100">{{ $pending_requests_count }}</h3>
                            </div>
                            <div class="col-3">
                                <span>Approved</span>
                                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $fully_approved_requests }}" data-speed="300" data-fresh-interval="100">{{ $fully_approved_requests }}</h3>
                            </div>
                            <div class="col-3">
                                <span>Rejected</span>
                                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $rejected_requests_count }}" data-speed="300" data-fresh-interval="100">{{ $rejected_requests_count }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card visitors-map">
                <div class="header">
                    <h2><strong>Financing</strong> Requests Rate and Approval Rate</h2>
                </div>
                <div class="body m-b-10">
                    <canvas id="financing_and_approval_rate" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Admins</strong></h2>
                </div>
                <div class="body">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="finance_users">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Last Login</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ Carbon\Carbon::parse($user->last_login)->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('users.show', ['user' => $user]) }}" class="btn btn-sm btn-primary btn-round waves-effect">DETAILS</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/plugins/chartjs/Chart.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
    <script>
        $('#finance_users').DataTable({
            paging: true,
            ordering: true,
        })

        $(function () {
            let finance_request_rate_graph_data = {!! json_encode($finance_request_rate_graph_data) !!}
            let approval_rate_graph_data = {!! json_encode($approval_rate_graph_data) !!}
            let months = {!! json_encode($months) !!}

            new Chart(document.getElementById("financing_and_approval_rate").getContext("2d"),
            config = {
                type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: "Users",
                            data: finance_request_rate_graph_data,
                            borderColor: 'rgba(241,95,121, 0.2)',
                            backgroundColor: 'rgba(241,95,121, 0.5)',
                            pointBorderColor: 'rgba(241,95,121, 0.3)',
                            pointBackgroundColor: 'rgba(241,95,121, 0.2)',
                            pointBorderWidth: 1
                        }, {
                            label: "Vendors",
                            data: approval_rate_graph_data,
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
    </script>
@endpush
