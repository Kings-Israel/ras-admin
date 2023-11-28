<?php

namespace App\Http\Controllers;

use App\Models\OrderRequest;
use Illuminate\Http\Request;

class OrderRequestController extends Controller
{
    public function __invoke(Request $request, OrderRequest $order_request)
    {
        $request->validate([
            'cost' => ['required', 'integer'],
            'cost_description' => ['nullable', 'string'],
            'cost_description_file' => ['nullable', 'mimes:pdf'],
        ]);

        $order_request->update([
            'cost' => $request->cost,
            'cost_description' => $request->cost_description ? $request->cost_description : $order_request->cost_description,
        ]);

        if ($request->hasFile('cost_description_file')) {
            $order_request->update([
                'cost_description_file' => pathinfo($request->cost_description_file->store('', 'requests'), PATHINFO_BASENAME)
            ]);
        }

        toastr()->success('', 'Request updated successfully');

        return back();
    }
}
