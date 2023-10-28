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
                        @can('create warehouse')
                            <a class="btn btn-secondary btn-sm" href="{{ route('warehouses.create') }}">Add Warehouse</a>
                        @endcan
                    </div>
                    <div class="body">
                        <table class="table table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Manager(s)</th>
                                    <th>No. of Products</th>
                                    <th>Capacity (m<span id="super">3</span>)</th>
                                    <th>Occuppied (m<span id="super">3</span>)</th>
                                    <th>Price</th>
                                    <th>Added on</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouses as $warehouse)
                                    <tr>
                                        <td>{{ $warehouse->name }}</td>
                                        <td>{{ $warehouse->city ? $warehouse->city->name.', ' : '' }}{{ $warehouse->country->name }}</td>
                                        <td>{{ $warehouse->users_count }}</td>
                                        <td>{{ $warehouse->products_count }}</td>
                                        <td>{{ $warehouse->max_capacity }}</td>
                                        <td>{{ $warehouse->occupied_capacity }}</td>
                                        <td>{{ number_format($warehouse->price) }}</td>
                                        <td>{{ $warehouse->created_at->format('d M Y') }}</td>
                                        <td>
                                            @can('update warehouse')
                                                <a href="{{ route('warehouses.edit', ['warehouse' => $warehouse]) }}" class="btn btn-sm btn-primary btn-round waves-effect">EDIT</a>
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
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endpush
