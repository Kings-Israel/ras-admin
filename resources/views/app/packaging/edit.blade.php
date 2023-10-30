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
                            <form action="{{ route('packaging.update', ['packaging' => $packaging->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="row clearfix">
                                    <div class="col-6">
                                        <label for="name">Packaging Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Packaging Name" name="name" value="{{ $packaging->name }}" required autocomplete="off" />
                                            <x-input-error :messages="$errors->get('name')" class="mt-2 list-unstyled"></x-input-error>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="name">Description</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Packaging Description" name="description" value="{{ $packaging->description }}" autocomplete="off" />
                                            <x-input-error :messages="$errors->get('description')" class="mt-2 list-unstyled"></x-input-error>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="name">Unit Of Measurement</label>
                                        <div class="form-group">
                                            <select name="uom" id="uom" class="form-control select2"  required>
                                                <option value="">Select UOM</option>
                                                @foreach ($uom as $u)
                                                    <option value="{{ $u->name }}" @if($u->name == $packaging->unit_of_measurement) selected @endif>{{ $u->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('uom')" class="mt-2 list-unstyled"></x-input-error>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-round waves-effect">UPDATE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
