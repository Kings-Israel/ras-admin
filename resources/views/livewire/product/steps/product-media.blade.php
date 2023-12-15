<div>
    @include('livewire.product.add-product-nav')
    <div class="grid md:grid-cols-2 gap-3">
        <div>
            <x-input-label for="product_description" :value="__('Product Description')" class="text-gray-500"/>
            <input type="text" name="description" id="product_description" wire:model="description"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                   required>
            <x-input-error :messages="$errors->get('description')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="product_regional_feature" :value="__('Product\'s Regional Feature')"
                           class="text-gray-500"/>
            <select name="regional_feature" id="regional_feature"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <option value="">Select Product Regional Feature</option>
                @foreach ($regions as $region)
                    <option value="{{ $region }}"
                            @if(in_array(old('regional_feature'), $regions)) selected @endif>{{ $region }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('regional_feature')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="product_link_to_warehouse" :value="__('Link to Warehouse')" class="text-gray-500"/>
            <select name="warehouse" id="link_to_warehouse" wire:model="warehouse"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                <option value="">Select Warehouse</option>
                @foreach ($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}"
                            @if(in_array(old('warehouse'), $warehouses->toArray())) selected @endif>{{ $warehouse->name.', '.$warehouse->city->name.', '.$warehouse->country->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('warehouse')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="product_model_number" :value="__('Product\'s Model Number')" class="text-gray-500"/>
            <input type="text" name="model_number" id="product_model_number" wire:model="model_number" min="0"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                   required>
            <x-input-error :messages="$errors->get('model_number')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="product_images" :value="__('Add Product Images')" class="text-gray-500"/>
            <div class="flex flex-col flex-grow mb-3 hover:cursor-pointer">
                <div x-data="{ images: null }" id="FileUpload"
                     class="block w-full py-2 px-3 relative bg-gray-200 appearance-none border-2 border-dashed border-gray-300 rounded-md hover:shadow-outline-gray">
                    <input type="file" multiple accept=".jpg,.jpeg,.png" wire:model="images"
                           class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                           x-on:change="images = $event.target.files;"
                           x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')"
                           x-on:drop="$el.classList.remove('active')"
                    >
                    @if (count($images) > 0)
                        <div class="flex flex-col space-y-1">
                            @foreach ($images as $key => $image)
                                <div class="flex flex-row justify-between items-center space-x-2">
                                    <span class="font-medium text-gray-900">{{ $image->getClientOriginalName() }}</span>
                                    <span class="text-xs self-end text-gray-500">{{ App\Helpers\HelperFunctions::formatBytes($image->getSize()) }}...</span>
                                </div>
                                <x-input-error :messages="$errors->get('images.'.$key)" class="mt-2"/>
                            @endforeach
                        </div>
                    @endif
                    {{-- <template x-if="images !== null">
                        <div class="flex flex-col space-y-1">
                            <template x-for="(_,index) in Array.from({ length: images.length })">
                                <div class="flex flex-row items-center space-x-2">
                                    <template x-if="images[index].type.includes('audio/')"><i class="fas fa-file-audio"></i></template>
                                    <template x-if="images[index].type.includes('application/')"><i class="fas fa-file-alt"></i></template>
                                    <template x-if="images[index].type.includes('image/')"><i class="fas fa-file-image"></i></template>
                                    <template x-if="images[index].type.includes('video/')"><i class="fas fa-file-video"></i></template>
                                    <span class="font-medium text-gray-900" x-text="images[index].name">Uploading</span>
                                    <span class="text-xs self-end text-gray-500" x-text="filesize(images[index].size)">...</span>
                                </div>
                            </template>
                        </div>
                    </template> --}}
                    <template x-if="images === null">
                        <div class="flex flex-col space-y-2 items-center justify-center">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <a href="javascript:void(0)"
                               class="flex items-center mx-auto py-1 px-3 text-red-700 text-center text-sm font-bold border border-transparent rounded-md outline-none bg-red-400">UPLOAD
                                A FILE</a>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span>
                                or drag and drop</p>
                        </div>
                    </template>
                </div>
            </div>
            <x-input-error :messages="$errors->get('images')" class="mt-2"/>
        </div>
        <div>
            <x-input-label for="product_video" :value="__('Add Product Video')" class="text-gray-500"/>
            <div class="flex flex-col flex-grow mb-3 hover:cursor-pointer">
                <div x-data="{ video: null }" id="FileUpload"
                     class="block w-full py-2 px-3 relative bg-gray-200 appearance-none border-2 border-dashed border-gray-300 rounded-md hover:shadow-outline-gray">
                    <input type="file" accept=".mp4" wire:model="video"
                           class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                           x-on:change="video = $event.target.files;"
                           x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')"
                           x-on:drop="$el.classList.remove('active')"
                    >
                    @if ($video)
                        <div class="flex justify-between space-y-1">
                            <span class="font-medium text-gray-900">{{ $video->getClientOriginalName() }}</span>
                            <span class="text-xs text-gray-500">{{ App\Helpers\HelperFunctions::formatBytes($video->getSize()) }}...</span>
                        </div>
                    @endif
                    <template x-if="video === null">
                        <div class="flex flex-col space-y-2 items-center justify-center">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <a href="javascript:void(0)"
                               class="flex items-center mx-auto py-1 px-3 text-red-700 text-center text-sm font-bold border border-transparent rounded-md outline-none bg-red-400">UPLOAD
                                A FILE</a>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span>
                                or drag and drop</p>
                        </div>
                    </template>
                </div>
            </div>
            <x-input-error :messages="$errors->get('video')" class="mt-2"/>
        </div>
        <div>
            <x-input-label class="font-bold text-gray-500">Confirm Availabilty Status</x-input-label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" checked value="in-stock" class="sr-only peer" name="product_availability"
                       wire:model="product_availability">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">In Stock</span>
            </label>
        </div>
    </div>
    <div class="flex justify-end gap-2 mt-4">
        <x-secondary-outline-button class="text-center text-gray-800 gap-2 focus:ring-0" wire:click="previousStep"><i
                    class="fas fa-arrow-left text-gray-800"></i> Back
        </x-secondary-outline-button>
        <x-primary-button type="submit" class="w-2/5 font-semibold rounded-lg px-5 py-2.5 text-center"
                          wire:click="submit">Add Product
        </x-primary-button>
    </div>
</div>
