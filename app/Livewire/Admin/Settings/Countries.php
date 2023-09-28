<?php

namespace App\Livewire\Admin\Settings;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Countries extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createCountry(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'iso' => 'required',
        ]);

        Country::create($request->all());

        toastr()->success('', 'Country created successfully');

        return redirect()->route('settings.index');
    }

    public function updateCountry(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required',
            'iso' => 'required',
        ]);

        $country->update($request->all());

        toastr()->success('', 'Country updated successfully');

        return redirect()->route('settings.index');
    }

    public function deleteCountry(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            toastr()->error('', 'Cannot perform this action. Invalid password');

            return back();
        }

        Country::destroy($request->country_id);

        toastr()->success('', 'Country deleted successfully');

        return redirect()->route('settings.index');
    }

    public function createCity(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'iso' => 'required',
        ]);

        City::create($request->all());

        toastr()->success('', 'City created successfully');

        return redirect()->route('settings.index');
    }

    public function updateCity(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required',
            'iso' => 'required',
        ]);

        $city->update($request->all());

        toastr()->success('', 'City updated successfully');

        return redirect()->route('settings.index');
    }

    public function deleteCity(Request $request)
    {
        $request->validate([
            'city_id' => 'required',
        ]);

        City::destroy($request->country_id);

        toastr()->success('', 'City deleted successfully');

        return redirect()->route('settings.index');
    }

    public function render()
    {
        $countries = Country::withCount('cities', 'businesses', 'warehouses')
                            ->when($this->search && $this->search != '', function ($query) {
                                $query->where('name', 'LIKE', '%'.$this->search.'%');
                            })
                            ->orderBy('name', 'ASC')
                            ->cursorPaginate(5);

        return view('livewire.admin.settings.countries', [
            'countries' => $countries
        ]);
    }
}
