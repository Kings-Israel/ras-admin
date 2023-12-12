<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReleaseProductRequest;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $orders = Order::with('business.country', 'business.city', 'user', 'orderItems', 'warehouse')->get();
        } else {
            // Warehouse Manager
            $user_warehouses = auth()->user()->warehouses->pluck('id');

            $orders = Order::with('business.country', 'business.city', 'user', 'orderItems')
                            ->whereHas('warehouse', function ($query) use ($user_warehouses) {
                                $query->whereIn('warehouse_id', $user_warehouses);
                            })
                            ->get();
        }

        return view('orders.index', [
            'page' => 'Orders',
            'breadcrumbs' => [
                'Orders' => route('orders.index'),
            ],
            'orders' => $orders
        ]);
    }

    public function show(Order $order)
    {
        $order->load('business.country', 'business.city', 'user', 'orderItems.productReleaseRequest', 'invoice.financingRequest', 'warehouse');

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

        $drivers = User::with('roles', 'permissions')->whereHas('driverProfile')->get()->filter(function ($user) use ($driver_permissions) {
            $user_permission_names = $user->getAllPermissions()->pluck('name');
            return collect($driver_permissions)->diff(collect($user_permission_names))->isEmpty() ? true : false;
        });

        return view('orders.show', [
            'page' => $order->order_id,
            'breadcrumbs' => [
                'Orders' => route('orders.index'),
                'Order Details' => route('orders.show', ['order' => $order])
            ],
            'order' => $order,
            'drivers' => $drivers,
        ]);
    }

    public function releaseProduct(Request $request, ReleaseProductRequest $release_product_request)
    {
        $request->validate([
            'order_id' => ['required'],
            'driver_id' => ['required']
        ]);

        $order = Order::find($request->order_id)
                    ->update([
                        'driver_id' => $request->driver_id
                    ]);

        $release_product_request->update([
            'status' => 'complete'
        ]);

        toastr()->success('', 'Order release updated successfully');

        return back();
    }
}
