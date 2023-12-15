<div>
    @include('livewire.product.add-product-nav')
    <div class="mb-2">
        <x-input-label for="product_name" :value="__('Product Name')" class="text-gray-500"/>
        <input type="text" name="name" id="product_name" wire:model="name" autocomplete="off"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
               required>
        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
    </div>
    <div class="grid md:grid-cols-2 gap-3">
        <div>
            @php($category_ids = $categories->pluck('id')->toArray())
            <x-input-label for="product_category" :value="__('Product Category')" class="text-gray-500"/>
            <select name="category" id="category" wire:model="category"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <option value="">Select Product Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                            @if(in_array(old('category'), $category_ids)) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="product_material" :value="__('Product Material')" class="text-gray-500"/>
            <input type="text" name="material" wire:model="material" id="product_material"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
            <x-input-error :messages="$errors->get('material')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="product_price" :value="__('Price (USD$)')" class="text-gray-500"/>
            <input type="number" name="price" id="product_price" wire:model="price" min="0" placeholder="0.00"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                   required>
            <x-input-error :messages="$errors->get('price')" class="mt-2"/>
        </div>
        <div class="grid grid-cols-2 gap-1">
            <div>
                <x-input-label for="product_min_price" :value="__('Min price (USD$)')" class="text-gray-500"/>
                <input type="number" name="min_price" id="product_min_price" wire:model="min_price" min="0"
                       placeholder="0.00"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                       required>
                <x-input-error :messages="$errors->get('min_price')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="product_max_price" :value="__('Max Price(USD$)')" class="text-gray-500"/>
                <input type="number" name="max_price" id="product_max_price" wire:model="max_price" min="0"
                       placeholder="0.00"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                       required>
                <x-input-error :messages="$errors->get('min_price')" class="mt-2"/>
            </div>
        </div>
        <div class="flex gap-1">
            <div class="basis-3/4">
                <x-input-label for="product_minimum_quantity_order" :value="__('Minimum Quantity Order')"
                               class="text-gray-500"/>
                <input type="number" name="minimum_quantity_order" id="product_minimum_quantity_order"
                       wire:model="min_quantity_order" min="1" placeholder="0"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                       required>
                <x-input-error :messages="$errors->get('minimum_quantity_order')" class="mt-2"/>
                <x-input-error :messages="$errors->get('minimum_quantity_order_unit')" class="mt-2"/>
            </div>
            <div class="basis-1/4">
                <x-input-label for="product_brand" :value="__('Unit')" class="text-gray-500"/>
                <select name="min_quantity_order_unit" id="min_quantity_order_unit" wire:model="min_quantity_order_unit"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    <option value="">Unit</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->name }}"
                                @if(in_array(old('min_quantity_order_unit'), $units->toArray())) selected @endif>{{ $unit->name }} @if($unit->abbrev)
                                - ({{ $unit->abbrev }})
                            @endif</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-1">
            <div class="basis-3/4">
                <x-input-label for="product_maximum_quantity_order" :value="__('Maximum Quantity Order')"
                               class="text-gray-500"/>
                <input type="number" name="maximum_quantity_order" id="product_maximum_quantity_order"
                       wire:model="max_quantity_order" min="1" placeholder="0"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                       required>
                <x-input-error :messages="$errors->get('maximum_quantity_order')" class="mt-2"/>
                <x-input-error :messages="$errors->get('maximum_quantity_order_unit')" class="mt-2"/>
            </div>
            <div class="basis-1/4">
                <x-input-label for="product_brand" :value="__('Unit')" class="text-gray-500"/>
                <select name="max_quantity_order_unit" id="max_quantity_order_unit" wire:model="max_quantity_order_unit"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    <option value="">Unit</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->name }}"
                                @if(in_array(old('max_quantity_order_unit'), $units->toArray())) selected @endif>{{ $unit->name }} @if($unit->abbrev)
                                - ({{ $unit->abbrev }})
                            @endif</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <x-input-label for="product_place_of_origin" :value="__('Product Place of Origin')" class="text-gray-500"/>
            <input type="text" name="place_of_origin" id="product_origin" wire:model="place_of_origin"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
            <x-input-error :messages="$errors->get('place_of_origin')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="product_brand" :value="__('Product Brand')" class="text-gray-500"/>
            <input type="text" name="brand" id="product_brand" wire:model="brand"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
            <x-input-error :messages="$errors->get('brand')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="product_shape" :value="__('Product Shape')" class="text-gray-500"/>
            <select name="shape" id="product_shape" wire:model="shape"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <option value="">Select Product Shape</option>
                @foreach ($shapes as $shape)
                    <option value="{{ $shape }}"
                            @if(in_array(old('shape'), $shapes)) selected @endif>{{ $shape }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('shape')" class="mt-2"/>
        </div>

        <div>
            <x-input-label for="product_color" :value="__('Product Color')" class="text-gray-500"/>
            <select name="color" id="product_color" wire:model="color"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <option value="">Select Product Color</option>
                @foreach ($colors as $color)
                    <option value="{{ $color }}"
                            @if(in_array(old('color'), $colors)) selected @endif>{{ $color }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('color')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="product_usage" :value="__('Product Usage')" class="text-gray-500"/>
            <select name="usage" id="product_usage" wire:model="usage"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <option value="">Select Product usage</option>
                @foreach ($usages as $usage)
                    <option value="{{ $usage }}"
                            @if(in_array(old('usage'), $usages)) selected @endif>{{ $usage }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('usage')" class="mt-2"/>
        </div>
    </div>
    <div class="flex justify-end gap-2 mt-4">
        {{-- <x-secondary-outline-button class="text-center font-thin text-gray-800" data-modal-hide="add-product-modal">Discard</x-secondary-outline-button> --}}
        <x-primary-button type="submit" class="w-2/5 font-semibold rounded-lg px-5 py-2.5 text-center"
                          wire:click="submit">Proceed
        </x-primary-button>
    </div>
</div>
