<?php

namespace App\Http\Controllers;

use App\Models\DriverProfile;
use App\Models\User;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function buyers()
    {
        $users = User::whereHas('roles', function ($query) {
                        $query->where('name', 'buyer');
                    })->get();
        return view('users.buyers', [
            'page' => 'Customers',
            'breadcrumbs' => [
                'Customers' => route('users.buyers')
            ],
            'users' => $users
        ]);
    }

    public function vendors()
    {
        $users = User::whereHas('roles', function ($query) {
                        $query->where('name', 'vendor');
                    })
                    ->get();

        return view('users.vendors', [
            'page' => 'Vendors',
            'breadcrumbs' => [
                'Vendors' => route('users.vendors'),
            ],
            'users' => $users
        ]);
    }

    public function warehouseManagers()
    {
        $warehouse_permissions = [
            'view warehouse',
            'update warehouse',
        ];

        $users = User::with('roles', 'permissions')->get()->filter(function ($user) use ($warehouse_permissions) {
                    $user_permission_names = $user->getAllPermissions()->pluck('name');
                    return collect($warehouse_permissions)->diff(collect($user_permission_names))->isEmpty() ? true : false;
                });

        return view('users.warehouse-managers', [
            'page' => 'Warehouse Managers',
            'breadcrumbs' => [
                'Warehouse Managers' => route('users.warehousemanagers'),
            ],
            'users' => $users
        ]);
    }

    public function financiers()
    {
        $financier_permissions = [
            'view financing request',
            'update financing request',
        ];

        $users = User::with('roles', 'permissions')->get()->filter(function ($user) use ($financier_permissions) {
                    $user_permission_names = $user->getAllPermissions()->pluck('name');
                    return collect($financier_permissions)->diff(collect($user_permission_names))->isEmpty() ? true : false;
                });

        return view('users.warehouse-managers', [
            'page' => 'Financiers',
            'breadcrumbs' => [
                'Finaciers' => route('users.financiers'),
            ],
            'users' => $users
        ]);
    }

    public function inspectors()
    {
        $inspector_permissions = [
            'create inspection report',
            'view inspection report',
            'update inspection report',
            'delete inspection report',
        ];

        $users = User::with('roles', 'permissions')->get()->filter(function ($user) use ($inspector_permissions) {
            $user_permission_names = $user->getAllPermissions()->pluck('name');
            return collect($inspector_permissions)->diff(collect($user_permission_names))->isEmpty() ? true : false;
        });

        return view('users.warehouse-managers', [
            'page' => 'Inspectors',
            'breadcrumbs' => [
                'Inspectors' => route('users.inspectors'),
            ],
            'users' => $users
        ]);
    }

    public function drivers()
    {
        $driver_permissions = [
            'create delivery',
            'update delivery',
            'view delivery',
            'delete delivery',
            'create stocklift request',
            'view stocklift request',
            'update stocklift request',
            'delete stocklift request',
        ];

        $users = User::with('roles', 'permissions')->get()->filter(function ($user) use ($driver_permissions) {
            $user_permission_names = $user->getAllPermissions()->pluck('name');
            return collect($driver_permissions)->diff(collect($user_permission_names))->isEmpty() ? true : false;
        });

        return view('users.drivers', [
            'page' => 'Drivers',
            'breadcrumbs' => [
                'Drivers' => route('users.drivers'),
            ],
            'users' => $users
        ]);
    }

    public function show(User $user)
    {
        $user->load('roles', 'permissions', 'business.products', 'business.country', 'business.city', 'financingInstitutions', 'inspectors');

        $roles = Role::all();

        return view('users.show', [
            'page' => 'User Details',
            'breadcrumbs' => [
                $user->first_name.' '.$user->last_name => route('users.show', ['user' => $user])
            ],
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function createDriver()
    {
        $warehouses = Warehouse::with('country')->get();

        return view('users.add-driver', [
            'page' => 'Add Drvier',
            'breadcrumbs' => [
                'Drivers' => route('users.drivers')
            ],
            'warehouses' => $warehouses
        ]);
    }

    public function storeDriver(Request $request)
    {
        $request->validate([
            'warehouses' => ['required', 'array'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required'],
            'phone_number' => ['required'],
            'avatar' => ['required'],
            'id_number' => ['required'],
            'vehicle_type' => ['required'],
            'vehicle_registration_number' => ['required'],
            'vehicle_load_capacity' => ['required'],
        ]);

        $password = Str::random(8);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'avatar' => pathinfo($request->avatar->store('avatar', 'user'), PATHINFO_BASENAME),
            'password' => bcrypt($password),
        ]);

        DriverProfile::create([
            'user_id' => $user->id,
            'id_number' => $request->id_number,
            'vehicle_type' => $request->vehicle_type,
            'vehicle_registration_number' => $request->vehicle_registration_number,
            'vehicle_load_capacity' => $request->vehicle_load_capacity,
        ]);

        foreach ($request->warehouses as $warehouse) {
            UserWarehouse::create([
                'user_id' => $user->id,
                'warehouse_id' => $warehouse
            ]);
        }

        $driver_permissions = [
            'create delivery',
            'update delivery',
            'view delivery',
            'delete delivery',
            'create stocklift request',
            'view stocklift request',
            'update stocklift request',
            'delete stocklift request',
        ];

        collect($driver_permissions)->each(function ($driver_permission) use ($user) {
            $user->givePermissionTo($driver_permission);
        });

        // Send email to create password and login
        Password::sendResetLink(['email' => $request->email]);

        toastr()->success('', 'Driver added successfully');

        return redirect()->route('users.drivers');
    }
}
