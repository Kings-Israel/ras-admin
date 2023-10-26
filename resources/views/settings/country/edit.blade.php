@extends('layouts.app')
@section('content')
<section class="content home">
    <div class="container-fluid">
        <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
        <div class="clearfix">
            <div class="card">
                <div class="header">
                    <div class="d-flex justify-content-between">
                        <h2 class="my-auto"><strong>Edit {{ $country->name }}</strong></h2>
                        @can('update settings')
                            <button class="btn btn-primary btn-sm btn-round waves-effect" data-toggle="modal" data-target="#addCity_{{ $country->id }}">Add City/Town</button>
                        @endcan
                    </div>
                    @can('update settings')
                        @include('partials.admin.settings.add-city')
                    @endcan
                </div>
                @can('update settings')
                    <form class="body" action="{{ route('settings.country.update', ['country' => $country]) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <label for="role_name">Name</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $country->name }}" required autocomplete="off" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="role_name">International ISO</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="ISO" name="iso" value="{{ $country->iso }}" required autocomplete="off" />
                                        <x-input-error :messages="$errors->get('iso')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="role_name">International ISO Three</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="ISO" name="iso_three" value="{{ $country->iso_three }}" required autocomplete="off" />
                                        <x-input-error :messages="$errors->get('iso_three')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-round waves-effect">SAVE CHANGES</button>
                            <a href="{{ route('settings.index') }}" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">BACK</a>
                        </div>
                    </form>
                @endcan
            </div>
            <livewire:admin.settings.country-cities-list :country="$country" />
        </div>
    </div>
</section>
@endsection
