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
        $users = User::whereHas('roles', function ($query) {
                    $query->where('name', 'warehouse manager');
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
        $users = User::whereHas('roles', function ($query) {
                    $query->where('name', 'financier');
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
        $users = User::whereHas('roles', function ($query) {
                    $query->where('name', 'inspector');
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
