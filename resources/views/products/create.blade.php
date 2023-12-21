@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/dropzone/dropzone.css') }}">
    <style>
        .form-control {
            border: 1px solid #9c9c9c !important;
        }

        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 100% !important;
        }

        .bootstrap-select .btn {
            border: 1px solid #9c9c9c !important;
        }
    </style>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>{{ Str::title($page) }}</strong></h2>
                        </div>
                        <form method="POST" action="{{ route('products.store') }}" id="wizard_with_validation" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <div class="row" id="product-details">
                                    <div class="col-md-12">
                                        <h3> Product Info</h3>
                                        <div class="row">
                                            <div class="col-md-6 col-lg-3">
                                                <label for="product_name" class="form-label">Product Name</label>
                                                <div class="form-group">
                                                    <input type="text" name="name" value="{{ old('name') }}"
                                                        id="name" autocomplete="off"
                                                        class="form-control"
                                                        required>
                                                </div>
                                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <label for="category">Product Category</label>
                                                <div class="form-group">
                                                    <select name="category" id="category"
                                                        class="show-tick"
                                                        required>
                                                        <option value="">Select Product Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                @if (old('category') == $category->id) selected @endif>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <label for="product_material">Product Material</label>
                                                <div class="form-group">
                                                    <input type="text" name="material" value="{{ old('material') }}"
                                                        id="product_material"
                                                        class="form-control">
                                                </div>
                                                <x-input-error :messages="$errors->get('material')" class="mt-2" />
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <label for="product_brand">Product Brand</label>
                                                <div class="form-group">
                                                    <input type="text" name="brand" id="product_brand"
                                                        class="form-control">
                                                </div>
                                                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="row">
                                                    <div class="col-md-3 col-lg-3">
                                                        <label for="currency">Currency</label>
                                                        <div class="form-group">
                                                            <select name="currency" id="currency" class="form-select">
                                                                <option value="">Currency</option>
                                                                @foreach ($currencies as $currency)
                                                                    <option value="{{ $currency }}"
                                                                        @if (old('currency') === $currency) selected @endif>
                                                                        {{ $currency }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label for="product_price">Standard Price</label>
                                                        <div class="form-group">
                                                            <input type="number" name="price" value="{{ old('price') }}"
                                                                id="product_price" min="0" placeholder="0.00"
                                                                class="form-control">
                                                        </div>
                                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label for="product_min_price" class="text-black">Min price</label>
                                                        <div class="form-group">
                                                            <input type="number" name="min_price" value="{{ old('min_price') }}"
                                                                id="product_min_price" min="0" placeholder="0.00"
                                                                class="form-control"
                                                                required>
                                                        </div>
                                                        <x-input-error :messages="$errors->get('min_price')" class="mt-2" />
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <label for="product_max_price">Max Price</label>
                                                        <div class="form-group">
                                                            <input type="number" name="max_price"
                                                                value="{{ old('max_price') }}" id="product_max_price"
                                                                min="0" placeholder="0.00"
                                                                class="form-control">
                                                        </div>
                                                        <x-input-error :messages="$errors->get('min_price')" class="mt-2" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4 col-lg-4">
                                                        <label for="product_minimum_quantity_order">Minimum Order Quantity</label>
                                                        <div class="form-group">
                                                            <input type="number" name="min_order_quantity"
                                                                id="product_minimum_quantity_order" min="1"
                                                                placeholder="0"
                                                                class="form-control">
                                                        </div>
                                                        <x-input-error :messages="$errors->get('min_order_quantity')" class="mt-2" />
                                                        <x-input-error :messages="$errors->get('order_quantity_unit')" class="mt-2" />
                                                    </div>
                                                    <div class="col-md-4 col-lg-4">
                                                        <label for="product_maximum_quantity_order">Maximum Order Quantity</label>
                                                        <div class="form-group">
                                                            <input type="number" name="max_order_quantity"
                                                                id="product_maximum_quantity_order" min="1"
                                                                placeholder="0"
                                                                class="form-control">
                                                        </div>
                                                        <x-input-error :messages="$errors->get('max_order_quantity')" class="mt-2" />
                                                        <x-input-error :messages="$errors->get('order_quantity_unit')" class="mt-2" />
                                                    </div>
                                                    <div class="col-md-4 col-lg-4">
                                                        <label for="product_brand">Unit</label>
                                                        <div class="form-group">
                                                            <select name="order_quantity_unit" id="quantity_order_unit"
                                                                class="form-select">
                                                                <option value="">Unit</option>
                                                                @foreach ($units as $unit)
                                                                    <option value="{{ $unit->name }}"
                                                                        @if (old('order_quantity_unit') == $unit->name) selected @endif>
                                                                        {{ $unit->name }} @if ($unit->abbrev)
                                                                            - ({{ $unit->abbrev }})
                                                                        @endif
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4">
                                                <label for="min quantity">Min Stock Quantity</label>
                                                <div class="form-group">
                                                    <input type="number" name="min_quantity" id="min_quantity"
                                                        class="form-control">
                                                </div>
                                                <x-input-error :messages="$errors->get('min_quantity')" class="mt-2" />
                                            </div>
                                            <div class="col-md-4 col-lg-4">
                                                <label for="initial quantity">Initial Quantity</label>
                                                <div class="form-group">
                                                    <input type="number" name="initial_quantity"
                                                        id="initial_quantity"
                                                        class="form-control">
                                                </div>
                                                <x-input-error :messages="$errors->get('initial_quatity')" class="mt-2" />
                                            </div>
                                            <div class="col-md-4 col-lg-4">
                                                <label for="product_place_of_origin">Product Place of Origin</label>
                                                <div class="form-group">
                                                    <input type="text" name="place_of_origin" id="product_origin"
                                                        class="form-control">
                                                </div>
                                                <x-input-error :messages="$errors->get('place_of_origin')" class="mt-2" />
                                            </div>
                                            <div class="col-md-4 col-lg-4">
                                                <x-input-label>Certificate of Origin</x-input-label>
                                                <div class="form-group">
                                                    <input type="file" accept=".pdf" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4">
                                                <label for="product_shape">Product Shape</label>
                                                <div class="form-group">
                                                    <select name="shape" id="product_shape"
                                                        class="form-select">
                                                        <option value="">Select Product Shape</option>
                                                        @foreach ($shapes as $shape)
                                                            <option value="{{ $shape }}"
                                                                @if (old('shape') == $shape) selected @endif>
                                                                {{ $shape }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <x-input-error :messages="$errors->get('shape')" class="mt-2" />
                                            </div>

                                            <div class="col-md-4 col-lg-4">
                                                <label for="product_color">Product Color</label>
                                                <div class="form-group">
                                                    <select name="color" id="product_color"
                                                        class="form-select">
                                                        <option value="">Select Product Color</option>
                                                        @foreach ($colors as $color)
                                                            <option value="{{ $color }}"
                                                                @if (old('color') == $color) selected @endif>
                                                                {{ $color }}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-input-error :messages="$errors->get('color')" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-lg-3">
                                                <label for="product_usage">Product Usage</label>
                                                <div class="form-group">
                                                    <select name="usage" id="product_usage"
                                                        class="form-select">
                                                        <option value="">Select Product usage</option>
                                                        @foreach ($usages as $usage)
                                                            <option value="{{ $usage }}"
                                                                @if (old('usage') == $usage) selected @endif>
                                                                {{ $usage }}</option>
                                                        @endforeach
                                                        @if (!collect($usages)->contains(old('usage')) && old('usage') != null)
                                                            <option value="{{ old('usage') }}" selected>
                                                                {{ old('usage') }}</option>
                                                        @endif
                                                    </select>
                                                    <x-input-error :messages="$errors->get('usage')" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-lg-3">
                                                <label for="product_model_number">Product\'s Model Number</label>
                                                <div class="form-group">
                                                    <input type="text" name="model_number"
                                                        id="product_model_number" min="0"
                                                        class="form-control"
                                                        required>
                                                </div>
                                                <x-input-error :messages="$errors->get('model_number')" class="mt-2" />
                                            </div>
                                            <div class="col-md-3 col-lg-3">
                                                <label for="batch_id">Batch ID Number (BIN):</label>
                                                <div class="form-group">
                                                    <input type="text" name="bin" id="bin" class="form-control" value="{{ old('bin', $product->bin ?? '') }}">
                                                    <div class="input-group-append ml-5">
                                                        <button type="button" class="btn btn-secondary" id="generateBatchId">Generate</button>
                                                    </div>
                                                </div>
                                                <x-input-error :messages="$errors->get('bin')" class="mt-2" />
                                            </div>
                                            <div class="col-md-3 col-lg-3">
                                                <label for="product_regional_feature">Regional Feature</label>
                                                <div class="form-group">
                                                    <select name="regional_feature" id="regional_feature"
                                                        class="form-select">
                                                        <option value="">Select Product Regional Feature</option>
                                                        @foreach ($regions as $region)
                                                            <option value="{{ $region }}"
                                                                @if (old('regional_feature') == $region) selected @endif>
                                                                {{ $region }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <x-input-error :messages="$errors->get('regional_feature')" class="mt-2" />
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <label for="product_description">Product Description</label>
                                                <div class="form-group">
                                                    <textarea type="text" name="description" rows="4" id="product_description"
                                                        class="form-control"
                                                        required></textarea>
                                                </div>
                                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-bold text-black">Confirm Availabilty Status</label>
                                            <div class="checkbox">
                                                <input id="in_stock" type="checkbox" name="product_availability" value="1" checked>
                                                <label for="in_stock">
                                                    In Stock
                                                </label>
                                                <x-input-error :messages="$errors->get('product_availability')" class="mt-2"></x-input-error>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <hr>
                            <fieldset>
                                <h3> Wing and Location</h3>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-4">
                                            <label for="warehouse">Warehouse</label>
                                            <div class="form-group">
                                                <select name="warehouse" id="warehouse"
                                                    class="form-select">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}" data-wings="{{ $warehouse->wings }}"
                                                            @if (old('warehouse') == $warehouse->id) selected @endif>
                                                            {{ $warehouse->name }} - {{ ($warehouse->country->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <x-input-error :messages="$errors->get('warehouse')" class="mt-2" />
                                        </div>
                                        {{-- <input type="hidden" name="warehouse" id="warehouse" value="{{ $warehouse }}"> --}}
                                        <div class="col-md-4 col-lg-4">
                                            <label for="wing">Wing</label>
                                            <div class="form-group">
                                                <select id="wing" name="wing" class="">
                                                    <option value="">Select Wing</option>
                                                    {{-- @foreach ($wings as $wing)
                                                        <option value="{{ $wing->id }}">
                                                            {{ $wing->wingname }}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4">
                                            <label for="winglocation">Wing Location</label>
                                            <div class="form-group">
                                                <select id="wingLocation" name="wingLocation" class="form-select">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <hr>
                            <fieldset>
                                <h3> Media </h3>
                                <div class="row" id="more-details">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_images">Product Images</label>
                                            <div class="form-control">
                                                <input name="images[]" accept=".jpg,.png" type="file" multiple />
                                            </div>
                                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_video">Product Video</label>
                                            <div class="form-group">
                                                <input name="video" class="form-control" accept=".mp4" type="file" />
                                            </div>
                                            <x-input-error :messages="$errors->get('video')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary waves-effect btn-round" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#warehouse').on('change', function() {
                    let wings = $('#warehouse').find(':selected').data('wings')
                    let wingOptions = document.getElementById('wing')
                    while (wingOptions.options.length) {
                        wingOptions.remove(0);
                    }
                    var wing = new Option('Select wing', '');
                    wingOptions.options.add(wing);
                    if (wings) {
                        var i;
                        for (i = 0; i < wings.length; i++) {
                            var wing = new Option(wings[i].wingname, wings[i].id);
                            wingOptions.options.add(wing);
                        }
                    }
                })
                $('#wing').on('change', function() {
                    var wingId = $(this).val();
                    console.log('Selected Wing ID:', wingId);

                    if (wingId) {
                        $.ajax({
                            type: 'GET',
                            url: '/get-wing-locations/' + wingId,
                            success: function(data) {
                                console.log('AJAX Response:', data);
                                $('#wingLocation').empty();
                                console.log('Target Element:', $('#wingLocation'));

                                // Populate wing locations dropdown
                                $.each(data, function(key, value) {
                                    var optionText = value.location_name + (value
                                        .square_fit ? ' - ' + value.square_fit : '');
                                    var option = $('<option>').attr('value', value.id).text(
                                        optionText);
                                    $('#wingLocation').append(option);
                                    $('#wingLocation').selectpicker('refresh');
                                });
                            },
                            error: function(xhr, status, error) {}
                        });
                    } else {
                        // Clear wing locations dropdown if no wing is selected
                        $('#wingLocation').empty();
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                const batchIdInput = document.getElementById('bin');
                const generateButton = document.getElementById('generateBatchId');

                generateButton.addEventListener('click', function () {
                    const generatedBatchId = generateUniqueBatchId();
                    batchIdInput.value = generatedBatchId;
                });
                function generateUniqueBatchId() {
                    const getRandomNumber = (length) => Math.floor(Math.random() * Math.pow(10, length)).toString().padStart(length, '0');

                    const firstPart = getRandomNumber(5);
                    const secondPart = getRandomNumber(4);
                    const thirdPart = getRandomNumber(5);

                    return `${firstPart}-${secondPart}-${thirdPart}`;
                }
            });

            // $(document).ready(function() {
            //     var navListItems = $('div.setup-panel div a'),
            //         allWells = $('.setup-content'),
            //         allNextBtn = $('.nextBtn');

            //     allWells.hide();

            //     navListItems.click(function(e) {
            //         e.preventDefault();
            //         var $target = $($(this).attr('href')),
            //             $item = $(this);

            //         if (!$item.hasClass('disabled')) {
            //             navListItems.removeClass('btn-primary').addClass('btn-default');
            //             $item.addClass('btn-primary');
            //             allWells.hide();
            //             $target.show();
            //             $target.find('input:eq(0)').focus();
            //         }
            //     });

            //     allNextBtn.click(function() {
            //         var curStep = $(this).closest(".setup-content"),
            //             curStepBtn = curStep.attr("id"),
            //             nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next()
            //             .children("a"),
            //             curInputs = curStep.find("input[type='text'],input[type='url']"),
            //             isValid = true;

            //         $(".form-group").removeClass("has-error");
            //         for (var i = 0; i < curInputs.length; i++) {
            //             if (!curInputs[i].validity.valid) {
            //                 isValid = false;
            //                 $(curInputs[i]).closest(".form-group").addClass("has-error");
            //             }
            //         }

            //         if (isValid)
            //             nextStepWizard.removeAttr('disabled').trigger('click');
            //     });

            //     $('div.setup-panel div a.btn-primary').trigger('click');

            //     document.addEventListener('DOMContentLoaded', function() {
            //         new Vue({
            //             el: '#app', // Make sure to set the correct element ID or class
            //             data: {
            //                 images: null,
            //                 video: null,
            //             },
            //         });
            //     });
            // });
        </script>
    @endpush
@endsection
