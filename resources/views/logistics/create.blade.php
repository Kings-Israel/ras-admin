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
                        <form action="{{ route('logistics.store') }}" method="POST">
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
@push('scripts')
@endpush
@endsection
