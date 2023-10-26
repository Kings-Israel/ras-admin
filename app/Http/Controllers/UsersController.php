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
        $users = User::withCount('warehouses')
                ->whereHas('permissions', function ($query) {
                    $query->where('name', 'view warehouse')
                            ->orWhere('name', 'update warehouse');
                })
                ->orWhereHas('roles', function ($query) {
                    $query->whereHas('permissions', function ($query) {
                        $query->where('name', 'view warehouse')
                            ->orWhere('name', 'update warehouse');
                    });
                })
                ->get();

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
        $users = User::whereHas('permissions', function ($query) {
                    $query->where('name', 'view financing request')
                            ->orWhere('name', 'update financing request');
                })
                ->orWhereHas('roles', function ($query) {
                    $query->whereHas('permissions', function ($query) {
                        $query->where('name', 'view financing request')
                            ->orWhere('name', 'update financing request');
                    });
                })
                ->get();

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
        $users = User::whereHas('permissions', function ($query) {
                    $query->where('name', 'view inspection report')
                            ->orWhere('name', 'create inspection report')
                            ->orWhere('name', 'create inspection report')
                            ->orWhere('name', 'delete inspection report');
                })
                ->orWhereHas('roles', function ($query) {
                    $query->whereHas('permissions', function ($query) {
                        $query->where('name', 'view inspection report')
                            ->orWhere('name', 'create inspection report')
                            ->orWhere('name', 'create inspection report')
                            ->orWhere('name', 'delete inspection report');
                    });
                })
                ->get();

        return view('users.warehouse-managers', [
            'page' => 'Inspectors',
            'breadcrumbs' => [
                'Inspectors' => route('users.inspectors'),
            ],
            'users' => $users
        ]);
    }
}
