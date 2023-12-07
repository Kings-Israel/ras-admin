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
        .form-control .form-control-sm {
            border: none !important;
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
                        <a class="btn btn-secondary btn-sm btn-round" href="{{ route('insurance.companies.create') }}">Add Insurance Company</a>
                    </div>
                    <div class="body">
                        <table class="table table-hover dataTable js-exportable" id="insurers">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Admin(s)</th>
                                    <th>No. of Pending Reports</th>
                                    <th>No. of Completed Reports</th>
                                    <th>Added on</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insurers as $insurer)
                                    <tr>
                                        <td>{{ $insurer->name }}</td>
                                        <td>{{ $insurer->country ? $insurer->country->name : '' }}</td>
                                        <td>{{ $insurer->users_count }}</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>{{ $insurer->created_at->format('d M Y') }}</td>
                                        <td>
                                            {{-- <a href="#" class="btn btn-sm btn-primary btn-round waves-effect">Edit</a> --}}
                                            <div class="btn-group" x-data="{ open: false }">
                                                <button class="mr-2 btn btn-primary btn-sm dropdown-toggle btn-round" type="button"
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
                                                    @can('update insurance company')
                                                        <a class="dropdown-item" href="#" >
                                                            <span>Edit</span>
                                                        </a>
                                                    @endcan

                                                    @can('view insurance company')
                                                        <a class="dropdown-item" href="#">
                                                            <span>View</span>
                                                        </a>
                                                    @endcan

                                                    @can('view insurance request')
                                                        <a class="dropdown-item" href="#">
                                                            <span>Insurance Requests</span>
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
    {{-- <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script> --}}
    <script>
        $('#insurers').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        })
        .order([5, 'desc'])
        .draw();
    </script>
@endpush
