@extends('layouts.app')
@section('css')
<style>
    .form-control {
        border: 1px solid #9c9c9c !important;
    }

    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 100% !important;
    }

    .bootstrap-select .btn {
        border: 1px solid #9c9c9c !important;
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
                    <div class="header">
                        <h2><strong>{{ Str::title($page) }}</strong></h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('inspectors.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-5">
                                    <label for="name">Name</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Name" name="name" value="{{ old('name') }}" required autocomplete="off" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="Max Capacity">Email (<span id="text-sm">Inspection Co. Email</span>)</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="inspector_email" :value="old('inspector_email')" min="1">
                                        <x-input-error :messages="$errors->get('inspector_email')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="Max Capacity">Phone Number (<span id="text-sm">Company Phone Number</span>)</label>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" name="inspector_phone_number" :value="old('inspector_phone_number')" min="1">
                                        <x-input-error :messages="$errors->get('inspector_phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="country">Country</label>
                                    <select name="country_id" class="show-tick" id="country">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif data-cities="{{ $country->cities }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('country_id')" class="mt-2 list-unstyled"></x-input-error>
                                </div>
                                {{-- <div class="col-6">
                                    <label for="city">City</label>
                                    <div class="form-group">
                                        <select name="city_id" id="city_id" class="form-control show-tick">
                                            <option value="">Select City</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('city_id')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div> --}}
                            </div>
                            <br>
                            <h6 class="header">Select User or Add New Inspector Admin</h6>
                            <div class="row clearfix">
                                <div class="col-6">
                                    <label for="manager">Select User</label>
                                    <div class="form-group">
                                        <select name="users[]" id="user" class="form-select" multiple>
                                            <option value="">Select User</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('users')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="header font-bold">Add New Inspector Admin</div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <label for="First Name">First Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                                                <x-input-error :messages="$errors->get('first_name')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="Last Name">Last Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                                                <x-input-error :messages="$errors->get('last_name')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="email">Email</label>
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                                <x-input-error :messages="$errors->get('email')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="Phone Number">Phone Number</label>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
                                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-4">
                                    <h6>Enter Service Charge Rate</h6>
                                    <input type="number" name="service_charge_rate" id="" class="form-control" min="1">
                                </div>
                                <div class="col-4">
                                    <h6>Select Charge Type</h6>
                                    <div class="d-flex">
                                        <div class="form-group mr-1">
                                            <input type="radio" name="service_charge_type" value="amount" class="form-group" id="">
                                            <label for="">Amount</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="service_charge_type" value="percentage" class="form-group" id="">
                                            <label for="">Percentage</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex">
                                <h6>Add Wallet Information</h6>
                            </div>
                            <div class="wallet row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="">Wallet Account Number</label>
                                    <input type="number" name="wallet_account_number" class="form-control" id="" placeholder="Enter Wallet Account Number">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="">Currencies (separated by commas ',')</label>
                                    <input type="text" name="wallet_currencies" class="form-control" id="" placeholder="Enter Currencies used in the wallet">
                                </div>
                            </div>
                            <div class="d-flex">
                                <h6>Add KYC Documents</h6>
                                <button type="button" id="add_document" class="btn btn-sm btn-round btn-secondary waves-effect ml-2">Add Document</button>
                            </div>
                            <div class="documents">
                                @for ($i = 1; $i <= $documents_count; $i++)
                                    <div class="row clearfix">
                                        <div class="col-6">
                                            <label for="document_name">Document Name</label>
                                            <div class="form-group">
                                                <input type="text" name="document_name[{{ $i }}]" id="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="document">Document</label>
                                            <div class="form-group">
                                                <input type="file" accept=".pdf" name="document_file[{{ $i }}]" id="" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-round waves-effect">Submit</button>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    let documents = $('.documents')
    let documents_count = {!! $documents_count !!}
    $(document.body).on('click', '#add_document', function() {
        documents_count += 1
        let new_document = '<div class="row clearfix">'
            new_document += '<div class="col-6">'
            new_document += '<label for="document_name">Document Name</label>'
            new_document += '<div class="form-group">'
            new_document += '<input type="text" name="document_name['+documents_count+']" class="form-control">'
            new_document += '</div>'
            new_document += '</div>'
            new_document += '<div class="col-6">'
            new_document += '<label for="document">Document</label>'
            new_document += '<div class="form-group">'
            new_document += '<input type="file" accept=".pdf" name="document_file['+documents_count+']" class="form-control" />'
            new_document += '</div>'
            new_document += '</div>'
            // new_document += '<div class="col-2">'
            // new_document += '<button type="button" class="btn btn-round btn-danger btn-sm">Remove</button>'
            // new_document += '</div>'
            new_document += '</div>'

        $(new_document).appendTo(documents)
    })
</script>
@endpush
