@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <style>
        #super{
            vertical-align:super;
            font-size: smaller;
        }
        .search-results {
            position: absolute;
            z-index: 99;
            background: #c2c2c2;
            border-radius: 10px;
            width: 180px;
            margin-top: 15px;
            margin-left: -20px;
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
                    <div class="header d-flex justify-content-between">
                        <h2><strong>{{ Str::title($page) }}</strong></h2>
                        @can('create warehouse')
                            <a class="btn btn-secondary btn-sm" href="{{ route('warehouses.create') }}">Add Warehouse</a>
                        @endcan
                    </div>
                    <div class="body">
                        <table class="table table-hover dataTable js-exportable" id="warehouses">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Manager(s)</th>
                                    <th>No. of Products</th>
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
                                        <td>{{ number_format($warehouse->price) }}</td>
                                        <td>{{ $warehouse->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="btn-group" x-data="{ open: false }">
                                                <button class="mr-2 btn btn-primary btn-sm dropdown-toggle" type="button"
                                                    x-on:click="open = ! open">
                                                    <i data-feather="eye"></i>
                                                    Action
                                                </button>
                                                <div
                                                    x-cloak
                                                    x-show="open"
                                                    x-transition
                                                    @click.away="open = false"
                                                    @keydown.escape.window = "open = false"
                                                    class="search-results"
                                                >
                                                    @can('update warehouse')
                                                        <a class="dropdown-item" href="{{ route('warehouses.edit', ['warehouse' => $warehouse->id]) }}" >
                                                            {{-- <i data-feather='edit' class="btn btn-sm btn-primary waves-effect"></i> --}}
                                                            <span>Edit</span>
                                                        </a>
                                                    @endcan

                                                    @can('view warehouse')
                                                        <a class="dropdown-item" href="#">
                                                            <span>View</span>
                                                        </a>
                                                    @endcan
                                                    <a class="dropdown-item" href="{{ route('warehouses.storage.requests.index', ['warehouse' => $warehouse->id]) }}">
                                                        <span>Storage Requests</span></a>
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('warehouses.orders.index', ['warehouse' => $warehouse->id]) }}">
                                                        <span>Orders</span></a>
                                                    </a>
                                                </div>
                                            </div>
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
        $('#warehouses').DataTable({
            paging: true,
            ordering: true,
        })
    </script>
@endpush
