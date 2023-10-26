<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
            'view product',
            'view warehouse',
            'update warehouse',
            'view order',
            'create delivery',
            'view delivery',
            'update delivery',
            'delete delivery',
            'view stocklift request',
            'update stocklift request',
        ];

        $users = User::with('permissions')->get()->filter(function ($user) use ($warehouse_permissions) {
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

        $users = User::with('permissions')->get()->filter(function ($user) use ($financier_permissions) {
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
            'view product',
            'view warehouse',
            'view order',
            'update order',
            'create inspection report',
            'view inspection report',
            'update inspection report',
            'delete inspection report',
            'view delivery',
            'update delivery',
        ];

        $users = User::with('permissions')->get()->filter(function ($user) use ($inspector_permissions) {
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
            'view product',
            'view warehouse',
            'view order',
            'update order',
        ];

        $users = User::with('permissions')->get()->filter(function ($user) use ($driver_permissions) {
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
}
