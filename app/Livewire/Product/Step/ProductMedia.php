<?php

namespace App\Livewire\Product\Step;

use App\Models\Product;
use App\Models\ProductMedia as ModelsProductMedia;
use App\Models\Warehouse;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\LivewireWizard\Components\StepComponent;

class ProductMedia extends StepComponent
{
    use WithFileUploads;

    public $description;
    public $regional_feature;
    public $warehouse;
    public $model_number;
    public $images = [];
    public $video;
    public $product_availability = true;

    public $warehouses;
    public $regions;

    protected $rules = [
        'description' => ['required'],
        'model_number' => ['required'],
        'images' => ['required', 'array'],
        'images.*' => ['mimes:png,jpg,jpeg', 'max:4096'],
        'video' => ['nullable', 'mimes:mp4', 'max:10000']
    ];

    protected $messages = [
        'images.*.mimes' => 'Supported image formats are: .png, .jpg, .jpeg',
        'video.mimes' => 'Supported video format is: .mp4',
        'images.*.max' => 'Max image size is 4MB',
        'video.max' => 'Max video size is 10MB',
    ];

    public function stepInfo(): array
    {
        return [
            'label' => 'Media & More',
        ];
    }

    public function mount()
    {

        $this->warehouses = Warehouse::with('country', 'city')->get();
        $this->regions = ['Africa', 'USA', 'Europe', 'Middle East', 'Asia', 'Other'];
        $this->images = [];
        $this->video = null;
    }

    public function submit()
    {
        $this->validate();

        $product = Product::create([
            'business_id' => auth()->user()->business->id,
            'name' => $this->state()->forStep('product-details')['name'],
            'category_id' => $this->state()->forStep('product-details')['category'],
            'price' => $this->state()->forStep('product-details')['price'],
            'min_price' => $this->state()->forStep('product-details')['min_price'],
            'max_price' => $this->state()->forStep('product-details')['max_price'],
            'max_order_quantity' => $this->state()->forStep('product-details')['max_quantity_order'].' '.$this->state()->forStep('product-details')['max_quantity_order_unit'],
            'min_order_quantity' => $this->state()->forStep('product-details')['min_quantity_order'].' '.$this->state()->forStep('product-details')['min_quantity_order_unit'],
            'color' => $this->state()->forStep('product-details')['color'],
            'shape' => $this->state()->forStep('product-details')['shape'],
            // 'usage' => $this->state()->forStep('product-details')['usage'],
            'brand' => $this->state()->forStep('product-details')['brand'],
            'material' => $this->state()->forStep('product-details')['material'],
            'place_of_origin' => $this->state()->forStep('product-details')['place_of_origin'],
            'description' => $this->description,
            'warehouse_id' => $this->warehouse,
            'model_number' => $this->model_number,
            'is_available' => $this->product_availability,
            'regional_featre' => $this->regional_feature,
        ]);

        foreach ($this->images as $image) {
            ModelsProductMedia::create([
                'product_id' => $product->id,
                'file' => pathinfo($image->store('product', 'vendor'), PATHINFO_BASENAME),
                'type' => 'image',
            ]);
        }

        if ($this->video) {
            ModelsProductMedia::create([
                'product_id' => $product->id,
                'file' => pathinfo($this->video->store('product', 'vendor'), PATHINFO_BASENAME),
                'type' => 'video',
            ]);
        }

        activity()->causedBy(auth()->user())->performedOn($product)->log('add a new product');

        toastr()->success('', 'Product added successfully');

        return redirect()->route('products');
    }
    public function render()
    {
        return view('livewire.product.steps.product-media');
    }
}
