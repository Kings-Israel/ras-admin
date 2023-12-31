<?php

namespace App\Http\Controllers;

use App\Models\InspectionReport;
use App\Models\InspectionRequest;
use App\Models\OrderConversation;
use Illuminate\Http\Request;
use Chat;

class InspectionRequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $inspection_requests = InspectionRequest::with('orderItem.product.business', 'orderItem.order', 'inspectingInstitution')->get();
        } else {
            if (auth()->user()->hasPermissionTo('view inspection report') && count(auth()->user()->inspectors) <= 0) {
                $inspection_requests = InspectionRequest::with('orderItem.product.business', 'orderItem.order', 'inspectingInstitution')->get();
            } else {
                $user_inspecting_institutions_ids = auth()->user()->inspectors->pluck('id');
                $inspection_requests = InspectionRequest::with('orderItem.product.business', 'orderItem.order')->whereIn('inspector_id', $user_inspecting_institutions_ids)->get();
            }
        }

        return view('inspectors.requests.index', [
            'page' => 'Inspection Requests',
            'breadcrumbs' => [
                'Inspection Requests' => route('inspection.requests.index')
            ],
            'inspection_requests' => $inspection_requests
        ]);
    }

    public function reports()
    {
        if (auth()->user()->hasRole('admin')) {
            $inspection_reports = InspectionReport::with('orderItem.product')->get();
        } else {
            if (auth()->user()->hasPermissionTo('view inspection report') && count(auth()->user()->inspectors) <= 0) {
                $inspection_reports = InspectionReport::with('orderItem.product')->get();
            } else {
                $user_inspecting_institutions_ids = auth()->user()->inspectors->pluck('id');
                $inspection_reports = InspectionReport::with('orderItem.product')->whereIn('inspector_id', $user_inspecting_institutions_ids)->get();
            }
        }

        return view('inspectors.reports.index', [
            'page' => 'Inspection Reports',
            'breadcrumbs' => [
                'Inspection Reports' => route('inspection.reports.index')
            ],
            'inspection_reports' => $inspection_reports
        ]);
    }

    public function show(InspectionRequest $inspection_request)
    {
        $inspection_request->load('orderItem.product.business', 'orderItem.product.media', 'orderItem.order.business', 'orderItem.order.user');

        $inspector = $inspection_request->inspectingInstitution;
        $user = $inspection_request->orderItem->order->user;

        $conversation = Chat::conversations()->between($user, $inspector);

        if (!$conversation) {
            $participants = [$user, $inspector];
            $conversation = Chat::createConversation($participants);
            $conversation->update([
                'direct_message' => true,
            ]);
        }

        OrderConversation::firstOrCreate([
            'order_id' => $inspection_request->orderItem->order->id,
            'conversation_id' => $conversation->id,
        ]);

        return view('inspectors.requests.show', [
            'page' => 'Inspection Request',
            'breadcrumbs' => [
                'Inspection Requests' => route('inspection.requests.index'),
                'Inpection Request Details' => route('inspection.requests.show', ['inspection_request' => $inspection_request])
            ],
            'inspection_request' => $inspection_request,
            'conversation_id' => $conversation->id,
        ]);
    }

    public function store(Request $request, InspectionRequest $inspection_request)
    {
        foreach ($request->order_item_report as $key => $report) {
            InspectionReport::updateOrCreate(
                    ['order_item_id' => $key],
                    [
                        'inspector_id' => $inspection_request->inspector_id,
                        'user_id' => auth()->id(),
                        'report_file' => pathinfo($report->store('inspection', 'reports'), PATHINFO_BASENAME)
                    ]
                );
        }

        $inspection_request->update([
            'status' => 'accepted'
        ]);

        if ($request->has('inspection_cost')) {
            $inspection_request->update([
                'cost' => $request->inspection_cost
            ]);
        }

        toastr()->success('', 'Inspection report uploaded successfully');

        return back();
    }

    public function updateCost(Request $request, InspectionRequest $inspection_request)
    {
        $request->validate([
            'inspection_cost' => ['required', 'integer'],
            'cost_description' => ['nullable', 'string'],
            'cost_description_file' => ['nullable', 'mimes:pdf']
        ]);

        $inspection_request->update([
            'cost' => $request->inspection_cost,
            'cost_description' => $request->cost_description,
        ]);

        if ($request->hasFile('cost_description_file')) {
            $inspection_request->update([
                'cost_description_file' => pathinfo($request->cost_description_file->store('inspection', 'requests'), PATHINFO_BASENAME)
            ]);
        }

        toastr()->success('', 'Inspection request updated successfully');

        return back();
    }
}
