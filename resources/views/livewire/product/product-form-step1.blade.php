<!-- product-form-step1.blade.php -->

<div>
    <h3 class="mt-2">Product Info</h3>

    <form wire:submit.prevent="nextStep">
        <div class="row setup-content">
            <div class="col-xs-12">
                <div class="col-md-12">
{{--                    <h3> Product Info</h3>--}}
                    <div class="grid md:grid-cols-2 gap-3">
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <x-input-label for="product_name" :value="__('Product Name')" class="text-black pr-2" />
                            <input wire:model="name" type="text" name="name" id="name" autocomplete="off" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" >
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        @php($category_ids = $categories->pluck('id')->toArray())
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <x-input-label for="category" :value="__('Product Category')" class="text-black" />
                            <select wire:model="category" name="category" id="category" class="form-select ml-3 bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" >
                                <option value="">Select Product Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if(in_array(old('category'), $category_ids)) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <x-input-label for="product_material" :value="__('Product Material')" class="text-black" />
                            <input wire:model="material" type="text" name="material" id="product_material" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <x-input-error :messages="$errors->get('material')" class="mt-2" />
                        </div>
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <x-input-label for="product_brand" :value="__('Product Brand')" class="text-black" />
                            <input wire:model="brand" type="text" name="brand" id="product_brand" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                        </div>
                        <div class="flex gap-1 col-md-6 col-lg-5">
                            <div class="form-group col-md-3 col-lg-5 mb-2">
                                <x-input-label for="currency" :value="__('Currency')" class="text-black" />
                                <input wire:model="currency" name="currency" id="custom_currency" oninput="setInput('currency')" type="text" class="@if($currencies->toArray()) hidden @endif
                                                    bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white ">
                            </div>
                            <div class="form-group col-md-3 col-lg-5 mb-2 ml-2">
                                <select wire:model="currency" name="currency" id="currency"  class="@if(!$currencies->toArray()) hidden @endif
                                                       form-select bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                    <option value="">Currency</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency }}" @if(old('currency') === $currency) selected @endif>{{ $currency }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="basis-3/5 form-group">
                                <x-input-label for="product_price" :value="__('Standard Price')" class="text-black" />
                                <input wire:model="price" type="number" name="price" id="product_price" min="0" placeholder="0.00" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1">
                            <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                                <x-input-label for="product_min_price" :value="__('Min price ')" class="text-black" />
                                <input wire:model="min_price"  type="number" name="min_price" id="product_min_price" min="0" placeholder="0.00" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" >
                                <x-input-error :messages="$errors->get('min_price')" class="mt-2" />
                            </div>
                            <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                                <x-input-label for="product_max_price" :value="__('Max Price')" class="text-black" />
                                <input wire:model="max_price"  type="number" name="max_price" id="product_max_price" min="0" placeholder="0.00" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <x-input-error :messages="$errors->get('min_price')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-span-2 grid grid-cols-5 gap-2">
                            <div class="col-span-2 form-group col-md-6 col-lg-5 mb-2 ml-2">
                                <x-input-label for="product_minimum_quantity_order" :value="__('Minimum Order Quantity')" class="text-black" />
                                <input wire:model="min_order_quantity"  type="number" name="min_order_quantity" id="product_minimum_quantity_order" min="1" placeholder="0" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <x-input-error :messages="$errors->get('min_order_quantity')" class="mt-2" />
                                <x-input-error :messages="$errors->get('order_quantity_unit')" class="mt-2" />
                            </div>
                            <div class="col-span-2 form-group col-md-6 col-lg-5 mb-2 ml-2">
                                <x-input-label for="product_maximum_quantity_order" :value="__('Maximum Order Quantity')" class="text-black" />
                                <input wire:model="max_order_quantity"  type="number" name="max_order_quantity" id="product_maximum_quantity_order" min="1" placeholder="0" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <x-input-error :messages="$errors->get('max_order_quantity')" class="mt-2" />
                                <x-input-error :messages="$errors->get('order_quantity_unit')" class="mt-2" />
                            </div>
                            <div class="col-span-1 form-group col-md-6 col-lg-5 mb-2 ml-2">
                                <div class="flex justify-between">
                                    <x-input-label for="product_brand" :value="__('Unit')" class="text-black" />
                                    <div class="flex gap-2">
                                        <x-input-label :value="__('Custom')" class="text-sm text-black font-semibold" />
                                        <input wire:model="enter_custom_quantity_order_unit" type="checkbox" name="enter_custom_quantity_order_unit" @if(!in_array(old('quantity_order_unit'), $units->toArray()) && old('quantity_order_unit') != NULL) checked @endif onchange="enterCustom(this, 'quantity_order_unit')" id="enter_custom_quantity_order_unit" class="my-auto w-4 h-4 text-primary-one bg-gray-400 border-gray-500 rounded focus:ring-primary-one dark:focus:ring-primary-two dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </div>
                                </div>
                                <input name="order_quantity_unit" oninput="setInput('order_quantity_unit')" id="custom_quantity_order_unit" type="text" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <select wire:model="order_quantity_unit"  name="order_quantity_unit" id="quantity_order_unit" class="form-select ml-3 bg-opacity-75 bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
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
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <x-input-label for="min quantity" :value="__('Min Stock Quantity')" class="text-black" />
                            <input wire:model="min_quantity"  type="number" name="min_quantity" id="min_quantity" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <x-input-error :messages="$errors->get('min_quantity')" class="mt-2" />
                        </div>
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <x-input-label for="initial quantity" :value="__('Initial Quantity')" class="text-black" />
                            <input wire:model="initial_quantity"  type="number" name="initial_quantity" id="initial_quantity" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <x-input-error :messages="$errors->get('initial_quatity')" class="mt-2" />
                        </div>
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <x-input-label for="product_place_of_origin" :value="__('Product Place of Origin')" class="text-black" />
                            <input  wire:model="place_of_origin"  type="text" name="place_of_origin" id="product_origin" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <x-input-error :messages="$errors->get('place_of_origin')" class="mt-2" />
                        </div>
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <x-input-label>Certificate of Origin</x-input-label>
                            <x-input-file wire:model="certificate_of_origin" accept=".pdf" class="" name="certificate_of_origin"></x-input-file>
                        </div>
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <div class="flex justify-between">
                                <x-input-label for="product_shape" :value="__('Product Shape')" class="text-black" />
                                <div class="flex gap-2">
                                    <x-input-label :value="__('Custom')" class="text-sm text-black font-semibold" />
                                    <input wire:model="enter_custom_product_shape" type="checkbox" name="enter_custom_product_shape" @if(!in_array(old('shape'), $shapes->toArray()) && old('shape') != NULL) checked @endif onchange="enterCustom(this, 'product_shape')" id="enter_custom_product_shape" class="my-auto w-4 h-4 text-primary-one bg-gray-400 border-gray-500 rounded focus:ring-primary-one dark:focus:ring-primary-two dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </div>
                            <input name="shape" oninput="setInput('product_shape')" id="custom_product_shape" type="text" placeholder="Enter Shape" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <select wire:model="shape"
                                name="shape" id="product_shape" class="form-select ml-3 bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
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

                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <div class="flex justify-between">
                                <x-input-label for="product_color" :value="__('Product Color')" class="text-black" />
                                <div class="flex gap-2">
                                    <x-input-label :value="__('Custom')" class="text-sm text-black font-semibold" />
                                    <input wire:model="enter_custom_product_color" type="checkbox" name="enter_custom_product_color" @if(!in_array(old('color'), $colors->toArray()) && old('color') != NULL) checked @endif onchange="enterCustom(this, 'product_color')" id="enter_custom_product_color" class="my-auto w-4 h-4 text-primary-one bg-gray-400 border-gray-500 rounded focus:ring-primary-one dark:focus:ring-primary-two dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </div>
                            <input name="color" id="custom_product_color" oninput="setInput('product_color')" type="text" placeholder="Enter Color" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <select wire:model="color" name="color" id="product_color" class=" form-select ml-3 bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
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
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <div class="flex justify-between">
                                <x-input-label for="product_usage" :value="__('Product Usage')" class="text-black" />
                                <div class="flex gap-2">
                                    <x-input-label :value="__('Custom')" class="text-sm text-black-500 font-semibold" />
                                    <input wire:model="enter_custom_product_usage" type="checkbox" name="enter_custom_product_usage" @if(!in_array(old('usage'), $usages->toArray()) && old('usage') != NULL) checked @endif onchange="enterCustom(this, 'product_usage')" id="enter_custom_product_usage" class="my-auto w-4 h-4 text-primary-one bg-gray-400 border-gray-500 rounded focus:ring-primary-one dark:focus:ring-primary-two dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </div>
                            <input type="text" name="usage" id="custom_product_usage" oninput="setInput('product_usage')" placeholder="Enter Product Usage" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <select name="usage" wire:model="usage" id="product_usage" class=" form-select ml-3 bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
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
                        <div class="form-group lg:col-span-2 col-md-6 col-lg-5 mb-2 ml-2">
                            <x-input-label for="product_description" :value="__('Product Description')" class="text-black" />
                            <textarea wire:model="description" type="text" name="description" rows="4" id="product_description" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" ></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <x-input-label for="product_model_number" :value="__('Product\'s Model Number')" class="text-black" />
                            <input wire:model="model_number" type="text" name="model_number" id="product_model_number" min="0" class="ml-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" >
                            <x-input-error :messages="$errors->get('model_number')" class="mt-2" />
                        </div>
                        <div class="form-group col-md-6 col-lg-5 mb-2 ml-2">
                            <div class="flex justify-between">
                                <x-input-label for="product_regional_feature" :value="__('Product\'s Regional Feature')" class="text-black" />
                                <div class="flex gap-2">
                                    <x-input-label :value="__('Custom')" class="text-sm text-black font-semibold" />
                                    <input wire:model="enter_custom_regional_feature" type="checkbox" name="enter_custom_regional_feature" @if(!in_array(old('regional_feature'), $regions->toArray()) && old('regional_feature') != NULL) checked @endif onchange="enterCustom(this, 'regional_feature')" id="enter_custom_regional_feature" class="my-auto w-4 h-4 text-primary-one bg-gray-400 border-gray-500 rounded focus:ring-primary-one dark:focus:ring-primary-two dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </div>
                            <input name="regional_feature" id="custom_regional_feature" oninput="setInput('regional_feature')" type="text" placeholder="Enter Regional Feature" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <select wire:model="regional_feature" name="regional_feature" id="regional_feature" class="form-select ml-3 bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
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
                    </div>
                </div>
                <div class="mb-2 mt-3 pull-right pr-30">
                    <button class="btn btn-md btn-primary btn-round waves-effect" type="submit">Next</button>
                </div>
            </div>

        </div>

    </form>

</div>

