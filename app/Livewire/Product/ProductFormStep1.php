<?php

namespace App\Livewire\Product;

use App\Models\Business;
use App\Models\Category;
use App\Models\MeasurementUnit;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use Livewire\Component;

class ProductFormStep1 extends Component
{
    public $name;
    public $category;
    public $material;
    public $price;
    public $min_price;
    public $max_price;
    public $place_of_origin;
    public $brand;
    public $shape;
    public $min_quantity_order;
    public $max_quantity_order;
    public $min_quantity_order_unit;
    public $max_quantity_order_unit;
    public $color;
    public $usage;

    public $categories = [];
    public $shapes = [];
    public $colors = [];
    public $usages = [];
    public $units = [];
    public $warehouse;
    public $currencies;
    public $regions;
    public $description;
    public $model_number;
    public $product_availability;
    public $regional_feature;
    public $currentStep = 1;
    public $order_quantity_unit;
    public $currency;
    public $initial_quantity;
    public $min_quantity;
    public $max_order_quantity;
    public $enter_custom_regional_feature;
    public $enter_custom_product_usage;
    public $certificate_of_origin;
    public $enter_custom_product_shape;
    public $enter_custom_product_color;
    public $enter_custom_quantity_order_unit;
    public $min_order_quantity;

    public function mount()
    {
        $userwarehouse=UserWarehouse::where('user_id', auth()->user()->id)->first();
        $this->business = Business::all();
        $this->categories = Category::all();
        $this->units = MeasurementUnit::all();
        $this->shapes = collect(['Rectangle', 'Circle', 'Square', 'Rhombus', 'Sphere']);
        $this->colors = collect(['Red', 'Green', 'Blue', 'Purple', 'Yellow', 'Maroon', 'Orange', 'Gray', 'Magenta', 'Teal', 'Gold', 'White', 'Black']);
        $this->usages = collect(['Home Decor', 'Office Decor']);
        $this->regions = collect(['Africa', 'USA', 'Europe', 'Middle East', 'Asia', 'Other']);
        $this->currencies = collect(['USD', 'EUR', 'GBP', 'KSH', 'JPY']);
        $this->warehouse = optional($userwarehouse)->warehouse_id;
    }

    public function nextStep()
    {
        $this->validate([
            'name' => ['required'],
            'category' => ['required'],
            'price' => ['required_without:min_price', 'required_without:max_price', 'numeric'],
            'min_price' => ['required_without:price', 'numeric'],
            'max_price' => ['required_without:price', 'numeric'],
            'min_quantity_order_unit' => ['required_with:min_quantity_order'],
            'max_quantity_order_unit' => ['required_with:max_quantity_order'],
            'description' => ['required'],
            'model_number' => ['required']
        ]);
        session([
            'product_step1' => [
                'name' => $this->name,
                'category' => $this->category,
                'price' => $this->price,
                'min_price' => $this->min_price,
                'max_price' => $this->max_price,
                'min_quantity_order_unit' => $this->min_quantity_order_unit,
                'max_quantity_order_unit' => $this->max_quantity_order_unit,
                'description' => $this->description,
                'model_number' => $this->model_number,
                'material' => $this->material,
                'place_of_origin' => $this->place_of_origin,
                'brand' => $this->brand,
                'shape' => $this->shape,
                'min_quantity_order' => $this->min_quantity_order,
                'max_quantity_order' => $this->max_quantity_order,
                'usage' => $this->usage,
                'is_available' => $this->product_availability,
                'regional_featre' => $this->regional_feature,
                'is_warehouse_product'=>1,
                'order_quantity_unit'=>$this->order_quantity_unit,
                'currency'=>$this->currency,
                'enter_custom_regional_feature'=>$this->enter_custom_regional_feature,
                'initial_quantity'=>$this->initial_quantity,
                'min_quantity'=>$this->min_quantity,
                'max_order_quantity'=>$this->max_order_quantity,
                'enter_custom_product_usage'=>$this->enter_custom_product_usage,
                'certificate_of_origin'=>$this->certificate_of_origin,
                'enter_custom_product_shape'=>$this->enter_custom_product_shape,
                'enter_custom_product_color'=>$this->enter_custom_product_color,
                'enter_custom_quantity_order_unit'=>$this->enter_custom_quantity_order_unit,
                'min_order_quantity'=>$this->min_order_quantity,
                'warehouse'=>$this->warehouse
                ]
        ]);

        $this->currentStep = 2;
//        $this->dispatch('goToNextStep');
        $this->dispatch('goToNextStepEvent');

    }

    public function render()
    {
        return view('livewire.product.product-form-step1');
    }
}
