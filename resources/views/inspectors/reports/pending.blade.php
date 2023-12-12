@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <style>
        #super{
            vertical-align:super;
            font-size: smaller;
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
                    </div>
                    <div class="body">
                        <table class="table table-hover dataTable js-exportable" id="inspection_requests">
                            <thead>
                                <tr>
                                    <th>ORDER ID</th>
                                    {{-- <th>No. of Order Items</th> --}}
                                    <th>Status</th>
                                    <th>Customer</th>
                                    <th>Payment Status</th>
                                    @role('admin')
                                        <th>Inspector</th>
                                    @endrole
                                    <th>Requested On</th>
                                    @can('create inspection report')
                                        <th>Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_requests as $inspection_request)
                                    <tr>
                                        <td>{{ $inspection_request->orderItem->order->order_id }}</td>
                                        {{-- <td>{{ $inspection_request->order->orderItems->count() }}</td> --}}
                                        <td>{{ Str::title($inspection_request->status) }}</td>
                                        <td>{{ $inspection_request->orderItem->order->user->first_name }} {{ $inspection_request->orderItem->order->user->last_name }}</td>
                                        <td>{{ Str::title($inspection_request->orderItem->order->invoice->payment_status) }}</td>
                                        @role('admin')
                                            <td>{{ $inspection_request->requesteable->name }}</td>
                                        @endrole
                                        <td>{{ $inspection_request->created_at->format('d M Y') }}</td>
                                        <td>
                                            @can('create inspection report')
                                                <a href="{{ route('inspection.requests.reports.create', ['order_request' => $inspection_request]) }}" class="btn btn-sm btn-primary btn-round waves-effect">Add Report</a>
                                            @endcan
                                        </td>
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
    <script>
        $('#inspection_requests').DataTable().order([4, 'desc']).draw()
    </script>
@endpush
