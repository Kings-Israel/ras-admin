<?php

namespace App\Livewire\Admin\Settings;

use App\Models\City;
use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;

class CountryCitiesList extends Component
{
    use WithPagination;

    public $country;
    public $search;

    public function mount(Country $country)
    {
        $this->country = $country;
    }

    public function render()
    {
        $cities = City::where('country_id', $this->country->id)
                        ->withCount('businesses', 'warehouses')
                        ->when($this->search && $this->search != '', function ($query) {
                            $query->where('name', 'LIKE', '%'.$this->search.'%');
                        })
                        ->orderBy('name', 'ASC')
                        ->cursorPaginate(10);

        return view('livewire.admin.settings.country-cities-list', [
            'cities' => $cities
        ]);
    }
}
