<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use App\Models\WarehouseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if (Auth::check() && Auth::user()->hasRole('warehouse manager')){
            $userwarehouse=UserWarehouse::where('user_id',$user->id)->first();
            $warehouse = Warehouse::where('id',$userwarehouse->warehouse_id)->first();
            if ($warehouse) {
                $warehouse = $warehouse->first();
                $warehouse_orders=WarehouseOrder::where('warehouse_id', $warehouse->id)->select('order_id')->get();
                if ($warehouse_orders){
                    $orders=Order::whereIn('id',$warehouse_orders)->select('invoice_id')->get();
                    if ($orders){
                       $invoice=Invoice::whereIn('id',$orders)->get();
                        return view('payment.index', [
                            'page' => 'Payments',
                            'breadcrumbs' => [
                                'Payments' => route('payments.index')
                            ],
                            'invoices' => $invoice
                        ]);
                    }
                }
            }
            return view('payment.index', [
                'page' => 'Payments',
                'breadcrumbs' => [
                    'Payments' => route('payments.index')
                ],
                'invoices' => []
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        return view('payment.index', [
            'page' => 'Payments',
            'breadcrumbs' => [
                'Payments' => route('payments.index')
            ],
            'invoices' => []
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
