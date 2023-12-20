<div>
        <h3>Wing and Location</h3>

        <form wire:submit.prevent="nextStep">
            <div class="card-body col-6">
                <div class="row">
{{--                    <input type="hidden" name="warehouse" id="warehouse" value="{{ $warehouse }}">--}}
                    <div class="grid md:grid-cols-2 gap-3 ml-5 pl-25">
                        <div class="form-group lg:col-span-2">
                            <x-input-label for="wing" :value="__('Wing')" class="text-black" />
                            <select wire:model="selectedWing" id="wing" name="wing"
                                    class="form-select ml-3 bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Select Wing</option>
                                @foreach($wings as $wing)
                                    <option value="{{ $wing->id }}">{{ $wing->wingname }}</option>
                                @endforeach
                            </select>

                            <div class="form-group">
                                <x-input-label for="winglocation" :value="__('Wing Location')" class="text-black" />
                                <select wire:model="selectedWingLocation" id="wingLocation" name="wingLocation"
                                        class="form-select ml-3 bg-gray-50 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                    <option value="">Select Wing Location</option>
                                    @foreach($wingLocations as $locationId => $locationName)
                                        <option value="{{ $locationId }}">{{ $locationName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-8">
                </div>
                <div class="flex justify-end gap-2 mt-2 mb-4 pull right">
                    <button wire:click="previousStep" class="btn btn-md btn-round waves-effect btn-primary mr-4">Previous</button>
                    <button class="btn btn-md btn-round waves-effect btn-primary" type="submit">Next</button>
                </div>
            </div>
        </form>
</div>
