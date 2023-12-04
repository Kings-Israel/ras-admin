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
                                    <th>Order Id</th>
                                    <th>Status</th>
                                    <th>Customer</th>
                                    @role('admin')
                                        <th>Inspector</th>
                                    @endrole
                                    <th>Requested On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $orderRequest)
                                    @can('view', $orderRequest)
                                        <tr>
                                            <td>{{ $orderRequest->orderItem->order->order_id }}</td>
                                            <td>{{ Str::title($orderRequest->status) }}</td>
                                            <td>{{ $orderRequest->orderItem->order->user->first_name }} {{ $orderRequest->orderItem->order->user->last_name }}</td>
                                            @role('admin')
                                                <td>{{ $orderRequest->requesteable->name }}</td>
                                            @endrole
                                            <td>{{ $orderRequest->created_at->format('d M Y') }}</td>
                                            <td>
                                                @can('update', $orderRequest)
                                                    <a href="{{ route('inspection.requests.show', ['order_request' => $orderRequest]) }}" class="btn btn-sm btn-primary btn-round waves-effect">View</a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endcan
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
