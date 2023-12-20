<?php

namespace App\Livewire\Product;

use Livewire\Component;

class StepManager extends Component
{
    public $currentStep = 1;
    protected $listeners = ['goToNextStepEvent' => 'goToNextStep','goToNextPreviousEvent' => 'goToPreviousStep'];

    public function render()
    {
        return view('livewire.product.step-manager');
    }

    public function goToNextStep()
    {
        info('triggered goToNextStep');
        $this->currentStep++;
    }

    public function goToPreviousStep()
    {
        info('triggered goTopreviousStep');
        $this->currentStep--;
    }

}
