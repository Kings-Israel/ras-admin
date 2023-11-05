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
                        <table class="table table-hover dataTable js-exportable" id="financing_requests">
                            <thead>
                                <tr>
                                    <th>INVOICE ID</th>
                                    <th>No. of Orders</th>
                                    <th>Status</th>
                                    <th>Customer</th>
                                    <th>Requested On</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($financing_requests as $financing_request)
                                    <tr>
                                        <td>{{ $financing_request->invoice->invoice_id }}</td>
                                        <td>{{ $financing_request->invoice->orders->count() }}</td>
                                        <td>{{ Str::title($financing_request->status) }}</td>
                                        <td>{{ $financing_request->invoice->user->first_name }} {{ $financing_request->invoice->user->last_name }}</td>
                                        <td>{{ $financing_request->created_at->format('d M Y') }}</td>
                                        <td>
                                            @can('view financing request')
                                                <a href="{{ route('financing.requests.show', ['financing_request' => $financing_request]) }}" class="btn btn-sm btn-primary btn-round waves-effect">VIEW</a>
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
        $('#financing_requests').DataTable().order([4, 'desc']).draw()
    </script>
@endpush
