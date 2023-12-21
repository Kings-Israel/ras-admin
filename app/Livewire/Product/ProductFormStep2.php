<?php

namespace App\Livewire\Product;

use App\Models\UserWarehouse;
use App\Models\Warehouse;
use App\Models\Wing;
use Livewire\Component;

class ProductFormStep2 extends Component
{
    public $wings;
    public $selectedWing;
    public  $wing_location;
    public $wingLocations = [];
    public $currentStep = 2;
    public function mount()
    {
        $userwarehouse=UserWarehouse::where('user_id', auth()->user()->id)->first();
        $warehouse = Warehouse::find($userwarehouse->warehouse_id);
        $this->wings=Wing::where('warehouse_id', $warehouse->id)->with('locations')->get();
    }

    public function updatedSelectedWing($value)
    {
        if (!empty($value)) {
            $selectedWing = Wing::findOrFail($value);
            $this->wingLocations = $selectedWing->locations()->pluck('location_name', 'id')->toArray();
            info($this->wingLocations);
        } else {
            $this->wingLocations = [];
        }
    }
    public function render()
    {
        return view('livewire.product.product-form-step2');
    }
    public function nextStep()
    {
        session()->put('wing_location', $this->wing_location);
        $this->currentStep = 3;
        $this->dispatch('goToNextStepEvent');
    }

    public function previousStep()
    {
        $productStep1 = session('product_step1');

        if ($productStep1) {
            $this->fill($productStep1);
        }

        $this->currentStep = 1;
        $this->dispatch('goToNextPreviousEvent');
    }


}
