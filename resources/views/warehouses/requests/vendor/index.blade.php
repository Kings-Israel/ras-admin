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
                                    <th>Code</th>
                                    <th>Vendor Name</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Requested On</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($requests as $storagerequest)
                                    <tr>
                                        <td>{{ $storagerequest->code }}</td>
                                        <td>{{ $storagerequest->business->name ?? ''}}</td>
                                        <td>{{ Str::title($storagerequest->status) }}</td>
                                        <td>{{ Str::title($storagerequest->payment_status) }}</td>
                                        <td>{{ $storagerequest->created_at->format('d M Y:H m s') }}</td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-sm btn-round">View</a>
                                            {{-- <a class="dropdown-item" href="{{ route('storagerequests.edit', ['storagerequest' => $storagerequest->id]) }}" ><i data-feather='edit' class="mr-50 btn btn-sm btn-primary waves-effect"></i><span>View</span></a>
                                            <a class="dropdown-item" href="{{ route('storagerequests.products', ['storagerequest' => $storagerequest->id]) }}" ><i data-feather='view' class="mr-50 btn btn-sm btn-primary waves-effect"></i><span>Products</span></a> --}}
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
