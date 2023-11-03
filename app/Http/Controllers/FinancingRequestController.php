<?php

namespace App\Http\Controllers;

use App\Models\FinancingRequest;
use Illuminate\Http\Request;

class FinancingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $financing_requests = FinancingRequest::with('invoice.orders.orderItems', )->get();

        return view('financiers.requests.index', [
            'page' => 'Financing Requests',
            'breadcrumbs' => [
                'Financing Requests' => route('financing.requests.index')
            ],
            'financing_requests' => $financing_requests
        ]);
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
}
