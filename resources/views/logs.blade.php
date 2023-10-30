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
                    {{-- <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="logs">
                            <thead>
                                <tr>
                                    <th>Log</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        @if ($log->subject && $log->subject_type == App\Models\Product::class)
                                            <td>{{ $log->causer->first_name }} {{ $log->causer->last_name }} {{ $log->description }} {{ $log->subject->name }}</td>
                                        @else
                                            <td>{{ $log->causer->first_name }} {{ $log->causer->last_name }} {{ $log->description }}</td>
                                        @endif
                                        <td>{{ $log->created_at->format('d M Y H:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> --}}
                    <livewire:admin.logs.logs-list />
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
        $('#logs').DataTable( {
            ordering: true
        } );
    </script>
@endpush
