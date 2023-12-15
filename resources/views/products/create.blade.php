@extends('layouts.app')
@section('css')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}">
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
        <style>
            [x-cloak] {
                display: none;
            }
             #gmap_markers {
                 height: 380px;
             }
            #super{
                vertical-align:super;
                font-size: smaller;
            }
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
                        <div class="body">
                                <div class="row">
                                    <form method="POST" action="{{ route('products.store') }}" id="product-details-wizard-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card col-6">
                                        <div class="row">
                                            <div class="grid md:grid-cols-2 gap-3">
                                                <div class="mb-2 form-group mb-2 mr-5">
                                                    <x-input-label for="product_name" :value="__('Product Name')" class="text-black" />
                                                    <input type="text" name="name" :value="old('name')" id="name" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                                </div>
                                                @php($category_ids = $categories->pluck('id')->toArray())
                                                <div class="form-group mb-2 mr-5">
                                                    <x-input-label for="category" :value="__('Product Category')" class="text-black" />
                                                    <select name="category" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <option value="">Select Product Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" @if(in_array(old('category'), $category_ids)) selected @endif>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <x-input-label for="product_material" :value="__('Product Material')" class="text-black" />
                                                    <input type="text" name="material" :value="old('material')" id="product_material" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                    <x-input-error :messages="$errors->get('material')" class="mt-2" />
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <x-input-label for="product_brand" :value="__('Product Brand')" class="text-black" />
                                                    <input type="text" name="brand" id="product_brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                    <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                                                </div>
                                                <div class="flex gap-1">
                                                    <div class="basis-2/5 form-group mb-2 mr-5">
                                                        {{--                                <div class="flex justify-between">--}}
                                                        {{--                                    <x-input-label for="currency" :value="__('Currency')" class="text-black" />--}}
                                                        {{--                                    @php($vendor_currency = auth()->user()->business->global_currency)--}}
                                                        {{--                                    <div class="flex gap-2">--}}
                                                        {{--                                        <x-input-label :value="__('Custom')" class="text-sm text-black font-semibold" />--}}
                                                        {{--                                        <input type="checkbox" name="enter_custom_currency" @if((!in_array(old('currency'), $currencies->toArray()) && old('currency') != NULL) || ($vendor_currency && !in_array($vendor_currency, $currencies->toArray()))) checked @endif onchange="enterCustom(this, 'currency')" id="enter_custom_currency" class="my-auto w-4 h-4 mr-0.5 text-primary-one bg-gray-400 border-gray-500 rounded focus:ring-primary-one dark:focus:ring-primary-two dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">--}}
                                                        {{--                                    </div>--}}
                                                        {{--                                </div>--}}
                                                        <input name="currency" id="custom_currency" oninput="setInput('currency')" type="text" class="@if($currencies->toArray()) hidden @endif
                                 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <select name="currency" id="currency"  class="@if(!$currencies->toArray()) hidden @endif
                                bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                            <option value="">Currency</option>
                                                            @foreach ($currencies as $currency)
                                                                <option value="{{ $currency }}" @if(old('currency') === $currency) selected @endif>{{ $currency }}</option>
                                                            @endforeach
                                                            {{--                                    @if (!in_array(old('currency'), $currencies->toArray()) && old('currency') != NULL)--}}
                                                            {{--                                        <option value="{{ old('currency') }}" selected>{{ old('currency') }}</option>--}}
                                                            {{--                                    @endif--}}
                                                            {{--                                    @if ($vendor_currency && !in_array($vendor_currency, $currencies->toArray()))--}}
                                                            {{--                                        <option value="{{ $vendor_currency }}" selected>{{ $vendor_currency }}</option>--}}
                                                            {{--                                    @endif--}}
                                                        </select>
                                                    </div>
                                                    <div class="basis-3/5 form-group mb-2 mr-5">
                                                        <x-input-label for="product_price" :value="__('Standard Price')" class="text-black" />
                                                        <input type="number" name="price" :value="old('price')" id="product_price" min="0" placeholder="0.00" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-1">
                                                    <div class="form-group mb-2 mr-5">
                                                        <x-input-label for="product_min_price" :value="__('Min price ')" class="text-black" />
                                                        <input type="number" name="min_price" :value="old('min_price')" id="product_min_price" min="0" placeholder="0.00" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <x-input-error :messages="$errors->get('min_price')" class="mt-2" />
                                                    </div>
                                                    <div class="form-group mb-2 mr-5">
                                                        <x-input-label for="product_max_price" :value="__('Max Price')" class="text-black" />
                                                        <input type="number" name="max_price" :value="old('max_price')" id="product_max_price" min="0" placeholder="0.00" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <x-input-error :messages="$errors->get('min_price')" class="mt-2" />
                                                    </div>
                                                </div>
                                                <div class="col-span-2 grid grid-cols-5 gap-2">
                                                    <div class="col-span-2 form-group mb-2 mr-5">
                                                        <x-input-label for="product_minimum_quantity_order" :value="__('Minimum Order Quantity')" class="text-black" />
                                                        <input type="number" name="min_order_quantity" id="product_minimum_quantity_order" min="1" placeholder="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <x-input-error :messages="$errors->get('min_order_quantity')" class="mt-2" />
                                                        <x-input-error :messages="$errors->get('order_quantity_unit')" class="mt-2" />
                                                    </div>
                                                    <div class="col-span-2 form-group mb-2 mr-5">
                                                        <x-input-label for="product_maximum_quantity_order" :value="__('Maximum Order Quantity')" class="text-black" />
                                                        <input type="number" name="max_order_quantity" id="product_maximum_quantity_order" min="1" placeholder="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <x-input-error :messages="$errors->get('max_order_quantity')" class="mt-2" />
                                                        <x-input-error :messages="$errors->get('order_quantity_unit')" class="mt-2" />
                                                    </div>
                                                    <div class="col-span-1 form-group mb-2 mr-5">
                                                        <div class="flex justify-between">
                                                            <x-input-label for="product_brand" :value="__('Unit')" class="text-black" />
                                                            <div class="flex gap-2">
                                                                <x-input-label :value="__('Custom')" class="text-sm text-black font-semibold" />
                                                                <input type="checkbox" name="enter_custom_quantity_order_unit" @if(!in_array(old('quantity_order_unit'), $units->toArray()) && old('quantity_order_unit') != NULL) checked @endif onchange="enterCustom(this, 'quantity_order_unit')" id="enter_custom_quantity_order_unit" class="my-auto w-4 h-4 text-primary-one bg-gray-400 border-gray-500 rounded focus:ring-primary-one dark:focus:ring-primary-two dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                            </div>
                                                        </div>
                                                        <input name="order_quantity_unit" oninput="setInput('order_quantity_unit')" id="custom_quantity_order_unit" type="text" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <select name="order_quantity_unit" id="quantity_order_unit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                            <option value="">Unit</option>
                                                            @foreach ($units as $unit)
                                                                <option value="{{ $unit->name }}" @if(in_array(old('order_quantity_unit'), $units->toArray())) selected @endif>{{ $unit->name }} @if($unit->abbrev) - ({{ $unit->abbrev }}) @endif</option>
                                                            @endforeach
                                                            @if (!collect($units)->contains(old('order_quantity_unit')) && old('order_quantity_unit') != NULL)
                                                                <option value="{{ old('order_quantity_unit') }}" selected>{{ old('order_quantity_unit') }}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <x-input-label for="min quantity" :value="__('Min Quantity')" class="text-black" />
                                                    <input type="number" name="min_quantity" id="min_qunatity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                    <x-input-error :messages="$errors->get('min_quatity')" class="mt-2" />
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <x-input-label for="product_place_of_origin" :value="__('Product Place of Origin')" class="text-black" />
                                                    <input type="text" name="place_of_origin" id="product_origin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                    <x-input-error :messages="$errors->get('place_of_origin')" class="mt-2" />
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <x-input-label>Certificate of Origin</x-input-label>
                                                    <x-input-file accept=".pdf" class="" name="certificate_of_origin"></x-input-file>
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <div class="flex justify-between">
                                                        <x-input-label for="product_shape" :value="__('Product Shape')" class="text-black" />
                                                        <div class="flex gap-2">
                                                            <x-input-label :value="__('Custom')" class="text-sm text-black font-semibold" />
                                                            <input type="checkbox" name="enter_custom_product_shape" @if(!in_array(old('shape'), $shapes->toArray()) && old('shape') != NULL) checked @endif onchange="enterCustom(this, 'product_shape')" id="enter_custom_product_shape" class="my-auto w-4 h-4 text-primary-one bg-gray-400 border-gray-500 rounded focus:ring-primary-one dark:focus:ring-primary-two dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        </div>
                                                    </div>
                                                    <input name="shape" oninput="setInput('product_shape')" id="custom_product_shape" type="text" placeholder="Enter Shape" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                    <select name="shape" id="product_shape" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <option value="">Select Product Shape</option>
                                                        @foreach ($shapes as $shape)
                                                            <option value="{{ $shape }}" @if(in_array(old('shape'), $shapes->toArray())) selected @endif>{{ $shape }}</option>
                                                        @endforeach
                                                        @if (!collect($shapes)->contains(old('shape')) && old('shape') != NULL)
                                                            <option value="{{ old('shape') }}" selected>{{ old('shape') }}</option>
                                                        @endif
                                                    </select>
                                                    <x-input-error :messages="$errors->get('shape')" class="mt-2" />
                                                </div>

                                                <div class="form-group mb-2 mr-5">
                                                    <div class="flex justify-between">
                                                        <x-input-label for="product_color" :value="__('Product Color')" class="text-black" />
                                                        <div class="flex gap-2">
                                                            <x-input-label :value="__('Custom')" class="text-sm text-black font-semibold" />
                                                            <input type="checkbox" name="enter_custom_product_color" @if(!in_array(old('color'), $colors->toArray()) && old('color') != NULL) checked @endif onchange="enterCustom(this, 'product_color')" id="enter_custom_product_color" class="my-auto w-4 h-4 text-primary-one bg-gray-400 border-gray-500 rounded focus:ring-primary-one dark:focus:ring-primary-two dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        </div>
                                                    </div>
                                                    <input name="color" id="custom_product_color" oninput="setInput('product_color')" type="text" placeholder="Enter Color" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                    <select name="color" id="product_color" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <option value="">Select Product Color</option>
                                                        @foreach ($colors as $color)
                                                            <option value="{{ $color }}" @if(in_array(old('color'), $colors->toArray())) selected @endif>{{ $color }}</option>
                                                        @endforeach
                                                        @if (!collect($colors)->contains(old('color')) && old('color') != NULL)
                                                            <option value="{{ old('color') }}" selected>{{ old('color') }}</option>
                                                        @endif
                                                    </select>
                                                    <x-input-error :messages="$errors->get('color')" class="mt-2" />
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <div class="flex justify-between">
                                                        <x-input-label for="product_usage" :value="__('Product Usage')" class="text-black" />
                                                        <div class="flex gap-2">
                                                            <x-input-label :value="__('Custom')" class="text-sm text-black-500 font-semibold" />
                                                            <input type="checkbox" name="enter_custom_product_usage" @if(!in_array(old('usage'), $usages->toArray()) && old('usage') != NULL) checked @endif onchange="enterCustom(this, 'product_usage')" id="enter_custom_product_usage" class="my-auto w-4 h-4 text-primary-one bg-gray-400 border-gray-500 rounded focus:ring-primary-one dark:focus:ring-primary-two dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        </div>
                                                    </div>
                                                    <input type="text" name="usage" id="custom_product_usage" oninput="setInput('product_usage')" placeholder="Enter Product Usage" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                    <select name="usage" id="product_usage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <option value="">Select Product usage</option>
                                                        @foreach ($usages as $usage)
                                                            <option value="{{ $usage }}" @if(in_array(old('usage'), $usages->toArray())) selected @endif>{{ $usage }}</option>
                                                        @endforeach
                                                        @if (!collect($usages)->contains(old('usage')) && old('usage') != NULL)
                                                            <option value="{{ old('usage') }}" selected>{{ old('usage') }}</option>
                                                        @endif
                                                    </select>
                                                    <x-input-error :messages="$errors->get('usage')" class="mt-2" />
                                                </div>
                                            </div>
{{--                                            <div class="flex justify-end gap-2 mt-4">--}}
{{--                                                <x-primary-button type="submit" class="btn btn-sm btn-primary waves-effect" wire:click="submit">Proceed</x-primary-button>--}}
{{--                                            </div>--}}
                                        </div>
                                        </div>
                                        <div class="card-body col-6">
                                        <div class="row">
                                            <div class="grid md:grid-cols-2 gap-3">
{{--                                                <div class="form-group mb-2 mr-5 lg:col-span-2">--}}
{{--                                                    <x-input-label for="warehouse" :value="__('Warehouse')" class="text-black" />--}}
                                                    <input type="hidden" name="warehouse" id="warehouse" editable="false" value="{{$warehouse}}">
{{--                                                    <x-input-error :messages="$errors->get('warehouse')" class="mt-2" />--}}
{{--                                                </div>--}}
                                                <div class="form-group mb-2 mr-5 lg:col-span-2">
                                                <div id="wingForm">
                                                    <label for="wing">Select Wing:</label>
                                                    <select id="wing" name="wing mb-2">
                                                        @foreach ($wings as $wing)
                                                            <option value="{{ $wing->id }}">{{ $wing->wingname }}</option>
                                                        @endforeach
                                                    </select>
                                                    <br/>
                                                    <label for="wingLocations mt-2">Wing Locations:</label>
                                                    <input type="text" id="wingLocations" name="wingLocations" readonly>
                                                </div>
                                                </div>

                                                <div class="form-group mb-2 mr-5 lg:col-span-2">
                                                    <x-input-label for="product_description" :value="__('Product Description')" class="text-black" />
                                                    <textarea type="text" name="description" rows="4" id="product_description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"></textarea>
                                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <x-input-label for="product_model_number" :value="__('Product\'s Model Number')" class="text-black" />
                                                    <input type="text" name="model_number" id="product_model_number" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                    <x-input-error :messages="$errors->get('model_number')" class="mt-2" />
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <div class="flex justify-between">
                                                        <x-input-label for="product_regional_feature" :value="__('Product\'s Regional Feature')" class="text-black" />
                                                        <div class="flex gap-2">
                                                            <x-input-label :value="__('Custom')" class="text-sm text-black font-semibold" />
                                                            <input type="checkbox" name="enter_custom_regional_feature" @if(!in_array(old('regional_feature'), $regions->toArray()) && old('regional_feature') != NULL) checked @endif onchange="enterCustom(this, 'regional_feature')" id="enter_custom_regional_feature" class="my-auto w-4 h-4 text-primary-one bg-gray-400 border-gray-500 rounded focus:ring-primary-one dark:focus:ring-primary-two dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        </div>
                                                    </div>
                                                    <input name="regional_feature" id="custom_regional_feature" oninput="setInput('regional_feature')" type="text" placeholder="Enter Regional Feature" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                    <select name="regional_feature" id="regional_feature" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        <option value="">Select Product Regional Feature</option>
                                                        @foreach ($regions as $region)
                                                            <option value="{{ $region }}" @if(in_array(old('regional_feature'), $regions->toArray())) selected @endif>{{ $region }}</option>
                                                        @endforeach
                                                        @if (!collect($regions)->contains(old('regional_feature')) && old('regional_feature') != NULL)
                                                            <option value="{{ old('regional_feature') }}" selected>{{ old('regional_feature') }}</option>
                                                        @endif
                                                    </select>
                                                    <x-input-error :messages="$errors->get('regional_feature')" class="mt-2" />
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <x-input-label for="product_images" :value="__('Add Product Images')" class="text-black" />
                                                    <div class="flex flex-col flex-grow mb-3 hover:cursor-pointer">
                                                        <div x-data="{ images: null }" id="FileUpload" class="block w-full py-2 px-3 relative bg-gray-200 appearance-none border-2 border-dashed border-gray-300 rounded-md hover:shadow-outline-gray">
                                                            <input type="file" multiple accept=".jpg,.jpeg,.png" name="images[]"
                                                                   class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                                                                   x-on:change="images = $event.target.files;"
                                                                   x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')" x-on:drop="$el.classList.remove('active')"
                                                            >
                                                            <template x-if="images !== null">
                                                                <div class="flex flex-col space-y-1">
                                                                    <template x-for="(_,index) in Array.from({ length: images.length })">
                                                                        <div class="flex flex-row items-center space-x-2">
                                                                            <template x-if="images[index].type.includes('audio/')"><i class="fas fa-file-audio"></i></template>
                                                                            <template x-if="images[index].type.includes('application/')"><i class="fas fa-file-alt"></i></template>
                                                                            <template x-if="images[index].type.includes('image/')"><i class="fas fa-file-image"></i></template>
                                                                            <template x-if="images[index].type.includes('video/')"><i class="fas fa-file-video"></i></template>
                                                                            <span class="font-medium text-gray-900" x-text="images[index].name">Uploading</span>
                                                                            {{-- <span class="text-xs self-end text-gray-500" x-text="filesize(images[index].size)">...</span> --}}
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </template>
                                                            <template x-if="images === null">
                                                                <div class="flex flex-col space-y-2 items-center justify-center">
                                                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                                    </svg>
                                                                    <a href="javascript:void(0)" class="flex items-center mx-auto py-1 px-3 text-red-700 text-center text-sm font-bold border border-transparent rounded-md outline-none bg-red-400">UPLOAD A FILE</a>
                                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>
                                                    <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <x-input-label for="product_video" :value="__('Add Product Video')" class="text-black" />
                                                    <div class="flex flex-col flex-grow mb-3 hover:cursor-pointer">
                                                        <div x-data="{ video: null }" id="FileUpload" class="block w-full py-2 px-3 relative bg-gray-200 appearance-none border-2 border-dashed border-gray-300 rounded-md hover:shadow-outline-gray">
                                                            <input type="file" accept=".mp4" name="video"
                                                                   class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                                                                   x-on:change="video = $event.target.files;"
                                                                   x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')" x-on:drop="$el.classList.remove('active')"
                                                            >
                                                            <template x-if="video !== null">
                                                                <div class="flex flex-col space-y-1">
                                                                    <template x-for="(_,index) in Array.from({ length: video.length })">
                                                                        <div class="flex flex-row items-center space-x-2">
                                                                            <template x-if="video[index].type.includes('audio/')"><i class="fas fa-file-audio"></i></template>
                                                                            <template x-if="video[index].type.includes('application/')"><i class="fas fa-file-alt"></i></template>
                                                                            <template x-if="video[index].type.includes('image/')"><i class="fas fa-file-image"></i></template>
                                                                            <template x-if="video[index].type.includes('video/')"><i class="fas fa-file-video"></i></template>
                                                                            <span class="font-medium text-gray-900" x-text="video[index].name">Uploading</span>
                                                                            {{-- <span class="text-xs self-end text-gray-500" x-text="filesize(video[index].size)">...</span> --}}
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </template>
                                                            <template x-if="video === null">
                                                                <div class="flex flex-col space-y-2 items-center justify-center">
                                                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                                    </svg>
                                                                    <a href="javascript:void(0)" class="flex items-center mx-auto py-1 px-3 text-red-700 text-center text-sm font-bold border border-transparent rounded-md outline-none bg-red-400">UPLOAD A FILE</a>
                                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>
                                                    <x-input-error :messages="$errors->get('video')" class="mt-2" />
                                                </div>
                                                <div class="form-group mb-2 mr-5">
                                                    <x-input-label class="font-bold text-black">Confirm Availabilty Status</x-input-label>
                                                    <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" checked value="in-stock" class="sr-only peer" name="product_availability">
                                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-600"></div>
                                                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">In Stock</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="flex justify-end gap-2 mt-4">
                                                <x-secondary-outline-button class="btn btn-sm btn-primary waves-effect text-center text-gray-800 gap-2 focus:ring-0 btn-prev"><i class="fas fa-arrow-left text-gray-800 my-auto"></i> Back</x-secondary-outline-button>
                                                <x-primary-button type="submit" class="btn btn-sm btn-primary btn-round waves-effect">Add Product</x-primary-button>
                                            </div>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#wing').change(function () {
                    var wingId = $(this).val();
                    if (wingId) {
                        $.ajax({
                            url: '/get-wing-locations/' + wingId,
                            type: 'GET',
                            success: function (data) {
                                $('#wingLocations').val(data.join(', '));
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    } else {
                        $('#wingLocations').val('');
                    }
                });
            });
        </script>

    </section>

    @push('scripts')
        <script src="{!! config('services.maps.key') !!}" async defer></script>
            <!-- Scripts -->
            <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
            <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
            <script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
            <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
            <script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
            <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
            <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
            <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
            <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
            <script src="{{ asset('assets/js/product-wizard.js') }}"></script>
            <script>
                // function showCapacityInput() {
                //     let selected_warehouse = $('#link_to_warehouse').find(':selected').val()
                //     if (selected_warehouse === '') {
                //         $('#product_capacity').addClass('hidden')
                //     } else {
                //         $('#product_capacity').removeClass('hidden')
                //     }
                // }
                function enterCustom(value, element_id) {
                    if (value.checked) {
                        $('#'+element_id).addClass('hidden')
                        $('#'+element_id).removeClass('block')
                        $('#custom_'+element_id).addClass('block')
                        $('#custom_'+element_id).removeClass('hidden')
                        $('#custom_'+element_id).focus()
                    } else {
                        $('#'+element_id).addClass('block')
                        $('#'+element_id).removeClass('hidden')
                        $('#'+element_id).focus()
                        $('#custom_'+element_id).addClass('hidden')
                        $('#custom_'+element_id).removeClass('block')
                    }
                }

                function setInput(input) {
                    $('#'+input).val($('#custom_'+input).val())
                }

                function dropdown() {
                    return {
                        options: [],
                        selected: [],
                        show: false,
                        open() { this.show = true },
                        close() { this.show = false },
                        isOpen() { return this.show === true },
                        select(index, event) {
                            if (!this.options[index].selected) {

                                this.options[index].selected = true;
                                this.options[index].element = event.target;
                                this.selected.push(index);

                            } else {
                                this.selected.splice(this.selected.lastIndexOf(index), 1);
                                this.options[index].selected = false
                            }
                        },
                        remove(index, option) {
                            this.options[option].selected = false;
                            this.selected.splice(index, 1);
                        },
                        loadOptions() {
                            const options = document.getElementById('select').options;
                            for (let i = 0; i < options.length; i++) {
                                this.options.push({
                                    value: options[i].value,
                                    text: options[i].innerText,
                                    selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                                });
                            }
                        },
                        selectedValues(){
                            return this.selected.map((option)=>{
                                return this.options[option].value;
                            })
                        }
                    }
                }

                let selected_warehouses = []
                function getSelectedWarehouses(product) {
                    let warehouses = product.warehouses

                    warehouses.forEach(warehouse => {
                        selected_warehouses.push(warehouse.id)
                    });
                }

                function updateWarehouses(product) {
                    let warehouses = product.warehouses

                    warehouses.forEach(warehouse => {
                        selected_warehouses.push(warehouse.id)
                    });

                    return {
                        options: [],
                        selected: [...selected_warehouses],
                        show: false,
                        open() { this.show = true },
                        close() { this.show = false },
                        isOpen() { return this.show === true },
                        select(index, event) {
                            if (!this.options[index].selected) {
                                this.options[index].selected = true;
                                this.options[index].element = event.target;
                                this.selected.push(index);

                            } else {
                                this.selected.splice(this.selected.lastIndexOf(index), 1);
                                this.options[index].selected = false
                            }
                        },
                        remove(index, option) {
                            this.options[option].selected = false;
                            this.selected.splice(index, 1);
                        },
                        loadOptions() {
                            const options = document.getElementById('select').options;
                            for (let i = 0; i < options.length; i++) {
                                this.options.push({
                                    value: options[i].value,
                                    text: options[i].innerText,
                                    selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                                });
                            }
                        },
                        selectedValues(){
                            return this.selected.map((option)=>{
                                return this.options[option].value;
                            })
                        }
                    }
                }
            </script>
        @endpush
@endsection
