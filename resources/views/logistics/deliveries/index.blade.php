@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
    <section class="content home">
        <div class="container-fluid">
            <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <table class="table table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    @role('admin')
                                        <th>Logistics Company</th>
                                    @endrole
                                    <th>Quantity</th>
                                    <th>Requested On</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($requests as $delivery_request)
                                    <tr>
                                        <td>{{ $delivery_request->orderItem->order->order_id }}</td>
                                        @role('admin')
                                            <td>{{ $delivery_request->logisticsCompany->name }}</td>
                                        @endrole
                                        <td>{{ $delivery_request->orderItem->quantity }}</td>
                                        <td>{{ $delivery_request->created_at->format('d M Y') }}</td>
                                        <td>{{ Str::title($delivery_request->status) }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary waves-effect btn-round" href="{{ route('deliveries.show', ['delivery_request' => $delivery_request]) }}" >View</a>
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
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endpush
