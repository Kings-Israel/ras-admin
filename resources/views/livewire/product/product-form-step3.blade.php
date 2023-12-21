<div>
    <div class="card">
    <h3> Media </h3>
        <form wire:submit.prevent="submitForm">
<div class="row">
    <div class="form-group">
        <x-input-label for="images" :value="__('Add Product Images')" class="text-black" />
        <input type="file" wire:model="images" multiple accept=".jpg, .jpeg, .png" class="mb-2">
        <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
    </div>

    <div class="form-group">
        <x-input-label for="videos" :value="__('Add Product Videos')" class="text-black" />
        <input type="file" wire:model="videos" multiple accept=".mp4" class="mb-2">
        <x-input-error :messages="$errors->get('videos.*')" class="mt-2" />
    </div>
</div>

    <div class="flex justify-end gap-2 mt-2 mb-4 pull right">
        <button wire:click="previousStep" class="btn btn-primary btn-round waves-effect btn-md  mr-4">Previous</button>
        <button class="btn btn-primary btn-round waves-effect btn-md " type="submit">Submit</button>
    </div>
        </form>
</div>

</div>
    <!-- Display selected images -->
    @if($images)
        <h5>Selected Images:</h5>
        @foreach($images as $index => $image)
            <p>{{ $index + 1 }}. {{ $image->getClientOriginalName() }}</p>
        @endforeach
    @endif

    <!-- Display selected videos -->
    @if($videos)
        <h5>Selected Videos:</h5>
        @foreach($videos as $index => $video)
            <p>{{ $index + 1 }}. {{ $video->getClientOriginalName() }}</p>
        @endforeach
    @endif
</div>

