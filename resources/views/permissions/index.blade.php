@extends('layouts.app')
@section('content')
<section class="content home">
    <div class="container-fluid">
        <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
        <div class="clearfix">
            <div class="card">
                <div class="header">
                    <div class="d-flex justify-content-between">
                        <h2 class="my-auto"><strong>Roles</strong></h2>
                        <a href="{{ route('permissions.create') }}" class="btn btn-secondary btn-sm">Add Role</a>
                    </div>
                </div>
                <div class="body table-responsive">
                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>NO. OF PERMISSIONS</th>
                                <th>NO. OF USERS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ Str::title($role->name) }}</td>
                                    <td>{{ $role->permissions_count }}</td>
                                    <td>{{ $role->users_count }}</td>
                                    <td>
                                        <div class="flex mx-2">
                                            <a href="{{ route('permissions.edit', ['role' => $role]) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
