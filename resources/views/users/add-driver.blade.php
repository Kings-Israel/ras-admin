@extends('layouts.app')
@section('css')

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
                        <form action="{{ route('users.drivers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-6">
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
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="cost_description_file">Upload Profile Photo</label>
                                                <input type="file" accept=".jpg,.jpeg,.png" name="avatar" class="form-control" id="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="select-warehouse">Select Warehouse</label>
                                    <div class="form-group">
                                        <select name="warehouses[]" id="user" class="form-control" multiple>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('warehouses')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <label for="ID Number">ID Number</label>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="id_number" value="{{ old('id_number') }}">
                                                <x-input-error :messages="$errors->get('id_number')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="Last Name">Vehicle Type</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="vehicle_type" value="{{ old('vehicle_type') }}">
                                                <x-input-error :messages="$errors->get('vehicle_type')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="email">Vehicle Regstration Number</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="vehicle_registration_number" value="{{ old('vehicle_registration_number') }}">
                                                <x-input-error :messages="$errors->get('vehicle_registration_number')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="Phone Number">Vehicle Load Capacity</label>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" name="vehicle_load_capacity" value="{{ old('vehicle_load_capacity') }}">
                                                <x-input-error :messages="$errors->get('vehicle_load_capacity')" class="mt-2 list-unstyled"></x-input-error>
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
@endpush
@endsection
