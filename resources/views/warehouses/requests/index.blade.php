@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <style>
        #super{
            vertical-align:super;
            font-size: smaller;
        }
    </style>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
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
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Requested On</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($requests as $storagerequest)
                                    <tr>
                                        <td>{{ $storagerequest->customer->first_name }} {{ $storagerequest->customer->last_name }}</td>
                                        <td>{{ $storagerequest->quantity }}</td>
                                        <td>{{ $storagerequest->requested_on->format('d M Y') }}</td>
                                        <td>{{ Str::title($storagerequest->status) }}</td>
                                        <td>{{ Str::title($storagerequest->payment_status) }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary waves-effect btn-round" href="#" >View</a>
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
