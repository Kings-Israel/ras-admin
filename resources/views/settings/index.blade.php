@extends('layouts.app')
@section('content')
<section class="content home">
    <div class="container-fluid">
        <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
        <div class="clearfix">
            <livewire:admin.settings.categories />
        </div>
        <div class="clearfix">
            <div class="card">
                <div class="header">
                    <div class="d-flex justify-content-between">
                        <h2 class="my-auto"><strong>Vendor Documents</strong></h2>
                        <a class="btn btn-secondary btn-sm" href="#defaultModal" data-toggle="modal" data-target="#defaultModal">Add Document</a>
                    </div>
                </div>
                <livewire:admin.settings.documents />
            </div>
        </div>
        <div class="clearfix">
            <div class="card">
                <div class="header">
                    <div class="d-flex justify-content-between">
                        <h2 class="my-auto"><strong>Countries</strong></h2>
                        <a class="btn btn-secondary btn-sm" href="#defaultModal" data-toggle="modal" data-target="#defaultModal">Add Country</a>
                    </div>
                </div>
                <livewire:admin.settings.countries />
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="defaultModalLabel">Add Document</h4>
                <span>*These documents will be uploaded during vendor onboarding</span>
            </div>
            <form action="{{ route('settings.document.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <label for="role_name">Document Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Name" name="document_name" :value="old('document_name')" required autocomplete="off" />
                                <x-input-error :messages="$errors->get('document_name')" class="mt-2 list-unstyled"></x-input-error>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="expiry_date_required_label">Expiry Date Required</label>
                            <div class="form-group">
                                <div class="radio inlineblock m-r-20">
                                    <input type="radio" name="expiry_date_required" id="yes" class="with-gap" value="true" @if(old('expiry_date_required' === 'true')) checked @endif>
                                    <label for="yes">Yes</label>
                                </div>
                                <div class="radio inlineblock">
                                    <input type="radio" name="expiry_date_required" id="no" class="with-gap" value="false" @if(old('expiry_date_required' === 'false')) checked @endif>
                                    <label for="no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <label for="role_name">Select Countries where document is required</label>
                        @php($old_selected_countries = collect(old('required_countries'))->count() > 0 ? old('required_countries') : [])
                        <select class="form-control show-tick" id="add_countries" data-live-search="true" multiple name="required_countries[]">
                            <option value="all" @if(in_array("all", $old_selected_countries)) selected @endif>All</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @if(in_array($country->id, $old_selected_countries)) selected @endif>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-round waves-effect">SAVE</button>
                    <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
