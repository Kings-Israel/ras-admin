<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Country;
use App\Models\OrderConversation;
use App\Models\OrderStorageRequest;
use App\Models\StorageRequest;
use App\Models\StoreRequest;
use App\Models\User;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use App\Models\WarehouseOrder;
use App\Models\OrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Chat;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view warehouse', ['only' => ['index', 'show']]);
        $this->middleware('can:create warehouse', ['only' => ['create', 'store']]);
        $this->middleware('can:update warehouse', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete warehouse', ['only' => ['destroy']]);
    }

    public function index()
    {
        if (auth()->user()->hasRole('warehouse manager')) {
            $user_warehouses = UserWarehouse::where('user_id', auth()->id())->get()->pluck('warehouse_id');
            $warehouses = Warehouse::withCount('products')->whereIn('id', $user_warehouses)->get();
        }

        if (auth()->user()->hasRole('admin')) {
            $warehouses = Warehouse::withCount('users', 'products')->with('country', 'city')->get();
        }

        return view('warehouses.index', [
            'page' => 'Warehouses',
            'breadcrumbs' => [
                'Warehouses' => route('warehouses.index')
            ],
            'warehouses' => $warehouses
        ]);
    }

    public function create()
    {
        $countries = Country::with('cities')->orderBy('name', 'ASC')->get();

        $users = User::where('email', '!=', 'admin@ras.com')->get();

        return view('warehouses.create', [
            'page' => 'Add Warehouse',
            'breadcrumbs' => [
                'Warehouses' => route('warehouses.index'),
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
            'price' => ['integer'],
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
            'price' => $request->has('price') ? $request->price : NULL,
            'occuppied_capacity' => 0,
        ]);

        if ($request->has('users') && $request->users != NULL) {
            foreach ($request->users as $user) {
                $user_details = User::find($user);

                UserWarehouse::firstOrCreate([
                    'warehouse_id' => $warehouse->id,
                    'user_id' => $user,
                ]);

                $user_details->givePermissionTo('view warehouse');
                $user_details->givePermissionTo('update warehouse');
            }
        }

        if ($request->has('first_name') && $request->has('last_name') && $request->has('email') && $request->has('phone_number')
                && $request->first_name != NULL && $request->last_name != NULL && $request->email != NULL && $request->phone_number != NULL
            ) {
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

            UserWarehouse::create([
                'user_id' => $user->id,
                'warehouse_id' => $warehouse->id,
            ]);

            $user_details->givePermissionTo('view warehouse');
            $user_details->givePermissionTo('update warehouse');
        }

        toastr()->success('', 'Warehouse added successfully');

        return redirect()->route('warehouses.index');
    }

    public function edit(Warehouse $warehouse)
    {
        $users = User::where('email', '!=', 'admin@ras.com')->get();
        return view('warehouses.edit', [
            'page' => 'Edit Warehouse',
            'breadcrumbs' => [
                'Warehouses' => route('warehouses.index'),
                'Edit '.$warehouse->name => route('warehouses.edit', ['warehouse' => $warehouse])
            ],
            'warehouse' => $warehouse->load('users'),
            'users' => $users
        ]);
    }

    public function show(Warehouse $warehouse)
    {
        return view('warehouses.show', [
            'page' => 'View Warehouse',
            'breadcrumbs' => [
                'Warehouses' => route('warehouses.index'),
                'View '.$warehouse->name => route('warehouses.show', ['warehouse' => $warehouse])
            ],
            'warehouse' => $warehouse->load('users'),
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
            'max_capacity' => ['nullable', 'integer'],
            'price' => ['nullable', 'integer'],
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
            'max_capacity' => $request->has('max_capacity') ? $request->max_capacity : $warehouse->max_capacity,
            'price' => $request->has('price') ? $request->price : $warehouse->price,
        ]);

        if ($request->has('users') && $request->users != NULL) {
            foreach ($request->users as $user) {
                $user_details = User::find($user);

                UserWarehouse::firstOrCreate([
                    'warehouse_id' => $warehouse->id,
                    'user_id' => $user,
                ]);

                $user_details->givePermissionTo('view warehouse');
                $user_details->givePermissionTo('update warehouse');
            }
        }

        if ($request->has('first_name') && $request->has('last_name') && $request->has('email') && $request->has('phone_number')
                && $request->first_name != NULL && $request->last_name != NULL && $request->email != NULL && $request->phone_number != NULL
            ) {
            $user = User::where('email', $request->email)->orWhere('phone_number', $request->phone_number)->first();
            if (!$user) {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'password' => Helpers::generatePassword()
                ]);

                // Email credetails to the user
                Password::sendResetLink($request->only('email'));
            }

            UserWarehouse::firstOrCreate([
                'user_id' => $user->id,
                'warehouse_id' => $warehouse->id,
            ]);

            $user->givePermissionTo('view warehouse');
            $user->givePermissionTo('update warehouse');
        }

        toastr()->success('', 'Warehouse updated successfully');

        return redirect()->route('warehouses.index');
    }

    public function orders(Warehouse $warehouse)
    {
        $orders = OrderRequest::with('orderItem.order.business', 'orderItem.product.media')->where('requesteable_id', $warehouse->id)->where('requesteable_type', Warehouse::class)->get();

        return view('warehouses.orders.index', [
            'page' => 'Warehouse Order Storage Request',
            'breadcrumbs' => [
                'Warehouses' => route('warehouses.index'),
                'Warehouse Orders' => route('warehouses.orders.requests.index', ['warehouse' => $warehouse])
            ],
            'orders' => $orders
        ]);
    }

    public function order(OrderRequest $order_request)
    {
        $order_request->load('orderItem.product.business', 'orderItem.product.media', 'orderItem.order.business', 'orderItem.order.user');

        $warehouse = $order_request->requesteable;
        $user = $order_request->orderItem->order->user;

        $conversation = Chat::conversations()->between($user, $warehouse);

        if (!$conversation) {
            $participants = [$user, $warehouse];
            $conversation = Chat::createConversation($participants);
            $conversation->update([
                'direct_message' => true,
            ]);
        }

        OrderConversation::firstOrCreate([
            'order_id' => $order_request->orderItem->order->id,
            'conversation_id' => $conversation->id,
        ]);

        return view('warehouses.orders.show', [
            'page' => 'Storage Request',
            'breadcrumbs' => [
                'Storage Requests' => route('warehouses.orders.requests.index', ['warehouse' => $order_request->requesteable]),
                'Storage Request Details' => route('warehouses.orders.requests.details', ['order_request' => $order_request])
            ],
            'order_request' => $order_request,
            'conversation_id' => $conversation->id,
        ]);
    }

    // public function storageRequest(WarehouseOrder $warehouse_order)
    // {
    //     $warehouse_order->load('orderItem.product.media');

    //     return view('warehouses.orders.show', [
    //         'page' => 'Order Storage Request',
    //         'breadcrumbs' => [
    //             'Warehouses' => route('warehouses.index'),
    //             'Order Storage Requests' => route('warehouses.orders.index', ['warehouse' => $warehouse_order->warehouse]),
    //             'Storage Request' => route('warehouses.orders.request.details', ['warehouse_order' => $warehouse_order])
    //         ],
    //         'warehouse_storage_request' => $warehouse_order
    //     ]);
    // }
}
