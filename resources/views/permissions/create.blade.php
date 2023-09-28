@extends('layouts.app')
@section('content')
<section class="content home">
    <div class="container-fluid">
        <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
        <div class="clearfix">
            <div class="card">
                <div class="header">
                    <h2><strong>Add New Role</strong></h2>
                </div>
                <div class="body">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <label for="role_name">Role Name</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name" name="role_name" />
                                    <x-input-error :messages="$errors->get('role_name')" class="mt-2 list-unstyled"></x-input-error>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-sm-6 col-md-3 checkbox">
                                    <input id="permission_{{ $permission->id }}" type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                                    <label for="permission_{{ $permission->id }}">
                                        {{ Str::title($permission->name) }}
                                    </label>
                                    <x-input-error :messages="$errors->get('permissions[]')" class="mt-2"></x-input-error>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
