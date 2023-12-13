@props([
    'modal_id',
    'modal_placement' => ''
])

<!-- Main modal -->
<div
    id="{{ $modal_id }}"
    tabindex="-1"
    aria-hidden="true"
    data-modal-placement="{{ $modal_placement }}"
    {{ $attributes->merge([ "class" => "fixed top-0 left-0 right-0 z-50 hidden w-full p-1 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"]) }}
>
    {{ $slot }}
</div>
