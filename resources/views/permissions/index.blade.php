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
                <livewire:admin.roles.roles-list />
            </div>
        </div>
    </div>
</section>
@endsection
