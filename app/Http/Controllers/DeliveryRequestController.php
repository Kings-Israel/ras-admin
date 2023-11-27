<?php

namespace App\Http\Controllers;

use App\Models\OrderConversation;
use App\Models\OrderDeliveryRequest;
use Illuminate\Http\Request;
use Chat;

class DeliveryRequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $delivery_requests = OrderDeliveryRequest::with('orderItem.order', 'orderItem.product.media', 'user', 'logisticsCompany')->get();
        } else {
            if ((auth()->user()->hasPermissionTo('view delivery') || auth()->user()->hasPermissionTo('update delivery')) && count(auth()->user()->logisticsCompanies) <= 0) {
                $delivery_requests = OrderDeliveryRequest::with('orderItem.order', 'orderItem.product.media', 'user', 'logisticsCompany')->get();
            } else {
                $user_inspecting_institutions_ids = auth()->user()->logisticsCompanies->pluck('id');
                $delivery_requests = OrderDeliveryRequest::with('orderItem.order', 'orderItem.product.media', 'user')->whereIn('inspector_id', $user_inspecting_institutions_ids)->get();
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

    public function show(OrderDeliveryRequest $delivery_request)
    {
        $delivery_request->load('orderItem.product.business', 'orderItem.product.media', 'orderItem.order.business', 'orderItem.order.user');

        $logistics_company = $delivery_request->logisticsCompany;
        $user = $delivery_request->orderItem->order->user;

        $conversation = Chat::conversations()->between($user, $logistics_company);

        if (!$conversation) {
            $participants = [$user, $logistics_company];
            $conversation = Chat::createConversation($participants);
            $conversation->update([
                'direct_message' => true,
            ]);
        }

        OrderConversation::firstOrCreate([
            'order_id' => $delivery_request->orderItem->order->id,
            'conversation_id' => $conversation->id,
        ]);

        return view('logistics.deliveries.show', [
            'page' => 'Delivery Request',
            'breadcrumbs' => [
                'Delivery Requests' => route('deliveries.index'),
                'Inpection Request Details' => route('deliveries.show', ['delivery_request' => $delivery_request])
            ],
            'delivery_request' => $delivery_request,
            'conversation_id' => $conversation->id,
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
