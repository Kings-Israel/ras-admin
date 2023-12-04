<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\City;
use App\Models\CompanyDocument;
use App\Models\Country;
use App\Models\FinancingInstitution;
use App\Models\FinancingInstitutionUser;
use App\Models\FinancingRequest;
use App\Models\OrderFinancing;
use App\Models\ServiceCharge;
use App\Models\User;
use App\Notifications\RoleUpdate;
use App\Rules\PhoneNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Password;

class FinancingInstitutionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:view financier', ['only' => ['index', 'show']]);
        // $this->middleware('can:create financier', ['only' => ['create', 'store']]);
        // $this->middleware('can:update financier', ['only' => ['edit', 'update']]);
        // $this->middleware('can:delete financier', ['only' => ['destroy']]);
    }

    public function index()
    {
        if(auth()->user()->hasRole('admin')) {
            $financing_institutions = FinancingInstitution::withCount('users')->get();
        } else if (auth()->user()->hasPermissionTo('view financing request') && auth()->user()->financingInstitutions->count() <= 0) {
            $financing_institutions = FinancingInstitution::withCount('users')->get();
        } else {
            $user_financing_institutions_ids = auth()->user()->financingInstitutions->pluck('id');
            $financing_institutions = FinancingInstitution::withCount('users')->whereIn('id', $user_financing_institutions_ids)->get();
        }

        return view('financiers.index', [
            'page' => 'Financing Institutions',
            'breadcrumbs' => [
                'Financing Institutions' => route('financing.institutions.index')
            ],
            'financing_institutions' => $financing_institutions
        ]);
    }

    public function create()
    {
        $countries = Country::with('cities')->orderBy('name', 'ASC')->get();
        $users = User::where('email', '!=', 'admin@ras.com')->get();

        return view('financiers.create', [
            'page' => 'Financing Institutions',
            'breadcrumbs' => [
                'Financing Institutions' => route('financing.institutions.index'),
                'Add Financing Institutions' => route('financing.institutions.create')
            ],
            'countries' => $countries,
            'users' => $users,
            'documents_count' => 1
        ]);
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'institution_name' => ['required'],
            'institution_phone_number' => ['required', new PhoneNumber],
            'institution_email' => ['required'],
            'credit_limit' => ['required', 'integer'],
            'maker_first_name' => ['required_without:maker_user',],
            'maker_last_name' => ['required_without:maker_user'],
            'maker_email' => ['required_without:maker_user', 'nullable', 'different:checker_email'],
            'maker_phone_number' => ['required_without:maker_user', 'nullable', 'different:checker_phone_number'],
            'maker_user' => ['required_without:maker_first_name', 'required_without:maker_last_name', 'required_without:maker_email', 'required_without:maker_phone_number', 'nullable', 'different:checker_user_id'],
            'checker_first_name' => ['required_without:checker_user'],
            'checker_last_name' => ['required_without:checker_user'],
            'checker_email' => ['required_without:checker_user', 'nullable', 'different:maker_email'],
            'checker_phone_number' => ['required_without:checker_user', 'nullable', 'different:maker_phone_number'],
            'checker_user' => ['required_without:checker_first_name', 'required_without:checker_last_name', 'required_without:checker_email', 'required_without:checker_phone_number', 'nullable', 'different:maker_user_id'],
            'institution_name' => ['required'],
            'institution_email' => ['required'],
            'institution_phone_number' => ['required'],
        ], [
            'checker_first_name.required_without' => 'Enter checker\'s first name',
            'checker_last_name.required_without' => 'Enter checker\'s last name',
            'checker_email.required_without' => 'Enter checker\'s email',
            'checker_phone_number.required_without' => 'Enter checker\'s phone number',
            'maker_first_name.required_without' => 'Enter maker\'s first name',
            'maker_last_name.required_without' => 'Enter maker\'s last name',
            'maker_email.required_without' => 'Enter maker\'s email',
            'maker_phone_number.required_without' => 'Enter maker\'s phone number',
        ]);
