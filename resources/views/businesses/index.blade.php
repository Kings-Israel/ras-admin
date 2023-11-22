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
                        <table class="table table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Owner</th>
                                    <th>Orders</th>
                                    <th>Products</th>
                                    <th>Approval Status</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($businesses as $business)
                                    <tr>
                                        <td>{{ $business->name }} @if($business->verified()) <i class="material-icons">verified_user</i> @endif</td>
                                        <td>{{ $business->city ? $business->city->name.', ' : '' }}{{ $business->country->name }}</td>
                                        <td>{{ $business->user->first_name }} {{ $business->user->last_name }}</td>
                                        <td>{{ $business->orders_count }}</td>
                                        <td>{{ $business->products_count }}</td>
                                        <td>
                                            <span class="{{ $business->resolveApprovalStatus() }}">{{ Str::title($business->approval_status) }}</span>
                                        </td>
                                        <td>{{ $business->created_at->format('d M Y') }}</td>
                                        <td>
                                            @role('admin')
                                                <a href="{{ route('vendors.show', ['business' => $business]) }}" class="btn btn-sm btn-primary btn-round waves-effect">View</a>
                                            @endrole
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
