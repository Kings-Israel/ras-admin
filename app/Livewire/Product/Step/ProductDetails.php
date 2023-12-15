<?php

namespace App\Livewire\Product\Step;

use App\Models\Category;
use App\Models\MeasurementUnit;
use Livewire\Component;
use Spatie\LivewireWizard\Components\StepComponent;

class ProductDetails extends StepComponent
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
    public $currentStep = 1;
    public $categories = [];
    public $shapes = [];
    public $colors = [];
    public $usages = [];
    public $units = [];

    protected $rules = [
        'name' => ['required'],
        'category' => ['required'],
        'price' => ['required_without:min_price', 'required_without:max_price'],
        'min_price' => ['required_without:price'],
        'max_price' => ['required_without:price'],
        'min_quantity_order_unit' => ['required_with:min_quantity_order'],
        'max_quantity_order_unit' => ['required_with:max_quantity_order']
    ];

    public function mount()
    {
        $this->categories = Category::all();
        $this->shapes = ['Rectangle', 'Circle', 'Square', 'Rhombus', 'Sphere'];
        $this->colors = ['Red', 'Green', 'Blue', 'Purple', 'Yellow', 'Maroon', 'Orange', 'Gray', 'Magenta', 'Teal', 'Gold', 'White', 'Black'];
        $this->usages = ['Home Decor', 'Office Decor'];
        $this->units = MeasurementUnit::all();
    }

    public function stepInfo(): array
    {
        return [
            'label' => 'Product Details',
        ];
    }

    public function submit()
    {
        $this->validate();

        $this->nextStep();
    }
    public function nextStep()
    {
        $this->currentStep++;
    }
    public function previousStep()
    {
        $this->currentStep--;
    }
    public function render()
    {
        return view('livewire.product.steps.product-details');
    }
}
