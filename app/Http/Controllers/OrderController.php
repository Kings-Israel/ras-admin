<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('business.country', 'business.city', 'user', 'orderItems')->get();

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
        $order->load('business.country', 'business.city', 'user', 'orderItems', 'invoice.financingRequest');

        return view('orders.show', [
            'page' => $order->order_id,
            'breadcrumbs' => [
                'Orders' => route('orders.index'),
                'Order Details' => route('orders.show', ['order' => $order])
            ],
            'order' => $order
        ]);
    }
}
