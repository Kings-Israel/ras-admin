@extends('layouts.app')
@section('css')
<style>
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
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="body">
                                <h4 class="d-flex"><span class="mr-2">Name:</span><strong>{{ $user->first_name }} {{ $user->last_name }}</strong></h4>
                                <h5 class="d-flex"><span class="mr-2">Email:</span><strong>{{ $user->email }}</strong></h5>
                                <h6 class="d-flex"><span class="mr-2">Phone Number:</span><strong>{{ $user->phone_number }}</strong></h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="body">
                                <h6 class="d-flex"><span class="mr-2">Registered On:</span><strong>{{ $user->created_at->format('D M Y') }}</strong></h6>
                                <h6 class="d-flex"><span class="mr-2">No. of orders:</span><strong>0</strong></h6>
                            </div>
                            <br>
                            @if ($user->roles->count() > 0)
                                <div class="body">
                                    <div class="card-title">Roles:</div>
                                    @foreach ($user->roles as $role)
                                        @if ($loop->last)
                                            <h6 class="">{{ $role->name }}</h6>
                                        @else
                                            <h6 class="">{{ $role->name }},</h6>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    @if ($user->hasRole('vendor'))
                        <br>
                        <div class="body">
                            <h5 class="card-title">Business Details</h5>
                            @if (!$user->business)
                                <strong>User has not registered business</strong>
                            @else
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <h6 class="d-flex"><span class="mr-2">Name:</span><strong>{{ $user->business->name }}</strong></h6>
                                        <h6 class="d-flex"><span class="mr-2">Email:</span><strong>{{ $user->business->contact_email }}</strong></h6>
                                        <h6 class="d-flex"><span class="mr-2">Phone Number:</span><strong>{{ $user->business->contact_phone_number }}</strong></h6>
                                        <h6 class="d-flex">
                                            <span class="mr-2">Location:</span>
                                            <strong>{{ $user->business->city ? $user->business->city->name.', ' : '' }}{{ $user->business->country->name }}</strong>
                                        </h6>
                                        @if ($user->business->mission)
                                            <h6 class="d-flex"><span class="mr-2">Mission:</span><span>{{ $user->business->mission }}</span></h6>
                                        @endif
                                        @if ($user->business->vision)
                                            <h6 class="d-flex"><span class="mr-2">Vision:</span><span>{{ $user->business->vision }}</span></h6>
                                        @endif
                                        @if ($user->business->about)
                                            <h6 class="d-flex"><span class="mr-2">About:</span><span>{{ $user->business->about }}</span></h6>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div>
                                            <p>Cover Images</p>
                                            <img src="{{ $user->business->primary_cover_image }}" alt="{{ $user->business->name }}" width="120" height="120" style="object-fit: contain; border-radius: 10px">
                                            @if ($user->business->secondary_cover_image)
                                                <img src="{{ $user->business->secondary_cover_image }}" alt="{{ $user->business->name }}" width="120" height="120" style="object-fit: contain; border-radius: 10px">
                                            @endif
                                        </div>
                                        <hr>
                                        <div>
                                            <p>Business Documents</p>
                                            @foreach ($user->business->documents as $document)
                                                <a class="btn btn-primary" href="{{ $document->file }}" target="_blank">{{ $document->name }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <br>
                    @if ($user->hasRole('vendor'))
                        <div class="body">
                            <h5 class="card-title">Products</h5>
                            @if ($user->business && $user->business->products->count() > 0)
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Warehouse</th>
                                            <th>Added On</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->business->products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->price ? $product->price : $product->min_price.' - '.$product->max_price }}</td>
                                                <td>{{ $product->warehouse }}</td>
                                                <td>{{ $product->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary btn-round waves-effect">DETAILS</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <strong>No Products Uploaded</strong>
                            @endif
                        </div>
                    @endif
                    @if (!$user->hasRole('buyer') && !$user->hasRole('vendor'))
                        <div class="body">
                            @if ($user->getDirectPermissions()->count() != 0)
                                <h5 class="card-title">Direct Permissions</h5>
                                <div class="row">
                                    @foreach ($user->getDirectPermissions() as $permission_item)
                                        <div class="col-sm-6 col-md-3">
                                            <label for="permission_{{ $permission_item->id }}">
                                                {{ Str::title($permission_item->name) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <br>
                            @endif
                            @if ($user->getPermissionsViaRoles()->count() != 0)
                                <h5 class="card-title">Permissions from Role</h5>
                                <div class="row">
                                    @foreach ($user->getPermissionsViaRoles() as $permission_item)
                                        <div class="col-sm-6 col-md-3">
                                            <label for="permission_{{ $permission_item->id }}">
                                                {{ Str::title($permission_item->name) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @if ($user->driverProfile)
                            <div class="body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <span class="mr-2">Vehicle Type</span>
                                            <h6>{{ $user->driverProfile->vehicle_type }}</h6>
                                        </div>
                                        <div class="d-flex">
                                            <span class="mr-2">Vehicle Registration Number</span>
                                            <h6>{{ $user->driverProfile->vehicle_registration_number }}</h6>
                                        </div>
                                        <div class="d-flex">
                                            <span class="mr-2">Vehicle Load Capacity</span>
                                            <h6>{{ $user->driverProfile->vehicle_load_capacity }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
