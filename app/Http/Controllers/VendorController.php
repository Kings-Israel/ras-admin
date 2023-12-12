<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $businesses = Business::with('user')->withCount('orders', 'products')->get();

        return view('businesses.index', [
            'page' => 'Vendors',
            'breadcrumbs' => [
                'Vendors' => route('vendors.index'),
            ],
            'businesses' => $businesses
        ]);
    }

    public function show(Business $business)
    {
        $business->load('orders.orderItems', 'products', 'user')->loadCount('orders', 'products');

        return view('businesses.show', [
            'page' => $business->name,
            'breadcrumbs' => [
                'Vendors' => route('vendors.index'),
                'Vendor Details' => route('vendors.show', ['business' => $business]),
            ],
            'business' => $business
        ]);
    }

    public function update(Request $request, Business $business)
    {
        $request->validate([
            'approval_status' => ['required', 'in:approved,rejected']
        ]);

        $business->update([
            'approval_status' => $request->approval_status,
            'rejected_approval_reason' => $request->has('rejected_reason') ? $request->rejected_reason : NULL,
        ]);

        toastr()->success('', 'Vendor updated successfully');

        return back();
    }

    public function verify(Business $business)
    {
        $business->update([
            'verified_on' => now()
        ]);

        toastr()->success('', 'Business verified');

        return back();
    }
}