//        dd($request->has('maker_user'));
        $financing_institution = FinancingInstitution::create([
            'name' => $request->institution_name,
            'phone_number' => $request->institution_phone_number,
            'email' => $request->institution_email,
            'country_id' => $request->has('country_id') ? $request->country_id : NULL,
            'city_id' => $request->has('city_id') ? $request->city_id : NULL,
            'credit_limit' => $request->credit_limit
        ]);
        if ($request->has('document_name')) {
            foreach ($request->document_name as $key => $doc) {
                if ($request->document_file[$key] instanceof UploadedFile) {
                    CompanyDocument::create([
                        'document_name' => $doc,
                        'file_url' => pathinfo($request->document_file[$key]->store('documents', 'company'), PATHINFO_BASENAME),
                        'documenteable_id' => $financing_institution->id,
                        'documenteable_type' => FinancingInstitution::class,
                    ]);
                }
            }
        }

        if ($request->has('service_charge')) {
            ServiceCharge::create([
                'value' => $request->service_charge_rate,
                'type' => $request->service_charge_type,
                'chargeable_id' => $financing_institution->id,
                'chargeable_type' => FinancingInstitution::class,
            ]);
        }
        // Create Maker User

        if ($request->has('maker_user') && $request->maker_user!=null) {
            $maker = User::find($request->maker_user);
        } else {
            $maker = User::where('email', $request->maker_email)->orWhere('phone_number', $request->maker_phone_number)->first();
            if (!$maker) {
                $maker = User::firstOrCreate([
                    'email' => $request->maker_email,
                    'phone_number' => $request->maker_phone_number,
                    'first_name' => $request->maker_first_name,
                    'last_name' => $request->maker_last_name,
                ], [
                    'password' => Helpers::generatePassword()
                ]);
            }

            // Send email to create password and login
            Password::sendResetLink(['email' => $request->maker_email]);
        }

        FinancingInstitutionUser::firstOrCreate([
            'financing_institution_id' => $financing_institution->id,
            'user_id' => $maker->id,
        ]);

        $maker->givePermissionTo('view financing request');
        $maker->givePermissionTo('update financing request');

        $maker->notify(new RoleUpdate('Maker Checker Role added to your account'));

        // Create Maker User
        if ($request->has('checker_user') && $request->maker_user!=null) {
            $checker = User::find($request->checker_user);
        } else {
            $checker = User::where('email', $request->checker_email)->orWhere('phone_number', $request->checker_phone_number)->first();
            if (!$checker) {
                $checker = User::firstOrCreate([
                    'email' => $request->checker_email,
                    'phone_number' => $request->checker_phone_number,
                    'first_name' => $request->checker_first_name,
                    'last_name' => $request->checker_last_name,
                ], [
                    'password' => Helpers::generatePassword()
                ]);
            }

            // Send email to create password and login
            Password::sendResetLink(['email' => $request->checker_email]);
        }

        FinancingInstitutionUser::firstOrCreate([
            'financing_institution_id' => $financing_institution->id,
            'user_id' => $checker->id,
        ]);

        $checker->givePermissionTo('view financing request');
        $checker->givePermissionTo('update financing request');

        $checker->notify(new RoleUpdate('Maker Checker Role added to your account'));

        toastr()->success('', 'Financing institution has been added successfully');

        return redirect()->route('financing.institutions.index');
    }

    public function edit(FinancingInstitution $financingInstitution)
    {
        $countries = Country::with('cities')->get();
        $cities = City::all();
        $users = User::where('email', '!=', 'admin@ras.com')->get();

        return view('financiers.edit', [
            'page' => 'Edit Financing Institutions',
            'breadcrumbs' => [
                'Financing Institutions' => route('financing.institutions.index'),
                'Edit Financing Institutions' => route('financing.institutions.edit', ['financing_institution' => $financingInstitution])
            ],
            'countries' => $countries,
            'cities' => $cities,
            'users' => $users,
            'financing_institution' => $financingInstitution->load('users')
        ]);
    }

    public function show(FinancingInstitution $financing_institution)
    {
        // Get past 12 months
        $months = [];

        for ($i = 12; $i >= 0; $i--) {
            $month = Carbon::today()->startOfMonth()->subMonth($i);
            $year = Carbon::today()->startOfMonth()->subMonth($i)->format('Y');
            array_push($months, $month);
        }

        // Format months
        $months_formatted = [];
        foreach ($months as $key => $month) {
            array_push($months_formatted, Carbon::parse($month)->format('M'));
        }

        // Amount Paid
        $amount_paid_out = 0;
        // Amount Pending
        $amount_paid_back = 0;
        // Total Number of Requests
        $total_requests = 0;
        // First Approved Requests
        $first_approved_requests = 0;
        // Fully Approved Requests
        $fully_approved_requests = 0;
        // No. of customers
        $customers = [];
        // Users
        $users = $financing_institution->users;

        // Requests Rate
        $finance_request_rate_graph_data = [];
        // Approval Rate
        $approval_rate_graph_data = [];

        $financing_requests = FinancingRequest::with('invoice.user')->where('financing_institution_id', $financing_institution->id)->get();
        $rejected_financing_requests = FinancingRequest::with('invoice.user')->where('financing_institution_id', $financing_institution->id)->where('status', 'rejected')->get();
        $pending_requests_count = $financing_requests->where('status', 'pending')->count();
        $total_requests = $financing_requests->count();
        $rejected_requests_count = $rejected_financing_requests->count();
        $fully_approved_requests = OrderFinancing::with('invoice.orders.orderItems')->where('financing_institution_id', $financing_institution->id)->where('first_approval_on', '!=', NULL)->where('second_approval_on', '!=', NULL)->get();
        $first_approved_requests = OrderFinancing::with('invoice.orders.orderItems')->where('financing_institution_id', $financing_institution->id)->where('first_approval_on', '!=', NULL)->get();

        foreach ($fully_approved_requests as $approved_requests) {
            foreach ($approved_requests->invoice->orders as $order) {
                foreach ($order->orderItems as $order_item) {
                    $amount_paid_out += $order_item->amount;
                }
            }
            // $amount_paid_out = $approved_requests->sum(fn ($request) => $request->invoice->sum(fn ($inv) => $inv->orders->sum('amount')));
        }

        foreach ($financing_requests as $request) {
            array_push($customers, $request->invoice->user);
        }

        foreach ($months as $month) {
            $requests_rate = FinancingRequest::where('financing_institution_id', $financing_institution->id)->whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->count();
            array_push($finance_request_rate_graph_data, $requests_rate);
            $approval_rate = OrderFinancing::with('invoice.orders.orderItems')->where('financing_institution_id', $financing_institution->id)->where('first_approval_on', '!=', NULL)->where('second_approval_on', '!=', NULL)->count();
            array_push($approval_rate_graph_data, $approval_rate);
        }

        return view('financiers.show', [
            'page' => 'Financing Institution Details',
            'breadcrumbs' => [
                'Financing Institutions' => route('financing.institutions.index'),
                $financing_institution->name => route('financing.institutions.show', ['financing_institution' => $financing_institution])
            ],
            'financing_institution' => $financing_institution,
            'users' => $users,
            'months' => $months_formatted,
            'customers' => collect($customers)->unique()->count(),
            'fully_approved_requests' => $fully_approved_requests->count(),
            'first_approved_requests' => $first_approved_requests->count(),
            'amount_paid_out' => $amount_paid_out,
            'total_requests_count' => $total_requests,
            'rejected_requests_count' => $rejected_requests_count,
            'pending_requests_count' => $pending_requests_count,
            'finance_request_rate_graph_data' => $finance_request_rate_graph_data,
            'approval_rate_graph_data' => $approval_rate_graph_data
        ]);
    }

    public function update(Request $request, FinancingInstitution $financing_institution)
    {
        $request->validate([
            // 'maker_first_name' => ['required_without:maker_user'],
            // 'maker_last_name' => ['required_without:maker_user'],
            // 'maker_email' => ['required_without:maker_user'],
            // 'maker_phone_number' => ['required_without:maker_user'],
            // 'maker_user' => ['required_without:maker_first_name', 'required_without:maker_last_name', 'required_without:maker_email', 'required_without:maker_phone_number'],
            // 'checker_first_name' => ['required_without:checker_user'],
            // 'checker_last_name' => ['required_without:checker_user'],
            // 'checker_email' => ['required_without:checker_user'],
            // 'checker_phone_number' => ['required_without:checker_user'],
            // 'checker_user' => ['required_without:checker_first_name', 'required_without:checker_last_name', 'required_without:checker_email', 'required_without:checker_phone_number'],
            'institution_name' => ['required'],
            'institution_email' => ['required'],
            'institution_phone_number' => ['required'],
            'credit_limit' => ['required', 'integer'],
        ], [
            // 'checker_first_name.required_without' => 'Enter checker\'s first name',
            // 'checker_last_name.required_without' => 'Enter checker\'s last name',
            // 'checker_email.required_without' => 'Enter checker\'s email',
            // 'checker_phone_number.required_without' => 'Enter checker\'s phone number',
            // 'maker_first_name.required_without' => 'Enter maker\'s first name',
            // 'maker_last_name.required_without' => 'Enter maker\'s last name',
            // 'maker_email.required_without' => 'Enter maker\'s email',
            // 'maker_phone_number.required_without' => 'Enter maker\'s phone number',
        ]);

        $financing_institution->udpate([
            'name' => $request->institution_name,
            'phone_number' => $request->institution_phone_number,
            'email' => $request->institution_email,
            'country_id' => $request->has('country_id') ? $request->country_id : NULL,
            'city_id' => $request->has('city_id') ? $request->city_id : NULL,
            'credit_limit' => $request->credit_limit
        ]);

        // Create Maker User
        if ($request->has('maker_user')) {
            $maker = User::find($request->maker_user_id);
        } else {
            $maker = User::create([
                'first_name' => $request->maker_first_name,
                'last_name' => $request->maker_last_name,
                'email' => $request->maker_email,
                'phone_number' => $request->maker_phone_number,
                'password' => Helpers::generatePassword()
            ]);

            // Send email to create password and login
            Password::sendResetLink($request->checker_email);
        }

        FinancingInstitutionUser::firstOrCreate([
            'financing_institution_id' => $financing_institution->id,
            'user_id' => $maker->id,
        ]);

        $maker->givePermissionTo('view financing request');
        $maker->givePermissionTo('update financing request');

        $maker->notify(new RoleUpdate('Maker Checker Role added to your account'));

        // Create Maker User
        if ($request->has('checker_user')) {
            $checker = User::find($request->checker_user_id);
        } else {
            $checker = User::create([
                'first_name' => $request->checker_first_name,
                'last_name' => $request->checker_last_name,
                'email' => $request->checker_email,
                'phone_number' => $request->checker_phone_number,
                'password' => Helpers::generatePassword()
            ]);

            // Send email to create password and login
            Password::sendResetLink($request->checker_email);
        }

        FinancingInstitutionUser::firstOrCreate([
            'financing_institution_id' => $financing_institution->id,
            'user_id' => $checker->id,
        ]);

        $checker->givePermissionTo('view financing request');
        $checker->givePermissionTo('update financing request');

        $checker->notify(new RoleUpdate('Maker Checker Role added to your account'));

        toastr()->success('', 'Financing Institution updated successfully');

        return redirect()->route('financing-institutions.index');
    }

    public function destroy(FinancingInstitution $institution)
    {
        // TODO: Add check if institution has active financing requests

        $institution->delete();

        toastr()->success('', 'Financing institution deleted successfully');

        return redirect()->route('financing-institutions.index');
    }

    public function customers()
    {
        $users = [];
        if(auth()->user()->hasRole('admin')) {
            $financing_requests = FinancingRequest::with('invoice.user')->get();
            foreach ($financing_requests as $request) {
                array_push($users, $request->invoice->user);
            }
        } else if (auth()->user()->hasPermissionTo('view financing request') && auth()->user()->financingInstitutions->count() <= 0) {
            $financing_requests = FinancingRequest::with('invoice.user')->get();
            foreach ($financing_requests as $request) {
                array_push($users, $request->invoice->user);
            }
        } else {
            $user_financing_institutions_ids = auth()->user()->financingInstitutions->pluck('id');
            $financing_requests = FinancingRequest::with('invoice.user')->whereIn('financing_institution_id', $user_financing_institutions_ids)->get();
            foreach ($financing_requests as $request) {
                array_push($users, $request->invoice->user);
            }
        }

        return view('financiers.customers.index', [
            'page' => 'Financier Customers',
            'breadcrumbs' => [
                'Customers' => route('financing.institutions.customers')
            ],
            'users' => $users
        ]);
    }

    public function customer(User $user)
    {
        $user->load('invoices.financingRequest');

        return view('financiers.customers.show', [
            'page' => 'Financier Customers',
            'breadcrumbs' => [
                'Customers' => route('financing.institutions.customers'),
                'Customer' => route('financing.institutions.customers')
            ],
            'user' => $user
        ]);
    }
}
