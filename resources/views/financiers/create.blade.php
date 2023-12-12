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
                        <form action="{{ route('financing.institutions.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-6">
                                    <label for="name">Institution Name</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Institution's Name" name="institution_name" value="{{ old('institution_name') }}" required autocomplete="off" />
                                        <x-input-error :messages="$errors->get('institution_name')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="Institution Email">Institution Email</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="institution_email" :value="old('institution_email')">
                                        <x-input-error :messages="$errors->get('institution_email')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="Institution Phone Number">Institution Phone Number</label>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" name="institution_phone_number" :value="old('institution_phone_number')">
                                        <x-input-error :messages="$errors->get('institution_phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
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
                                <div class="col-6">
                                    <label for="country">Credit Limit</label>
                                    <div class="form-group">
                                        <input type="number" name="credit_limit" id="" class="form-control" :value="old('credit_limit')" min="10" placeholder="Enter amount limit which the financier can facilitate">
                                        <x-input-error :messages="$errors->get('credit_limit')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                {{-- <div class="col-6">
                                    <label for="city">City</label>
                                    <div class="form-group">
                                        <select name="city_id" id="institution_city_id" class="form-control show-tick">
                                            <option value="">Select City</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('city_id')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div> --}}
                            </div>
                            <br>
                            <h6 class="header">Select Maker or Add New Maker</h6>
                            <div class="row clearfix">
                                <div class="col-6">
                                    <label for="maker">Select Maker</label>
                                    <div class="form-group">
                                        <select name="maker_user" id="maker_user" class="form-control">
                                            <option value="">Select Maker</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('maker_user')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="header font-bold">Add New Maker User</div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <label for="First Name">First Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="maker_first_name" value="{{ old('maker_first_name') }}">
                                                <x-input-error :messages="$errors->get('maker_first_name')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="Last Name">Last Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="maker_last_name" value="{{ old('maker_last_name') }}">
                                                <x-input-error :messages="$errors->get('maker_last_name')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="email">Email</label>
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="maker_email" value="{{ old('maker_email') }}">
                                                <x-input-error :messages="$errors->get('maker_email')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="Phone Number">Phone Number</label>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" name="maker_phone_number" value="{{ old('maker_phone_number') }}">
                                                <x-input-error :messages="$errors->get('maker_phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6 class="header">Select Checker or Add New Checker</h6>
                            <div class="row clearfix">
                                <div class="col-6">
                                    <label for="checker">Select Checker</label>
                                    <div class="form-group">
                                        <select name="checker_user" id="checker_user" class="form-control">
                                            <option value="">Select Checker</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('checker_user')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="header font-bold">Add New Checker User</div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <label for="First Name">First Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="checker_first_name" value="{{ old('checker_first_name') }}">
                                                <x-input-error :messages="$errors->get('checker_first_name')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="Last Name">Last Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="checker_last_name" value="{{ old('checker_last_name') }}">
                                                <x-input-error :messages="$errors->get('checker_last_name')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="email">Email</label>
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="checker_email" value="{{ old('checker_email') }}">
                                                <x-input-error :messages="$errors->get('checker_email')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="Phone Number">Phone Number</label>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" name="checker_phone_number" value="{{ old('checker_phone_number') }}">
                                                <x-input-error :messages="$errors->get('checker_phone_number')" class="mt-2 list-unstyled"></x-input-error>
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
                                <button type="submit" class="btn btn-primary btn-round waves-effect">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script>
    function getCities() {
        let cities = $('#country').find(':selected').data('cities');
        let cityOptions = document.getElementById('institution_city_id')
        console.log(cityOptions)
        while (cityOptions.options.length) {
            cityOptions.remove(0);
        }
        var city = new Option('Select City', '');
        cityOptions.options.add(city);
        if (cities) {
            cities.forEach(city => {
                var city_option = new Option(city.name, city.id);
                cityOptions.options.add(city_option);
            })
        }
    }
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
@endsection
