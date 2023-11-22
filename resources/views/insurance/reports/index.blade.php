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
                        <table class="table table-hover dataTable js-exportable" id="insurance_reports">
                            <thead>
                                <tr>
                                    <th>ORDER ID</th>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Created On</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insurance_reports as $insurance_report)
                                    <tr>
                                        <td>{{ $insurance_report->orderItem->order->order_id }}</td>
                                        <td>{{ $insurance_report->orderItem->product->name }}</td>
                                        <td>{{ $insurance_report->orderItem->order->user->first_name }} {{ $insurance_report->orderItem->order->user->last_name }}</td>
                                        <td>{{ $insurance_report->created_at->format('d M Y') }}</td>
                                        <td>
                                            @can('view inspection report')
                                                <a href="#viewInspectionReport_{{ $insurance_report->id }}" data-toggle="modal" data-target="#viewInspectionReport_{{ $insurance_report->id }}" class="btn btn-sm btn-primary btn-round waves-effect">VIEW</a>
                                                <div class="modal fade" id="viewInspectionReport_{{ $insurance_report->id }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="title" id="uploadInspectionDocumentsLabel">{{ $insurance_report->orderItem->product->name }} Inspection Reprt</h4>
                                                            </div>
                                                            <iframe src="{{ $insurance_report->report_file }}" class="w-[100%]" style="height: 600px"></iframe>
                                                        </div>
                                                    </div>
                                                </div>
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
        $('#insurance_reports').DataTable().order([4, 'desc']).draw()
    </script>
@endpush
