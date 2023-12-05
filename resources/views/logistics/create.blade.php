@extends('layouts.app')
@section('css')
<style>
    #gmap_markers {
        height: 380px;
    }
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
                    <div class="header">
                        <h2><strong>{{ Str::title($page) }}</strong></h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('logistics.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-6">
                                    <label for="name">Company Name</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Company Name" name="company_name" value="{{ old('company_name') }}" required autocomplete="off" />
                                        <x-input-error :messages="$errors->get('company_name')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="Company Email">Company Email</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="company_email" :value="old('company_email')" min="1">
                                        <x-input-error :messages="$errors->get('company_email')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="Company Phone Number">Company Phone Number</label>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" name="company_phone_number" :value="old('company_phone_number')" min="1">
                                        <x-input-error :messages="$errors->get('company_phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="country">Transportation Methods</label>
                                    <select name="transportation_methods[]" class="form-control show-tick" id="transportation_method" multiple>
                                        @foreach ($transportation_methods as $method)
                                            <option value="{{ $method }}" @if(old('transportation_methods') && in_array($method, old('transportation_methods'))) selected @endif>{{ $method }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('country_id')" class="mt-2 list-unstyled"></x-input-error>
                                </div>
                                <div class="col-6">
                                    <label for="country">Country</label>
                                    <select name="country_id" class="form-control show-tick" id="country">
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
                            <h6 class="header">Select Company Admin or Add New User as Admin</h6>
                            <div class="row clearfix">
                                <div class="col-6">
                                    <label for="manager">Select User</label>
                                    <div class="form-group">
                                        <select name="users_ids[]" id="user" class="form-control" multiple>
                                            <option value="">Select Manager</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('users_ids')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="header">Add New User</div>
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
                                        <div class="form-group mr-3">
                                            <input type="radio" name="service_charge_type" value="amount" class="" id="">
                                            <label for="">Amount</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="radio" name="service_charge_type" value="percentage" class="" id="">
                                            <label for="">Percentage</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
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
                                        {{-- <div class="col-2">
                                            <button type="button" class="btn btn-round btn-danger btn-sm">Remove</button>
                                        </div> --}}
                                    </div>
                                @endfor
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-round waves-effect">SUBMIT</button>
                            </div>
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
