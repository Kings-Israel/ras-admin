<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Country;
use App\Models\User;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::withCount('users')->with('country', 'city')->withCount('products')->get();

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
            'first_name' => ['required_without:users'],
            'last_name' => ['required_without:users'],
            'email' => ['required_without:user_id'],
            'phone_number' => ['required_without:users'],
            'name' => ['required'],
            'users' => ['required_without:first_name', 'required_without:last_name', 'required_without:email', 'required_without:phone_number', 'array'],
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

        $warehouse = Warehouse::create([
            'name' => $request->name,
            'country_id' => $country->id,
            'max_capacity' => $request->max_capacity,
            'latitude' => $warehouse_location['results'][0]['geometry']['location']['lat'],
            'longitude' => $warehouse_location['results'][0]['geometry']['location']['lng'],
            'location' => $warehouse_location['results'][0]['formatted_address'],
            'price' => $request->price,
            'occuppied_capacity' => 0,
        ]);

        if (!$request->has('users') || $request->users == NULL) {
            $user = User::where('email', $request->user_email)->orWhere('phone_number', $request->user_phone_number)->first();
            if (!$user) {
                $user = User::create([
                    'first_name' => $request->user_first_name,
                    'last_name' => $request->user_last_name,
                    'email' => $request->user_email,
                    'phone_number' => $request->user_phone_number,
                    'password' => Helpers::generatePassword()
                ]);
                
                // Email credetails to the user
                Password::sendResetLink($request->only('email'));
            }

            $user->assignRole('warehouse manager');

            UserWarehouse::create([
                'user_id' => $user->id,
                'warehouse_id' => $warehouse->id,
            ]);

        } else {
            foreach ($request->users as $user) {
                UserWarehouse::firstOrCreate([
                    'warehouse_id' => $warehouse->id,
                    'user_id' => $user,
                ]);
            }
        }

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
            'warehouse' => $warehouse->load('users'),
            'users' => $users
        ]);
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'first_name' => ['required_without:users'],
            'last_name' => ['required_without:users'],
            'email' => ['required_without:users'],
            'phone_number' => ['required_without:users'],
            'name' => ['required'],
            'users' => ['required_without:first_name', 'required_without:last_name', 'required_without:email', 'required_without:phone_number', 'array'],
            'max_capacity' => ['required', 'integer'],
            'price' => ['required', 'integer'],
        ], [
            'user_id.required_without' => 'Select manager(s) or add their details',
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

        $warehouse->update([
            'name' => $request->name,
            'country_id' => $request->has('place_id') && $request->place_id != NULL ? $country->id : $warehouse->country_id,
            'location' => $request->has('place_id') && $request->place_id != NULL ? $warehouse_location['results'][0]['formatted_address'] : $warehouse->location,
            'latitude' => $request->has('place_id') && $request->place_id != NULL ? $warehouse_location['results'][0]['geometry']['location']['lat'] : $warehouse->latitude,
            'longitude' => $request->has('place_id') && $request->place_id != NULL ? $warehouse_location['results'][0]['geometry']['location']['lng'] : $warehouse->longitude,
            'max_capacity' => $request->max_capacity,
            'price' => $request->price,
        ]);

        if (!$request->has('users') || $request->users == NULL) {
            $user = User::create([
                'first_name' => $request->user_first_name,
                'last_name' => $request->user_last_name,
                'email' => $request->user_email,
                'phone_number' => $request->user_phone_number,
                'password' => Helpers::generatePassword()
            ]);

            $user->assignRole('warehouse manager');

            UserWarehouse::create([
                'user_id' => $user->id,
                'warehouse_id' => $warehouse->id,
            ]);

            // TODO: Email credetails to the user
        } else {
            foreach ($request->users as $user) {
                UserWarehouse::firstOrCreate([
                    'user_id' => $user,
                    'warehouse_id' => $warehouse->id,
                ]);
            }
        }

        toastr()->success('', 'Warehouse updated successfully');

        return redirect()->route('warehouses');
    }
}
