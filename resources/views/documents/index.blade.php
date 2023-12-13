@extends('layouts.app')
@section('content')
<section class="content home">
    <div class="container-fluid">
        <x-breadcrumbs :items="$breadcrumbs"></x-breadcrumbs>
        <div class="clearfix">
            <div class="card">
                <div class="header">
                    <div class="d-flex justify-content-between">
                        <h2 class="my-auto"><strong>Documents</strong></h2>
                        <a class="btn btn-secondary btn-sm" href="#defaultModal" data-toggle="modal" data-target="#defaultModal">Add Document</a>
                    </div>
                </div>
                <div class="body table-responsive">
                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>NO. OF COUNTRIES</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td>{{ Str::title($document->name) }}</td>
                                    <td>{{ $document->countries_count > 0 ? $document->countries_count : $countries->count().' - (ALL)' }}</td>
                                    <td>
                                        <div class="flex mx-2">
                                            {{-- <a href="#defaultModal_{{ $document->id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#defaultModal_{{ $document->id }}">Edit</a> --}}
                                            <a href="{{ (route('documents.edit', ['document' => $document])) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ route('documents.delete', ['document' => $document]) }}">
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="defaultModal_{{ $document->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel">Edit Document</h4>
                                                <span>*These documents will be uploaded during vendor onboarding</span>
                                            </div>
                                            <form action="{{ route('documents.update', ['document' => $document]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <select name="countries">
                                                        <option value="test">test</option>
                                                        <option value="all">all</option>
                                                    </select>
                                                    {{-- <div class="row clearfix">
                                                        <div class="col-sm-6">
                                                            <label for="role_name">Document Name</label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" placeholder="Name" name="document_name" value="{{ $document->name }}" required autocomplete="off" />
                                                                <x-input-error :messages="$errors->get('document_name')" class="mt-2 list-unstyled"></x-input-error>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="expiry_date_required_label">Expiry Date Required</label>
                                                            <div class="form-group">
                                                                <div class="radio inlineblock m-r-20">
                                                                    <input type="radio" name="expiry_date_required" id="yes_{{ $document->id }}" class="with-gap" value="true" @if($document->requires_expiry_date) checked @endif>
                                                                    <label for="yes_{{ $document->id }}">Yes</label>
                                                                </div>
                                                                <div class="radio inlineblock">
                                                                    <input type="radio" name="expiry_date_required" id="no_{{ $document->id }}" class="with-gap" value="false" @if(!$document->requires_expiry_date) checked @endif>
                                                                    <label for="no_{{ $document->id }}">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    {{-- <div class="">
                                                        <label for="role_name">Select Countries where document is required</label>
                                                        @php($selected_countries = $document->countries_count > 0 ? $document->countries->pluck('id')->toArray() : [])
                                                        <select name="updated_countries[]" class="form-control show-tick" id="update_countries" data-live-search="true" multiple>
                                                            <option value="all" @if(count($selected_countries) === 0) selected @endif>All</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}" @if(in_array($country->id, $selected_countries)) selected @endif>{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> --}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary btn-round waves-effect">SAVE CHANGES</button>
                                                    <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
            <form action="{{ route('documents.store') }}" method="POST">
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
