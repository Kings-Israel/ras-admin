<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Country;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('user', 'country', 'city')->withCount('products')->get();

        return view('warehouses.index', [
            'page' => 'Warehouses',
            'breadcrumbs' => [
                'Warehouses' => route('warehouses')
            ],
            'warehouses' => $warehouses
        ]);
    }

    public function create()
    {
        $countries = Country::with('cities')->orderBy('name', 'ASC')->get();

        $users = User::whereHas('roles', fn ($query) => $query->where('name', 'warehouse manager'))->get();

        return view('warehouses.create', [
            'page' => 'Add Warehouse',
            'breadcrumbs' => [
                'Warehouses' => route('warehouses'),
                'Add Warehouse' => route('warehouses.create'),
            ],
            'countries' => $countries,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required_without:user_id'],
            'last_name' => ['required_without:user_id'],
            'email' => ['required_without:user_id'],
            'phone_number' => ['required_without:user_id'],
            'name' => ['required'],
            'user_id' => ['required_without:user_first_name', 'required_without:user_last_name', 'required_without:user_email', 'required_without:user_phone_number'],
            'max_capacity' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'place_id' => ['required'],
        ], [
            'place_id.required' => 'Please select location',
            'first_name.required_without' => 'Enter manager\'s first name',
            'last_name.required_without' => 'Enter manager\'s last name',
            'email.required_without' => 'Enter manager\'s email',
            'phone_number.required_without' => 'Enter manager\'s phone number'
        ]);

        $country = null;

        // Get location string
        $warehouse_location = Http::get('https://maps.googleapis.com/maps/api/geocode/json?place_id='.$request->place_id.'&key=AIzaSyCisnVFSnc5QVfU2Jm2W3oRLqMDrKwOEoM');

        foreach ($warehouse_location['results'][0]['address_components'] as $place) {
            if (collect($place['types'])->contains('country')) {
                $country = Country::where('name', 'LIKE', $place['long_name'])->orWhere('iso', 'LIKE', $place['short_name'])->first();
                if (!$country) {
                    toastr()->error('', 'Please select a valid location');
                    return back();
                }
            }
        }

        if (!$request->has('user_id') || $request->user_id == NULL) {
            $user = User::create([
                'first_name' => $request->user_first_name,
                'last_name' => $request->user_last_name,
                'email' => $request->user_email,
                'phone_number' => $request->user_phone_number,
                'password' => Helpers::generatePassword()
            ]);

            $user->assignRole('warehouse manager');

            // TODO: Email credetails to the user
        }

        Warehouse::create([
            'name' => $request->name,
            'user_id' => !$request->has('user_id') || $request->user_id == NULL ? $user->id : $request->user_id,
            'country_id' => $country->id,
            'max_capacity' => $request->max_capacity,
            'latitude' => $warehouse_location['results'][0]['geometry']['location']['lat'],
            'longitude' => $warehouse_location['results'][0]['geometry']['location']['lng'],
            'location' => $warehouse_location['results'][0]['formatted_address'],
            'price' => $request->price,
            'occuppied_capacity' => 0,
        ]);

        toastr()->success('', 'Warehouse added successfully');

        return redirect()->route('warehouses');
    }

    public function edit(Warehouse $warehouse)
    {
        $users = User::whereHas('roles', fn ($query) => $query->where('name', 'warehouse manager'))->get();
        return view('warehouses.edit', [
            'page' => 'Edit Warehouse',
            'breadcrumbs' => [
                'Warehouses' => route('warehouses'),
                'Edit '.$warehouse->name => route('warehouses.edit', ['warehouse' => $warehouse])
            ],
            'warehouse' => $warehouse->load('user'),
            'users' => $users
        ]);
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'first_name' => ['required_without:user_id'],
            'last_name' => ['required_without:user_id'],
            'email' => ['required_without:user_id'],
            'phone_number' => ['required_without:user_id'],
            'name' => ['required'],
            'user_id' => ['required_without:first_name', 'required_without:last_name', 'required_without:email', 'required_without:phone_number'],
            'max_capacity' => ['required', 'integer'],
            'price' => ['required', 'integer'],
        ], [
            'user_id.required_without' => 'Select manager or add their details',
            'first_name.required_without' => 'Enter manager\'s first name',
            'last_name.required_without' => 'Enter manager\'s last name',
            'email.required_without' => 'Enter manager\'s email',
            'phone_number.required_without' => 'Enter manager\'s phone number'
        ]);

        $country = null;

        if ($request->has('place_id') && $request->place_id != NULL) {
            // Get location string
            $warehouse_location = Http::get('https://maps.googleapis.com/maps/api/geocode/json?place_id='.$request->place_id.'&key=AIzaSyCisnVFSnc5QVfU2Jm2W3oRLqMDrKwOEoM');

            foreach ($warehouse_location['results'][0]['address_components'] as $place) {
                if (collect($place['types'])->contains('country')) {
                    $country = Country::where('name', 'LIKE', $place['long_name'])->orWhere('iso', 'LIKE', $place['short_name'])->first();
                    if (!$country) {
                        toastr()->error('', 'Please select a valid location');
                        return back();
                    }
                }
            }
        }

        if (!$request->has('user_id') || $request->user_id == NULL) {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Helpers::generatePassword()
            ]);

            $user->assignRole('warehouse manager');

            // TODO: Email credetails to the user
        }

        $warehouse->update([
            'name' => $request->name,
            'user_id' => !$request->has('user_id') || $request->user_id == NULL ? $user->id : $request->user_id,
            'country_id' => $request->has('place_id') && $request->place_id != NULL ? $country->id : $warehouse->country_id,
            'location' => $request->has('place_id') && $request->place_id != NULL ? $warehouse_location['results'][0]['formatted_address'] : $warehouse->location,
            'latitude' => $request->has('place_id') && $request->place_id != NULL ? $warehouse_location['results'][0]['geometry']['location']['lat'] : $warehouse->latitude,
            'longitude' => $request->has('place_id') && $request->place_id != NULL ? $warehouse_location['results'][0]['geometry']['location']['lng'] : $warehouse->longitude,
            'max_capacity' => $request->max_capacity,
            'price' => $request->price,
        ]);

        toastr()->success('', 'Warehouse updated successfully');

        return redirect()->route('warehouses');
    }
}
