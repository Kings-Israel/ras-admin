<?php

namespace App\Http\Controllers;

use App\Models\OrderDeliveryRequest;
use Illuminate\Http\Request;

class DeliveryRequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $delivery_requests = OrderDeliveryRequest::with('order.orderItems', 'user', 'logisticsCompany')->get();
        } else {
            if ((auth()->user()->hasPermissionTo('view delivery') || auth()->user()->hasPermissionTo('update delivery')) && count(auth()->user()->logisticsCompanies) <= 0) {
                $delivery_requests = OrderDeliveryRequest::with('order.orderItems', 'user', 'logisticsCompany')->get();
            } else {
                $user_inspecting_institutions_ids = auth()->user()->logisticsCompanies->pluck('id');
                $delivery_requests = OrderDeliveryRequest::with('order.orderItems', 'user')->whereIn('inspector_id', $user_inspecting_institutions_ids)->get();
            }
        }

        return view('logistics.deliveries.index', [
            'page' => 'Deliveries',
            'breadcrumbs' => [
                'Deliveries' => route('deliveries.index')
            ],
            'requests' => $delivery_requests
        ]);
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
        //
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
