<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Helpers\Jambopay;
use App\Models\City;
use App\Models\Country;
use App\Models\LogisticsCompany;
use App\Models\LogisticsCompanyUser;
use App\Models\OrderConversation;
use App\Models\OrderRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Models\CompanyDocument;
use App\Models\ServiceCharge;
use App\Notifications\RoleUpdate;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Chat;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view stocklift request', ['only' => ['index', 'show']]);
        $this->middleware('can:create stocklift request', ['only' => ['create', 'store']]);
        $this->middleware('can:update stocklift request', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete stocklift request', ['only' => ['destroy']]);
    }

    public function index()
    {
        $logistics_companies = LogisticsCompany::withCount('users')->get();

        return view('logistics.index', [
            'page' => 'Logistics Companies',
            'breadcrumbs' => [
                'Logistics Companies' => route('logistics.index')
            ],
            'logistics_companies' => $logistics_companies
        ]);
    }

    public function create()
    {
        $countries = Country::with('cities')->orderBy('name', 'ASC')->get();
        $users = User::where('email', '!=', 'admin@ras.com')->get();
        $transportation_methods = ['Air', 'Road', 'Water', 'Rail'];

        return view('logistics.create', [
            'page' => 'Logistics Company',
            'breadcrumbs' => [
                'Logistics Companies' => route('logistics.index'),
                'Add Logistics Company' => route('logistics.create')
            ],
            'countries' => $countries,
            'users' => $users,
            'transportation_methods' => $transportation_methods,
            'documents_count' => 1,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => ['required'],
            'company_phone_number' => ['required', new PhoneNumber],
            'company_email' => ['required', 'email'],
            'first_name' => ['required_without:users_ids',],
            'last_name' => ['required_without:users_ids'],
            'email' => ['required_without:users_ids', 'nullable', 'email'],
            'phone_number' => ['required_without:users', new PhoneNumber],
            'users_ids' => ['required_without:first_name', 'required_without:last_name', 'required_without:email', 'required_without:phone_number', 'array', 'nullable'],
            'users_ids.*' => ['integer'],
        ]);

        $logistics_company = LogisticsCompany::create([
            'name' => $request->company_name,
            'phone_number' => $request->company_phone_number,
            'email' => $request->company_email,
            'country_id' => $request->has('country_id') ? $request->country_id : NULL,
            'city_id' => $request->has('city_id') ? $request->city_id : NULL,
            'transportation_methods' => $request->has('transportation_methods') ? json_encode($request->transportation_methods) : NULL,
        ]);

        if ($request->has('document_name')) {
            foreach ($request->document_name as $key => $doc) {
                if ($request->document_file[$key] instanceof UploadedFile) {
                    CompanyDocument::create([
                        'document_name' => $doc,
                        'file_url' => pathinfo($request->document_file[$key]->store('documents', 'company'), PATHINFO_BASENAME),
                        'documenteable_id' => $logistics_company->id,
                        'documenteable_type' => LogisticsCompany::class,
                    ]);
                }
            }
        }

        if ($request->has('service_charge')) {
            ServiceCharge::create([
                'value' => $request->service_charge_rate,
                'type' => $request->service_charge_type,
                'chargeable_id' => $logistics_company->id,
                'chargeable_type' => LogisticsCompany::class,
            ]);
        }

        if ($request->has('wallet_account_number')) {
            Wallet::create([
                'account_number' => $request->wallet_account_number,
                'walleteable_id' => $logistics_company->id,
                'walleteable_type' => LogisticsCompany::class,
            ]);
        }

        if ($request->has('users') && $request->users != NULL) {
            foreach ($request->users as $user) {
                $user_details = User::find($user);

                LogisticsCompanyUser::firstOrCreate([
                    'logistics_company_id' => $logistics_company->id,
                    'user_id' => $user,
                ]);

                $user_details->givePermissionTo('update logistics company');
                $user_details->givePermissionTo('create stocklift request');
                $user_details->givePermissionTo('view stocklift request');
                $user_details->givePermissionTo('update stocklift request');
                $user_details->givePermissionTo('delete stocklift request');
            }
        }

        // Create User
        if ($request->has('first_name') && $request->has('last_name') && $request->has('email') && $request->has('phone_number')
                && $request->first_name != NULL && $request->last_name != NULL && $request->email != NULL && $request->phone_number != NULL
            ) {
            $user = User::where('email', $request->email)->orWhere('phone_number', $request->phone_number)->first();
            if (!$user) {
                $user = User::firstOrCreate([
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'password' => Helpers::generatePassword()
                ]);
            }

            LogisticsCompanyUser::firstOrCreate([
                'logistics_company_id' => $logistics_company->id,
                'user_id' => $user->id,
            ]);

            $user->givePermissionTo('create stocklift request');
            $user->givePermissionTo('view stocklift request');
            $user->givePermissionTo('update stocklift request');
            $user->givePermissionTo('update stocklift request');

            $user->notify(new RoleUpdate('Logistics Role added to your account'));

            // Send email to create password and login
            Password::sendResetLink(['email' => $request->email]);
        }

        toastr()->success('', 'Logistics Company has been added successfully');

        return redirect()->route('logistics.index');
    }

    public function edit(LogisticsCompany $logistics_company)
    {
        $countries = Country::with('cities')->get();
        $cities = City::all();
        $users = User::where('email', '!=', 'admin@ras.com')->get();

        return view('logistics.edit', [
            'page' => 'Edit Logistics Company',
            'breadcrumbs' => [
                'Logistics Companies' => route('logistics.index'),
                'Edit Logistics Company' => route('logistics.edit')
            ],
            'countries' => $countries,
            'cities' => $cities,
            'users' => $users,
            'financing_institution' => $logistics_company->load('users')
        ]);
    }

    public function update(Request $request, LogisticsCompany $logistics_company)
    {
        $request->validate([
            'company_name' => ['required'],
            'company_phone_number' => ['required', new PhoneNumber],
            'company_email' => ['required'],
            'first_name' => ['required_without:users_ids',],
            'last_name' => ['required_without:users_ids'],
            'email' => ['required_without:users_ids'],
            'phone_number' => ['required_without:users', new PhoneNumber],
            'users_ids' => ['required_without:first_name', 'required_without:last_name', 'required_without:email', 'required_without:phone_number', 'array', 'nullable'],
            'users_ids.*' => ['integer'],
        ]);

        $logistics_company->udpate([
            'name' => $request->institution_name,
            'phone_number' => $request->institution_phone_number,
            'email' => $request->institution_email,
            'country_id' => $request->has('country_id') ? $request->country_id : NULL,
            'city_id' => $request->has('city_id') ? $request->city_id : NULL,
        ]);

        // Create User
        if ($request->has('users') && $request->users != NULL) {
            foreach ($request->users as $user) {
                $user_details = User::find($user);

                LogisticsCompanyUser::firstOrCreate([
                    'logistics_company_id' => $logistics_company->id,
                    'user_id' => $user,
                ]);

                $user_details->givePermissionTo('update logistics company');
                $user_details->givePermissionTo('create stocklift request');
                $user_details->givePermissionTo('view stocklift request');
                $user_details->givePermissionTo('update stocklift request');
                $user_details->givePermissionTo('delete stocklift request');
            }
        }

        // Create User
        if ($request->has('first_name') && $request->has('last_name') && $request->has('email') && $request->has('phone_number')
                && $request->first_name != NULL && $request->last_name != NULL && $request->email != NULL && $request->phone_number != NULL
            ) {
            $user = User::where('email', $request->email)->orWhere('phone_number', $request->phone_number)->first();
            if (!$user) {
                $user = User::firstOrCreate([
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'password' => Helpers::generatePassword()
                ]);
            }

            LogisticsCompanyUser::firstOrCreate([
                'logistics_company_id' => $logistics_company->id,
                'user_id' => $user->id,
            ]);

            $user->givePermissionTo('create stocklift request');
            $user->givePermissionTo('view stocklift request');
            $user->givePermissionTo('update stocklift request');
            $user->givePermissionTo('update stocklift request');

            $user->notify(new RoleUpdate('Logistics Role added to your account'));

            // Send email to create password and login
            Password::sendResetLink(['email' => $request->email]);
        }

        toastr()->success('', 'Logistics Company updated successfully');

        return redirect()->route('financing-institutions.index');
    }

    public function destroy(LogisticsCompany $logistics_company)
    {
        // TODO: Add check if institution has active transportation requests

        $logistics_company->delete();

        toastr()->success('', 'Logistics Company deleted successfully');

        return redirect()->route('financing-institutions.index');
    }

    public function orders()
    {
        // $orders = OrderStorageRequest::with('orderItem.order.business', 'orderItem.product.media')->where('warehouse_id', $warehouse->id)->get();
        $orders = OrderRequest::with('orderItem.order.business', 'orderItem.product.media')->where('requesteable_type', LogisticsCompany::class)->get();

        if (auth()->user()->hasRole('admin')) {
            $orders = OrderRequest::with('orderItem.product.business', 'orderItem.order')->where('requesteable_type', LogisticsCompany::class)->get();
        } else {
            if (auth()->user()->hasPermissionTo('view inspection report') && count(auth()->user()->inspectors) <= 0) {
                $orders = OrderRequest::with('orderItem.product.business', 'orderItem.order')->where('requesteable_type', LogisticsCompany::class)->get();
            } else {
                $user_inspecting_institutions_ids = auth()->user()->inspectors->pluck('id');
                $orders = OrderRequest::with('orderItem.product.business', 'orderItem.order')->whereIn('requesteable_id', $user_inspecting_institutions_ids)->where('requesteable_type', LogisticsCompany::class)->get();
            }
        }

        return view('logistics.deliveries.requests.index', [
            'page' => 'Delivery Requests',
            'breadcrumbs' => [
                'Delivery Requests' => route('deliveries.requests.index')
            ],
            'orders' => $orders
        ]);
    }

    public function order(OrderRequest $order_request)
    {
        $order_request->load('orderItem.product.business', 'orderItem.product.media', 'orderItem.order.business', 'orderItem.order.user');

        $logistics_company = $order_request->requesteable;
        $user = $order_request->orderItem->order->user;

        $conversation = Chat::conversations()->between($user, $logistics_company);

        if (!$conversation) {
            $participants = [$user, $logistics_company];
            $conversation = Chat::createConversation($participants);
            $conversation->update([
                'direct_message' => true,
            ]);
        }

        OrderConversation::firstOrCreate([
            'order_id' => $order_request->orderItem->order->id,
            'conversation_id' => $conversation->id,
        ]);

        return view('logistics.deliveries.requests.show', [
            'page' => 'Delivery Request',
            'breadcrumbs' => [
                'Delivery Requests' => route('deliveries.requests.index', ['warehouse' => $order_request->requesteable]),
                'Delivery Request Details' => route('deliveries.requests.show', ['order_request' => $order_request])
            ],
            'order_request' => $order_request,
            'conversation_id' => $conversation->id,
        ]);
    }

    public function createExportReport(OrderRequest $order_request)
    {
        $documents = [
            'Commercial Invoices', 'Transport Document', 'Packing Lists', 'Certificate of Origin', 'Import Permit', 'Other'
        ];
        return view('logistics.deliveries.reports.export-report-create', [
            'page' => 'Export Report',
            'breadcrumbs' => [
                'Order Request' => route('deliveries.requests.show', ['order_request' => $order_request]),
            ],
            'order_request' => $order_request,
            'documents' => $documents,
        ]);
    }

    public function storeExportReport(Request $request, OrderRequest $order_request)
    {
        try {
            DB::beginTransaction();

            $export_instruction = $order_request->exportInstruction()->create([
                'order_request_id' => $order_request->id,
                'exporter' => $request->exporter,
                'reference' => $request->reference,
                'vat_number' => $request->vat_number,
                'consignee' => $request->consignee,
                'notify_party' => $request->notify_party,
                'place_of_collection' => $request->place_of_collection,
                'port_of_loading' => $request->port_of_loading,
                'port_of_discharge' => $request->port_of_discharge,
                'final_destination' => $request->final_destination,
                'destination_country' => $request->destination_country,
                'method_of_payment' => $request->method_of_payment,
                'type_of_freight' => $request->type_of_freight,
                'number_of_packages' => $request->number_of_packages,
                'marks_and_numbers' => $request->marks_and_numbers,
                'description_of_goods' => $request->description_of_goods,
                'special_goods' => $request->special_goods,
                'gross_mass' => $request->gross_mass,
                'measurement' => $request->measurement,
                'cargo_insurance' => $request->cargo_insurance,
                'cargo_value' => $request->cargo_value,
                'incoterms' => $request->incoterms,
                'ci_value' => $request->ci_value,
                'customs_export_purpose_code' => $request->customs_export_purpose_code,
                'customs_export_number' => $request->customs_export_number,
                'tarrif_heading' => $request->tarrif_heading,
                'special_instructions' => $request->special_instructions,
                'other' => $request->other,
            ]);

            if (count($request->documents) > 0) {
                $documents = [];
                foreach($request->documents as $key => $doc) {
                    $documents[$key] = pathinfo($doc->store('logistics', 'reports'), PATHINFO_BASENAME);
                }

                $export_instruction->update([
                    'documents_attached' => json_encode($documents),
                ]);
            }

            DB::commit();

            toastr()->success('', 'Report uploaded successfully');

            return redirect()->route('deliveries.requests.show', ['order_request' => $order_request]);
        } catch (\Exception $e){
            info($e);

            DB::rollback();

            return back();
        }
    }

    public function createImportReport(OrderRequest $order_request)
    {
        $documents = [
            'Commercial Invoices', 'Transport Document', 'Packing Lists', 'Certificate of Origin', 'Import Permit', 'Other'
        ];
        return view('logistics.deliveries.reports.import-report-create', [
            'page' => 'import Report',
            'breadcrumbs' => [
                'Order Request' => route('deliveries.requests.show', ['order_request' => $order_request]),
            ],
            'order_request' => $order_request,
            'documents' => $documents,
        ]);
    }

    public function storeImportReport(Request $request, OrderRequest $order_request)
    {
        try {
            DB::beginTransaction();

            $import_instruction = $order_request->importInstruction()->create([
                'order_request_id' => $order_request->id,
                'importer' => $request->importer,
                'reference' => $request->reference,
                'customs_code' => $request->customs_code,
                'vat_number' => $request->vat_number,
                'supplier' => $request->supplier,
                'transport_mode' => $request->transport_mode,
                'name_of_vessel' => $request->name_of_vessel,
                'eta' => Carbon::parse($request->eta)->format('Y-m-d'),
                'transport_document_number' => $request->transport_document_number,
                'transport_document_date' => Carbon::parse($request->transport_document_date)->format('Y-m-d'),
                'shipment_reference_number' => $request->shipment_reference_number,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => Carbon::parse($request->invoice_date)->format('Y-m-d'),
                'port_of_entry' => $request->port_of_entry,
                'customs_purpose_code' => $request->customers_purpose_code,
                'destination_code' => $request->destination_code,
                'tariff_determination' => $request->tariff_determination,
                'customs_valuation_code' => $request->customs_valuation_code,
                'customs_valuation_method' => $request->customs_valuation_method,
                'customs_value_date' => Carbon::parse($request->customs_value_date)->format('Y-m-d'),
                'number_of_packages' => $request->number_of_packages,
                'special_goods' => $request->special_goods,
                'gross_mass' => $request->gross_mass,
                'measurement' => $request->measurement,
                'import_permit_number' => $request->import_permit_number,
                'incoterms' => $request->incoterms,
                'mode_of_transport' => $request->mode_of_transport,
                'delivery_address' => $request->delivery_address,
                'split_delivery_address' => $request->split_delivery_address,
                'special_instructions' => $request->special_instructions,
                'other' => $request->other,
            ]);

            if (count($request->documents) > 0) {
                $documents = [];
                foreach($request->documents as $key => $doc) {
                    $documents[$key] = pathinfo($doc->store('logistics', 'reports'), PATHINFO_BASENAME);
                }

                $import_instruction->update([
                    'documents_attached' => json_encode($documents),
                ]);
            }

            DB::commit();

            toastr()->success('', 'Report uploaded successfully');

            return redirect()->route('deliveries.requests.show', ['order_request' => $order_request]);
        } catch (\Exception $e){
            info($e);

            DB::rollback();

            return back();
        }
    }

    public function pendingReports()
    {
        if (auth()->user()->hasRole('admin')) {
            $order_requests = OrderRequest::with('orderItem.order.invoice', 'orderItem.product')
                                            ->where('status', 'accepted')
                                            ->whereDoesntHave('importInstruction')
                                            ->whereDoesntHave('exportInstruction')
                                            ->where('requesteable_type', LogisticsCompany::class)
                                            ->get();
        } else {
            $user_logisics_company_ids = auth()->user()->logisticsCompanies->pluck('id');
            $order_requests = OrderRequest::with('orderItem.order.invoice', 'orderItem.product')
                                            ->where('status', 'accepted')
                                            ->whereDoesntHave('importInstruction')
                                            ->whereDoesntHave('exportInstruction')
                                            ->whereIn('requesteable_id', $user_logisics_company_ids)
                                            ->where('requesteable_type', LogisticsCompany::class)
                                            ->get();
        }

        return view('logistics.deliveries.reports.pending', [
            'page' => 'Pending Logistics Reports',
            'breadcrumbs' => [
                'Pending Logistics Reports' => route('deliveries.requests.reports.pending')
            ],
            'order_requests' => $order_requests
        ]);
    }

    public function completedReports()
    {
        if (auth()->user()->hasRole('admin')) {
            $order_requests = OrderRequest::with('orderItem.order.invoice', 'orderItem.product')
                                            ->where('status', 'accepted')
                                            ->whereHas('importInstruction')
                                            ->whereHas('exportInstruction')
                                            ->where('requesteable_type', LogisticsCompany::class)
                                            ->get();
        } else {
            $user_logisics_company_ids = auth()->user()->logisticsCompanies->pluck('id');
            $order_requests = OrderRequest::with('orderItem.order.invoice', 'orderItem.product')
                                            ->where('status', 'accepted')
                                            ->whereHas('importInstruction')
                                            ->whereHas('exportInstruction')
                                            ->whereIn('requesteable_id', $user_logisics_company_ids)
                                            ->where('requesteable_type', LogisticsCompany::class)
                                            ->get();
        }

        return view('logistics.deliveries.reports.completed', [
            'page' => 'Completed Logistics Reports',
            'breadcrumbs' => [
                'Completed Logistics Reports' => route('deliveries.requests.reports.pending')
            ],
            'order_requests' => $order_requests
        ]);
    }
}
