<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

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
}
