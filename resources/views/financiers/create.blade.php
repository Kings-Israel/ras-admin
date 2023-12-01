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
                        <form action="{{ route('financing.institutions.store') }}" method="POST">
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
</script>
@endpush
@endsection
