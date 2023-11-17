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
                    <div class="header d-flex justify-content-between">
                        <h2><strong>{{ Str::title($page) }}</strong></h2>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="orders">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>User Name</th>
                                    <th>Vendor</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $warehouse_order)
                                    <tr>
                                        <td>{{ $warehouse_order->order->order_id }}</td>
                                        <td>{{ $warehouse_order->orderItem->order->user->first_name }} {{ $warehouse_order->orderItem->order->user->last_name }}</td>
                                        <td>{{ $warehouse_order->order->business->name }}</td>
                                        <td><span class="badge {{ $warehouse_order->order->resolveOrderBadgeStatus() }}">{{ Str::title($warehouse_order->order->status) }}</span></td>
                                        <td>{{ $warehouse_order->order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('warehouses.orders.request.details', ['warehouse' => $warehouse_order->warehouse, 'warehouse_order' => $warehouse_order]) }}" class="btn btn-sm btn-primary btn-round waves-effect">Details</a>
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
        $('#orders').DataTable().order([5, 'desc']).draw();
    </script>
@endpush
