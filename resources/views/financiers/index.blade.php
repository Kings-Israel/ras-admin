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
                        @can('create financier')
                            <a class="btn btn-secondary btn-sm" href="{{ route('financing.institutions.create') }}">Add Financing Institution</a>
                        @endcan
                    </div>
                    <div class="body">
                        <table class="table table-hover dataTable js-exportable" id="financiers">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Admin(s)</th>
                                    <th>No. of Pending Requests</th>
                                    <th>No. of Processed Requests</th>
                                    <th>Added on</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($financing_institutions as $institution)
                                    <tr>
                                        <td>{{ $institution->name }}</td>
                                        <td>{{ $institution->city ? $institution->city->name.', ' : '' }}{{ $institution->country->name }}</td>
                                        <td>{{ $institution->users_count }}</td>
                                        <td>{{ $institution->financingRequests()->where('status', 'pending')->count() }}</td>
                                        <td>{{ $institution->financingRequests()->where('status', 'accepted')->count() }}</td>
                                        <td>{{ $institution->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="btn-group" x-data="{ open: false }">
                                                <button class="mr-2 btn btn-primary btn-sm btn-round waves-effect dropdown-toggle" type="button"
                                                    x-on:click="open = ! open">
                                                    <i data-feather="eye"></i>
                                                    Actions
                                                </button>
                                                <div
                                                    x-cloak
                                                    x-show="open"
                                                    x-transition
                                                    @click.away="open = false"
                                                    @keydown.escape.window = "open = false"
                                                    class="search-results"
                                                >
                                                    @can('update financier')
                                                        <a class="dropdown-item" href="{{ route('financing.institutions.edit', ['financing_institution' => $institution]) }}" >
                                                            <span>Edit Details</span>
                                                        </a>
                                                    @endcan
                                                    @can('view financier')
                                                        <a class="dropdown-item" href="{{ route('financing.institutions.show', ['financing_institution' => $institution]) }}">
                                                            <span>View Details</span>
                                                        </a>
                                                    @endcan
                                                    @can('view financing requests')
                                                        <a class="dropdown-item" href="#">
                                                            <span>Financing Requests</span></a>
                                                        </a>
                                                    @endcan
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
    <script>
        $('#financiers').DataTable({
            paging: true,
            ordering: true,
        })
    </script>
@endpush
