<?php

namespace App\Http\Controllers;

use App\Models\StorageRequest;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StorageRequestController extends Controller
{
    public function index(Warehouse $warehouse)
    {
        $users = User::whereHas('roles', fn ($query) => $query->where('name', 'warehouse manager'))->get();
        $requests = StorageRequest::with('customer')->where('warehouse_id', $warehouse->id)->get();
        return view('warehouses.requests.index', [
            'page' => 'Requests Warehouse',
            'breadcrumbs' => [
                'Warehouses' => route('warehouses.index'),
                Str::title($warehouse->name).' Storage Requests' => route('warehouses.storage.requests', ['warehouse' => $warehouse])
            ],
            'warehouse' => $warehouse->load('users'),
            'users' => $users,
            'requests' => $requests,
        ]);
    }
}
