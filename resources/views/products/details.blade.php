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
                        <div class="header d-flex justify-content-between">
                            <h2><strong>{{ Str::title($page) }}</strong></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="card">
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title">Product Details</h6>
                        </div>
                        <div class="body">
                            <div class="image-container mb-2">
                                @if(!empty($product->media))
                                    @foreach($product->media as $media)
                                    @if($media->type =='image')
                                            <img src="{{ asset($media->file) }}" alt="{{ $product->name}}" style="max-width: 200px; max-height: 200px; border-radius: 50%;">
                                        @endif
                                    @endforeach
                            @else
                                <img src="{{ asset('assets/images/product-placeholder.png') }}" alt="Placeholder" style="max-width: 100px; max-height: 100px; border-radius: 50%;">
                            @endif
                             <h4 >{{ $product->name }}</h4>
                            </div>
                            <div class="row">
                            <p class="col-md-6"><strong>Category:  </strong> {{$product->category->name ?? 'N/A' }}</p>
                            <p class="col-md-6"><strong>Description:  </strong> {{ $product->description }}</p>
                            <p class="col-md-6"><strong>Material:  </strong> {{ $product->material }}</p>
                            <p class="col-md-6"><strong>Price:  </strong> {{ $product->price }}</p>
                            <p class="col-md-6"><strong>Place of Origin:  </strong> {{ $product->place_of_origin }}</p>
                            <p class="col-md-6"><strong>Brand:  </strong> {{ $product->brand }}</p>
                            <p class="col-md-6"><strong>Shape:  </strong> {{ $product->shape }}</p>
                            <p class="col-md-6"><strong>Color:  </strong> {{ $product->color }}</p>
                            <p class="col-md-6"><strong>Min Order Quantity:  </strong> {{ $product->min_order_quantity }}</p>
                            <p class="col-md-6"><strong>Max Order Quantity:  </strong> {{ $product->max_order_quantity }}</p>
                            <p class="col-md-6"><strong>Model Number:  </strong> {{ $product->model_number }}</p>
                            <p class="col-md-6"><strong>Is Available:  </strong> {{ $product->is_available ? 'Yes' : 'No' }}</p>
                            <p class="col-md-6"><strong>Regional Feature:  </strong> {{ $product->regional_featre }}</p>
                            <p class="col-md-6"><strong>Slug:  </strong> {{ $product->slug }}</p>
                            <p class="col-md-6"><strong>Created At:  </strong> {{ $product->created_at }}</p>
                            <p class="col-md-6"><strong>Updated At:  </strong> {{ $product->updated_at }}</p>
                            <p class="col-md-6"><strong>Min Price:  </strong> {{ $product->min_price }}</p>
                            <p class="col-md-6"><strong>Max Price:  </strong> {{ $product->max_price }}</p>
                            <p class="col-md-6"><strong>Capacity in Warehouse:  </strong> {{ $product->capacity_in_warehouse }}</p>
                            <p class="col-md-6"><strong>Usage:  </strong> {{ $product->usage }}</p>
                            <p class="col-md-6"><strong>Batch ID No (BIN):  </strong> {{ $product->bin }}</p>
                        </div>
                        </div>
                </div>
                </div>
                    <div class="col-md-4 col-sm-12">
{{--                        <div class="card">--}}
{{--                            <div class="d-flex justify-content-between">--}}
{{--                                <h6 class="card-title">Business and Vendor Information</h6>--}}
{{--                            </div>--}}
{{--                            <div class="body col-8">--}}
{{--                                <p class="card-text mr-2"><strong> Name:</strong>{{ $product->business->user->first_name ?? '' }} {{ $product->business->user->last_name }}</p>--}}
{{--                                <p class="card-text mr-2"><strong>Email:</strong>{{ $product->business->user->email ?? ''}}</p>--}}
{{--                                <p class="card-text mr-2"><strong>Phone Number:</strong>{{ $product->business->user->phone_number ?? ''}}</p>--}}
{{--                            </div>--}}
{{--                            <hr/>--}}
{{--                            <div class="body col-8">--}}
{{--                                <p class="card-text mr-2"><strong>Business Name:</strong> {{$product->business->name ?? '' }}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="d-flex justify-content-between">
                                    <h6 class="card-title">Warehouse/Wing/Location</h6>
                                </div>
                                    <div class="body col-12">
                                        <p class="card-text mr-2"><strong>Wing: </strong>{{ optional($product->winglocation->wing)->wingname ?? '' }}</p>
                                        <p class="card-text mr-2"><strong>Location: </strong> {{ optional($product->winglocation)->location_name ?? '' }}</p>
                                        <p class="card-text mr-2"><strong>Occupancy: </strong> {{$product->location->square_fit ?? 1/2*(($product->location->height ?? 0) * ($product->location->width ?? 0) ) ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                    </div>
            </div>
        </div>
    </section>
@endsection
