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
                    <div class="header">
                        <h2><strong>{{ Str::title($page) }}</strong></h2>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Product Owner</th>
                                    <th>Price</th>
                                    <th>Warehouse</th>
                                    <th>Added On</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    @can('view', $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->business->name }}</td>
                                            <td>{{ $product->price ? $product->price : $product->min_price.' - '.$product->max_price }}</td>
                                            <td>{{ $product->warehouse }}</td>
                                            <td>{{ $product->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary btn-round waves-effect">DETAILS</a>
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
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endpush
