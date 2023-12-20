<div>
{{--    <h2>Step {{ $currentStep }}</h2>--}}

    @if($currentStep == 1)
        <livewire:product.product-form-step1  wire:loading.remove />

    @elseif($currentStep == 2)
        <livewire:product.product-form-step2  wire:loading.remove />
    @elseif($currentStep == 3)
        <livewire:product.product-form-step3 wire:loading.remove />
        <button wire:click="goToPreviousStep">Submit</button>
    @endif
{{--    <button wire:click="goToNextStep">Next</button>--}}
{{--    <button wire:click="goToPreviousStep">Previous</button>--}}
</div>
{{--<div>--}}
{{--    @if(!empty($successMsg))--}}
{{--        <div class="alert alert-success">--}}
{{--            {{ $successMsg }}--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    <div class="stepwizard">--}}
{{--        <div class="stepwizard-row setup-panel">--}}
{{--            <div class="multi-wizard-step">--}}
{{--                <a href="#step-1" type="button"--}}
{{--                   class="btn {{ $currentStep != 1 ? 'btn-default' : 'btn-primary' }}">1</a>--}}
{{--                <p>Product Information</p>--}}
{{--            </div>--}}
{{--            <div class="multi-wizard-step">--}}
{{--                <a href="#step-2" type="button"--}}
{{--                   class="btn {{ $currentStep != 2 ? 'btn-default' : 'btn-primary' }}">2</a>--}}
{{--                <p>Wing and Location</p>--}}
{{--            </div>--}}
{{--            <div class="multi-wizard-step">--}}
{{--                <a href="#step-3" type="button"--}}
{{--                   class="btn {{ $currentStep != 3 ? 'btn-default' : 'btn-primary' }}"--}}
{{--                   disabled="disabled">3</a>--}}
{{--                <p>Media</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row setup-content {{ $currentStep != 1 ? 'display-none' : '' }}" id="step-1">--}}
{{--        <div class="col-md-12">--}}
{{--            <livewire:product.product-form-step1 wire:key="step1" wire:loading.remove />        </div>--}}
{{--    </div>--}}
{{--    <div class="row setup-content {{ $currentStep != 2 ? 'display-none' : '' }}" id="step-2">--}}
{{--        <div class="col-md-12">--}}
{{--            <livewire:product.product-form-step2 wire:key="step2" wire:loading.remove />--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row setup-content {{ $currentStep != 3 ? 'display-none' : '' }}" id="step-3">--}}
{{--        <div class="col-md-12">--}}
{{--            <livewire:product.product-form-step3 wire:key="step3" wire:loading.remove />--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
