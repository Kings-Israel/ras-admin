@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header d-flex justify-content-between">
                        <h2><strong>{{ Str::title($page) }}</strong></h2>
                    </div>
                    <div class="body">
                        <table class="table table-hover dataTable js-exportable" id="inspection_requests">
                            <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Customer</th>
                                    <th>Payment Status</th>
                                    @role('admin')
                                        <th>Inspector</th>
                                    @endrole
                                    <th>Requested On</th>
                                    <th>Completed On</th>
                                    @can('view inspection report')
                                        <th>Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inspection_reports as $inspection_report)
                                    <tr>
                                        <td>{{ $inspection_report->orderItem->order->order_id }}</td>
                                        <td>{{ $inspection_report->orderItem->order->user->first_name }} {{ $inspection_report->orderItem->order->user->last_name }}</td>
                                        <td>{{ Str::title($inspection_report->orderItem->order->invoice->payment_status) }}</td>
                                        @role('admin')
                                            <td>{{ $inspection_report->inspectingInstitution->name }}</td>
                                        @endrole
                                        <td>{{ $inspection_report->orderItem->created_at->format('d M Y') }}</td>
                                        <td>{{ $inspection_report->created_at->format('d M Y') }}</td>
                                        <td>
                                            @can('view', $inspection_report)
                                                <a href="#defaultModal-{{ $inspection_report->id }}" data-toggle="modal" data-target="#defaultModal-{{ $inspection_report->id }}" class="btn btn-sm btn-primary btn-round waves-effect">View Report</a>
                                                <div class="modal fade" id="defaultModal-{{ $inspection_report->id }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header flex justify-content-bewteen">
                                                                <h4 class="title" id="defaultModalLabel">Inspection Report</h4>
                                                                <div class="flex">
                                                                    <span class="mr-2">Product Validity:</span>
                                                                    <span class="badge {{ $inspection_report->resolveValidityStatus() }}">{{ Str::title($inspection_report->product_validity) }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row clearfix">
                                                                    {{-- Applicant --}}
                                                                    <div class="col-12">
                                                                        <h5 style="margin-bottom: -6px; text-decoration: underline">Applicant</h5>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">Applicant Company Name</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->applicant_company_name }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">Applicant Company Address</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->applicant_company_address }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="Max Capacity">Applicant Company Email</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->applicant_company_email }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="Max Capacity">Applicant Company Phone Number</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->applicant_company_phone_number }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">Applicant Company Contact Person</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->applicant_company_contact_person }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">Applicant Company Contact Person Email</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->applicant_company_contact_person_email }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="Max Capacity">Applicant Company Contact Person Phone Number</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->applicant_company_contact_person_phone_number }}</h6>
                                                                    </div>
                                                                    {{-- End Applicant --}}
                                                                    <hr>
                                                                    {{-- License Holder --}}
                                                                    <div class="col-12">
                                                                        <h5 style="margin-bottom: -6px; margin-top: 10px; text-decoration: underline">License Holder</h5>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">License Company Name</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->license_holder_company_name }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">License Company Address</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->license_holder_company_address }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="Max Capacity">License Company Email</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->license_holder_company_email }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="Max Capacity">License Company Phone Number</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->license_holder_company_phone_number }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">Licenst Company Contact Person</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->license_holder_company_contact_person }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">License Company Contact Person Email</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->license_holder_company_contact_person_email }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="Max Capacity">License Company Contact Person Phone Number</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->license_holder_company_contact_person_phone_number }}</h6>
                                                                    </div>
                                                                    {{-- End License Holder --}}
                                                                    <hr>
                                                                    {{-- Place of Manufacture --}}
                                                                    <div class="col-12">
                                                                        <h5 style="margin-bottom: -6px; margin-top: 10px; text-decoration: underline">Place of Manufacture</h5>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">Place of Manufacture Company Name</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->place_of_manufacture_company_name }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">Place of Manufacture Company Address</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->place_of_manufacture_company_address }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="Max Capacity">Place of Manufacture Company Email</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->place_of_manufacture_company_email }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="Max Capacity">Place of Manufacture Company Phone Number</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->place_of_manufacture_company_phone_number }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">Place of Manufacture Company Contact Person</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->place_of_manufacture_company_contact_person }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">Place of Manufacture Company Contact Person Email</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->place_of_manufacture_company_contact_person_email }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="Max Capacity">Place of Manufacture Company Contact Person Phone Number</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->place_of_manufacture_company_contact_person_phone_number }}</h6>
                                                                    </div>
                                                                    {{-- End place of Manufacture --}}
                                                                    <hr>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="Max Capacity">Place of Manufacture Inspection Done By</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->place_of_manufacture_factory_inspection_done_by }}</h6>
                                                                    </div>
                                                                    <hr>
                                                                    {{-- Product --}}
                                                                    <div class="col-12">
                                                                        <h5 style="margin-bottom: -6px; margin-top: 10px; text-decoration: underline">Product</h5>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">Product</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->product }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="name">Product Type Ref</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->product_type_ref }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                        <label for="Max Capacity">Product Trademark</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->product_trade_mark }}</h6>
                                                                    </div>
                                                                    {{-- End Product --}}
                                                                    <hr>
                                                                    <div class="col-12">
                                                                        <label for="Max Capacity">Product Ratings and Principle Characteristics</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->product_ratings_and_principle_characteristics }}</h6>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="Max Capacity">Differences From Previously Certified Product</label>
                                                                        <h6>{{ $inspection_report->orderItem->inspectionReport->differences_from_previously_certified_product }}</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="{{ $inspection_report->report_file }}" target="_blank" class="btn btn-primary btn-round waves-effect">View Report File</a>
                                                                @if ($inspection_report->applicant_signature && $inspection_report->applicant_signature != config('app.url').'/storage/reports/inspection/')
                                                                    <a href="{{ $inspection_report->applicant_signature }}" target="_blank" class="btn btn-signature btn-round waves-effect">View Signature</a>
                                                                @endif
                                                                <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                                            </div>
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
        $('#inspection_requests').DataTable().order([4, 'desc']).draw()
    </script>
@endpush
