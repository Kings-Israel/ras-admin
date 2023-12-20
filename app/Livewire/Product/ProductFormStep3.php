<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\WarehouseProduct;
use App\Models\WarehouseRestocking;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductFormStep3 extends Component
{
    use WithFileUploads;

    public $images = [];
    public $video;
    public $videos;
    public $productAvailability = true;

    protected $rules = [
        'images' => ['required', 'array'],
        'images.*' => ['mimes:png,jpg,jpeg', 'max:4096'],
        'video' => ['nullable', 'mimes:mp4', 'max:10000'],
        'productAvailability' => ['boolean'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.product.product-form-step3');
    }

    public function submitForm()
    {
        $this->validate();
        try {
            DB::beginTransaction();

            $product = Product::create([
                'name' => $this->product_step1->name,
                'category_id' => $this->product_step1->category,
                'price' => $this->price,
                'min_price' => $this->min_price,
                'max_price' => $this->max_price,
                'max_order_quantity' => $this->max_quantity_order . ' ' . $this->max_quantity_order_unit,
                'min_order_quantity' => $this->min_quantity_order . ' ' . $this->min_quantity_order_unit,
                'color' => $this->color,
                'shape' => $this->shape,
                'brand' => $this->brand,
                'material' => $this->material,
                'place_of_origin' => $this->place_of_origin,
                'description' => $this->description,
                'model_number' => $this->model_number,
                'is_available' => $this->product_availability,
                'regional_feature' => $this->regional_feature,
                'is_warehouse_product' => 1,
            ]);

            $product_id = $product->id;

            WarehouseProduct::create([
                'warehouse_id' => $this->warehouse,
                'product_id' => $product_id,
                'quantity' => $this->initial_quantity,
                'wing_locations_id' => $this->wingLocation,
                'min_quantity' => $this->min_quantity,
            ]);

            if ($this->initial_quantity > 0) {
                WarehouseRestocking::create([
                    'product_id' => $product_id,
                    'warehouse_id' => $this->warehouse,
                    'user_id' => auth()->user()->id,
                    'quantity' => $this->initial_quantity,
                ]);
            }

            foreach ($this->images as $image) {
                ProductMedia::create([
                    'product_id' => $product_id,
                    'file' => pathinfo($image->store('product', 'warehouse'), PATHINFO_BASENAME),
                    'type' => 'image',
                ]);
            }

            if ($this->video) {
                ProductMedia::create([
                    'product_id' => $product_id,
                    'file' => pathinfo($this->video->store('product', 'warehouse'), PATHINFO_BASENAME),
                    'type' => 'video',
                ]);
            }

            DB::commit();
            session()->forget('product_step1');
            activity()->causedBy(auth()->user())->performedOn($product)->log('add a new product');

            toastr()->success('', 'Product added successfully');

            return redirect()->route('products');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('', 'An error occurred while adding the product');
            return redirect()->route('products');
        }
    }

    public function previousStep()
    {
        $wing_l = session('wing_location');

        if ($wing_l) {
            $this->fill($wing_l);
        }
        $this->currentStep = 2;
        $this->fill(session(['wing_location']));
        $this->dispatch('goToNextPreviousEvent');
    }
}
