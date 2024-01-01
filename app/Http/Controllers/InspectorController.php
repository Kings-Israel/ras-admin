<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\CompanyDocument;
use App\Models\Country;
use App\Models\InspectingInstitution;
use App\Models\InspectionReport;
use App\Models\InspectorUser;
use App\Models\Order;
use App\Models\OrderConversation;
use App\Models\OrderRequest;
use App\Models\ServiceCharge;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Chat;
use Illuminate\Http\UploadedFile;

class InspectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view inspector', ['only' => ['index', 'show']]);
        $this->middleware('can:create inspector', ['only' => ['create', 'store']]);
        $this->middleware('can:update inspector', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete inspector', ['only' => ['destroy']]);
        $this->middleware('can:create inspection report', ['only' => ['createReport', 'updateReport']]);
    }


    public function index()
    {
        $inspectors = InspectingInstitution::withCount('users', 'orderRequests')->get();

        return view('inspectors.index', [
            'page' => 'Inspectors',
            'breadcrumbs' => [
                'Inspectors' => route('inspectors.index')
            ],
            'inspectors' => $inspectors
        ]);
    }

    public function create()
    {
        $countries = Country::with('cities')->orderBy('name', 'ASC')->get();
        $users = User::where('email', '!=', 'admin@ras.com')->get();

        return view('inspectors.create', [
            'page' => 'Inspectors',
            'breadcrumbs' => [
                'Add Inspector' => route('inspectors.create')
            ],
            'countries' => $countries,
            'users' => $users,
            'documents_count' => 1
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required_without:users'],
            'last_name' => ['required_without:users'],
            'email' => ['required_without:users'],
            'phone_number' => ['required_without:users'],
            'name' => ['required'],
            'inspector_email' => ['required'],
            'inspector_phone_number' => ['required'],
            'users' => ['required_without:first_name', 'required_without:last_name', 'required_without:email', 'required_without:phone_number', 'array'],
        ], [
            'first_name.required_without' => 'Enter admin\'s first name',
            'last_name.required_without' => 'Enter admin\'s last name',
            'email.required_without' => 'Enter admin\'s email',
            'phone_number.required_without' => 'Enter admin\'s phone number'
        ]);

        $inspector = InspectingInstitution::create([
            'name' => $request->name,
            'email' => $request->inspector_email,
            'phone_number' => $request->inspector_phone_number,
            'country_id' => $request->has('country_id') ? $request->country_id : NULL,
        ]);

        if ($request->has('document_name') && count($request->document_name) > 0) {
            foreach ($request->document_name as $key => $doc) {
                if ($request->document_file[$key] instanceof UploadedFile) {
                    CompanyDocument::create([
                        'document_name' => $doc,
                        'file_url' => pathinfo($request->document_file[$key]->store('documents', 'company'), PATHINFO_BASENAME),
                        'documenteable_id' => $inspector->id,
                        'documenteable_type' => InspectingInstitution::class,
                    ]);
                }
            }
        }

        if ($request->has('service_charge_rate')) {
            ServiceCharge::create([
                'value' => $request->service_charge_rate,
                'type' => $request->service_charge_type,
                'chargeable_id' => $inspector->id,
                'chargeable_type' => InspectingInstitution::class,
            ]);
        }

        if ($request->has('wallet_account_number')) {
            Wallet::create([
                'account_number' => $request->wallet_account_number,
                'walleteable_id' => $inspector->id,
                'walleteable_type' => InspectingInstitution::class,
            ]);
        }

        if ($request->has('users') && $request->users != NULL) {
            foreach ($request->users as $user) {
                $user_details = User::find($user);

                InspectorUser::firstOrCreate([
                    'inspector_id' => $inspector->id,
                    'user_id' => $user,
                ]);

                $user_details->givePermissionTo('create inspection report');
                $user_details->givePermissionTo('view inspection report');
                $user_details->givePermissionTo('update inspection report');
                $user_details->givePermissionTo('delete inspection report');
            }
        }

        if ($request->has('first_name') && $request->has('last_name') && $request->has('email') && $request->has('phone_number')
                && $request->first_name != NULL && $request->last_name != NULL && $request->email != NULL && $request->phone_number != NULL
            ) {
            $user = User::where('email', $request->email)->orWhere('phone_number', $request->phone_number)->first();
            if (!$user) {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'password' => Helpers::generatePassword()
                ]);

                // Email credetails to the user
                Password::sendResetLink($request->only('email'));
            }

            InspectorUser::firstOrCreate([
                'user_id' => $user->id,
                'inspector_id' => $inspector->id,
            ]);

            $user->givePermissionTo('create inspection report');
            $user->givePermissionTo('view inspection report');
            $user->givePermissionTo('update inspection report');
            $user->givePermissionTo('delete inspection report');
        }

        toastr()->success('', 'Inspector added successfully');

        return redirect()->route('inspectors.index');
    }

    public function show(InspectingInstitution $inspector)
    {
        //
    }

    public function edit(InspectingInstitution $inspector)
    {
        //
    }

    public function update(Request $request, InspectingInstitution $inspector)
    {
        //
    }

    public function destroy(InspectingInstitution $inspector)
    {
        //
    }

    public function orders()
    {
        // $orders = OrderStorageRequest::with('orderItem.order.business', 'orderItem.product.media')->where('warehouse_id', $warehouse->id)->get();
        // $orders = OrderRequest::with('orderItem.order.business', 'orderItem.product.media')->where('requesteable_type', InspectingInstitution::class)->get();

        $orders = OrderRequest::with('orderItem.product', 'orderItem.order.business')->where('status', 'pending')->where('requesteable_type', InspectingInstitution::class)->get();
        // if (auth()->user()->hasRole('admin')) {
        // } else {
        //     if (auth()->user()->hasPermissionTo('view inspection report') && count(auth()->user()->inspectors) <= 0) {
        //         $orders = OrderRequest::with('orderItem.product.business', 'orderItem.order')->where('requesteable_type', InspectingInstitution::class)->get();
        //     } else {
        //         $user_inspecting_institutions_ids = auth()->user()->inspectors->pluck('id');
        //         $orders = OrderRequest::with('orderItem.product.business', 'orderItem.order')->whereIn('requesteable_id', $user_inspecting_institutions_ids)->where('requesteable_type', InspectingInstitution::class)->get();
        //     }
        // }

        return view('inspectors.requests.index', [
            'page' => 'Inspection Requests',
            'breadcrumbs' => [
                'Inspection Requests' => route('inspection.requests.index')
            ],
            'orders' => $orders
        ]);
    }

    public function order(OrderRequest $order_request)
    {
        $order_request->load('orderItem.product.business', 'orderItem.product.media', 'orderItem.order.business', 'orderItem.order.user');

        $inspector = $order_request->requesteable;
        $user = $order_request->orderItem->order->user;

        $conversation = Chat::conversations()->between($user, $inspector);

        if (!$conversation) {
            $participants = [$user, $inspector];
            $conversation = Chat::createConversation($participants);
            $conversation->update([
                'direct_message' => true,
            ]);
        }

        OrderConversation::firstOrCreate([
            'order_id' => $order_request->orderItem->order->id,
            'conversation_id' => $conversation->id,
        ]);

        return view('inspectors.requests.show', [
            'page' => 'Inspection Request',
            'breadcrumbs' => [
                'Inspection Requests' => route('inspection.requests.index', ['warehouse' => $order_request->requesteable]),
                'Inspection Request Details' => route('inspection.requests.show', ['order_request' => $order_request])
            ],
            'order_request' => $order_request,
            'conversation_id' => $conversation->id,
        ]);
    }

    public function pendingReports()
    {
        if (auth()->user()->hasRole('admin')) {
            $order_requests = OrderRequest::with('orderItem.order.invoice', 'orderItem.product')
                                            ->where('status', 'accepted')
                                            ->whereHas('orderItem', function ($query) {
                                                $query->whereDoesntHave('inspectionReport');
                                            })
                                            ->where('requesteable_type', InspectingInstitution::class)
                                            ->get();

        } else {
            $user_inspecting_institutions_ids = auth()->user()->inspectors->pluck('id');
            $order_requests = OrderRequest::with('orderItem.order.invoice', 'orderItem.product')
                                            ->where('status', 'accepted')
                                            ->whereHas('orderItem', function ($query) {
                                                $query->whereDoesntHave('inspectionReport');
                                            })
                                            ->whereIn('requesteable_id', $user_inspecting_institutions_ids)
                                            ->where('requesteable_type', InspectingInstitution::class)
                                            ->get();
        }

        return view('inspectors.reports.pending', [
            'page' => 'Pending Inspection Reports',
            'breadcrumbs' => [
                'Pending Inspection Reports' => route('inspection.requests.reports.pending')
            ],
            'order_requests' => $order_requests
        ]);
    }

    public function completedReports()
    {
        if (auth()->user()->hasRole('admin')) {
            $order_requests = OrderRequest::with('orderItem.order.invoice', 'orderItem.product', 'orderItem.inspectionReport')
                                        ->where('status', 'accepted')
                                        ->whereHas('orderItem', function ($query) {
                                            $query->whereHas('inspectionReport');
                                        })
                                        ->where('requesteable_type', InspectingInstitution::class)
                                        ->get();
        } else {
            $user_inspecting_institutions_ids = auth()->user()->inspectors->pluck('id');
            $order_requests = OrderRequest::with('orderItem.order.invoice', 'orderItem.product', 'orderItem.inspectionReport')
                                            ->where('status', 'accepted')
                                            ->whereHas('orderItem', function ($query) {
                                                $query->whereHas('inspectionReport');
                                            })
                                            ->whereIn('requesteable_id', $user_inspecting_institutions_ids)
                                            ->where('requesteable_type', InspectingInstitution::class)
                                            ->get();
        }

        $inspection_reports = InspectionReport::with('orderItem.order', 'orderItem.product', 'user', 'inspectingInstitution')
                                                ->get();

        return view('inspectors.reports.completed', [
            'page' => 'Complete Inspection Reports',
            'breadcrumbs' => [
                'Completed Inspection Reports' => route('inspection.requests.reports.completed')
            ],
            // 'order_requests' => $order_requests,
            'inspection_reports' => $inspection_reports,
        ]);
    }

    public function createReport(OrderRequest $order_request)
    {
        return view('inspectors.reports.create', [
            'page' => 'Add Inspection Report',
            'breadcrumbs' => [
                'Pending Inspection Reports' => route('inspection.requests.reports.pending'),
                'Add Inspection Reports' => route('inspection.requests.reports.create', ['order_request' => $order_request]),
            ],
            'order_request' => $order_request->load('orderItem.product', 'requesteable')
        ]);
    }

    public function storeReport(Request $request, OrderRequest $order_request)
    {
        $request->merge([
            'order_item_id' => $order_request->orderItem->id,
            'inspector_id' => $order_request->requesteable_id,
            'user_id' => auth()->id(),
            'applicant_signature' => $request->hasFile('applicant_sign') ? pathinfo($request->applicant_sign->store('signature', 'reports'), PATHINFO_BASENAME) : NULL,
            'report_file' => pathinfo($request->report->store('inspections', 'reports'), PATHINFO_BASENAME),
        ]);

        InspectionReport::create(collect($request->all())->except('applicant_sign', 'report')->toArray());

        $order = Order::find($order_request->orderItem->order_id);
        $order->update([
            'delivery_status' => 'inspection'
        ]);

        toastr()->success('', 'Report added successfully');

        return redirect()->route('inspection.requests.reports.pending');
    }
}
