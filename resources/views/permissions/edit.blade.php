@extends('layouts.app')
@section('content')
<section class="content home">
    <div class="container-fluid">
        <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
        <div class="clearfix">
            <div class="card">
                <div class="header">
                    <h2><strong>Edit {{ Str::title($role->name) }} Role</strong></h2>
                </div>
                <div class="body">
                    <form action="{{ route('permissions.update', ['role' => $role]) }}" method="POST">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <label for="role_name">Role Name</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name" name="name" value="{{ Str::title($role->name) }}" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @php($role_permissions = $role->permissions->pluck('id')->toArray())
                            @foreach ($permissions as $permission)
                                <div class="col-sm-6 col-md-3 checkbox">
                                    <input id="permission_{{ $permission->id }}" type="checkbox" name="permissions[]" value="{{ $permission->name }}" @if(in_array($permission->id, $role_permissions)) checked @endif>
                                    <label for="permission_{{ $permission->id }}">
                                        {{ Str::title($permission->name) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">UPDATE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
