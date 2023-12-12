<?php

namespace App\Http\Controllers;

use App\Models\FinancingRequest;
use App\Models\OrderFinancing;
use App\Notifications\FinancingRequestUpdated;
use Illuminate\Http\Request;
use App\Models\FinancingInstitution;

class FinancingRequestController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasRole('admin')) {
            $financing_requests = FinancingRequest::with('invoice.orders.orderItems')->get();
        } else if (auth()->user()->hasPermissionTo('view financing request') && auth()->user()->financingInstitutions->count() <= 0) {
            $financing_requests = FinancingRequest::with('invoice.orders.orderItems')->get();
        } else {
            $user_financing_institutions_ids = auth()->user()->financingInstitutions->pluck('id');
            $financing_requests = FinancingRequest::with('invoice.orders.orderItems')->whereIn('financing_institution_id', $user_financing_institutions_ids)->get();
        }

        return view('financiers.requests.index', [
            'page' => 'Financing Requests',
            'breadcrumbs' => [
                'Financing Requests' => route('financing.requests.index')
            ],
            'financing_requests' => $financing_requests
        ]);
    }

    public function show(FinancingRequest $financing_request)
    {
        $financing_request->load('invoice.orders.orderItems.product.business', 'invoice.user', 'anchorHistory', 'bankDebts', 'operatingDebts', 'bankers', 'capitalStructure', 'companyManagers', 'shareholders', 'company', 'documents');

        return view('financiers.requests.show', [
            'page' => 'Financing Request',
            'breadcrumbs' => [
                'Financing Requests' => route('financing.requests.index'),
                $financing_request->invoice->invoice_id => route('financing.requests.show', ['financing_request' => $financing_request])
            ],
            'financing_request' => $financing_request
        ]);
    }

    public function update(FinancingRequest $financing_request, $status)
    {
        if ($status == 'reject') {
            $financing_request->update([
                'status' => 'rejected',
            ]);

            // Send notification to user
            $financing_request->invoice->user->notify(new FinancingRequestUpdated($financing_request->load('invoice'), 'rejected'));

            toastr()->success('', 'Financing request successfully updated');

            return back();
        }

        $financing = OrderFinancing::where('invoice_id', $financing_request->invoice->id)->first();

        $financing_institution = FinancingInstitution::all();

        // Admin makes all approvals without a checker
        if (auth()->user()->hasRole('admin')) {
            if (!$financing) {
                $financing = OrderFinancing::create([
                    'invoice_id' => $financing_request->invoice->id,
                    'financing_institution_id' => $financing_institution->first()->id,
                    'first_approval_by' => auth()->id(),
                    'first_approval_on' => now(),
                    'second_approval_by' => auth()->id(),
                    'second_approval_on' => now(),
                ]);
            } else {
                $financing->update([
                    'second_approval_by' => auth()->id(),
                    'second_approval_on' => now(),
                ]);
            }

            // TODO: Implement transfer of funds from financier wallet to vendors and service providers.

            $financing_request->invoice->update([
                'payment_status' => 'paid'
            ]);

            $financing_request->invoice->orders->each(fn ($order) => $order->update(['status' => 'in progress']));

            // Send notification to user
            $financing_request->invoice->user->notify(new FinancingRequestUpdated($financing_request->load('invoice'), 'accepted'));

            toastr()->success('', 'Financing request successfully updated');

            return back();
        }

        if (!$financing) {
            $financing = OrderFinancing::create([
                'invoice_id' => $financing_request->invoice->id,
                'financing_institution_id' => $financing_institution->first()->id,
                'first_approval_by' => auth()->id(),
                'first_approval_on' => now(),
            ]);

            toastr()->success('', 'Financing request successfully updated');

            return back();
        } else {
            $financing->update([
                'second_approval_by' => auth()->id(),
                'second_approval_on' => now(),
            ]);

            $financing_request->update([
                'status' => 'accepted'
            ]);

            // TODO: Implement transfer of funds from financier wallet to vendors and service providers.

            $financing_request->invoice->update([
                'payment_status' => 'paid'
            ]);

            $financing_request->invoice->orders->each(fn ($order) => $order->update(['status' => 'in progress']));

            // Send notification to user
            $financing_request->invoice->user->notify(new FinancingRequestUpdated($financing_request->load('invoice'), 'accepted'));

            toastr()->success('', 'Financing request successfully updated');

            return back();
        }
    }
}
