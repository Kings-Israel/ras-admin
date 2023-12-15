<?php

namespace App\Livewire\Product;

use App\Livewire\Product\Step\ProductDetails;
use App\Livewire\Product\Step\ProductMedia;
use Livewire\Component;
use Spatie\LivewireWizard\Components\WizardComponent;

class AddProductComponent extends WizardComponent
{
    public function steps(): array
    {
        return [
            ProductDetails::class,
            ProductMedia::class,
        ];
    }
}
