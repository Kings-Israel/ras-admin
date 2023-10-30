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
{{--                            @can('create packaging')--}}
                                <a class="btn btn-secondary btn-sm" href="{{ route('packaging.create') }}">Add Packaging</a>
{{--                            @endcan--}}
                        </div>
                        <div class="body">
                            <table class="table table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>UOM</th>
                                    <th>Added on</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($packagings as $packaging)
                                    <tr>
                                        <td>{{ $packaging->name ?? ''}}</td>
                                        <td>{{ $packaging->description ?? ''}}</td>
                                        <td>{{ $packaging->unit_of_measurement ?? ''}}</td>
                                        <td>{{ $packaging->created_at->format('d M Y') ?? now()}}</td>
                                        <td>
                                            @can('update packaging')
                                                <a href="{{ route('packaging.edit', ['packaging' => $packaging]) }}" class="btn btn-sm btn-primary btn-round waves-effect">EDIT</a>
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
