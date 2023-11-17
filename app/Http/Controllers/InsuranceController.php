<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Country;
use App\Models\InsuranceCompany;
use App\Models\InsuranceRequest;
use App\Models\InsuranceCompanyUser;
use App\Models\InsuranceReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class InsuranceController extends Controller
{
    public function companies()
    {
        $insurers = InsuranceCompany::withCount('users')->get();

        return view('insurance.companies.index', [
            'page' => 'Insurance Companies',
            'breadcrumbs' => [
                'Insurance Companies' => route('insurance.companies.index')
            ],
            'insurers' => $insurers
        ]);
    }

    public function company(InsuranceCompany $insurance_company)
    {
        $insurance_company->load('users');

        return view('insurance.companies.show', [
            'page' => $insurance_company->name,
            'breadcrumbs' => [
                'Insurance Comapnies' => route('insurance.companies.index'),
                $insurance_company->name => route('insurance.companies.show', ['insurance_company' => $insurance_company])
            ],
            'insurance_company' => $insurance_company
        ]);
    }

    public function editCompany(InsuranceCompany $insurance_company)
    {
        return view('insurance.companies.edit', [
            'page' => 'Edit '.$insurance_company->name,
            'breadcrumbs' => [
                'Insurance Companies' => route('insurance.companies.index'),
                'Edit '.$insurance_company->name => route('insurance.companies.edit', ['insurance_company' => $insurance_company])
            ]
        ]);
    }

    public function createCompany()
    {
        $countries = Country::with('cities')->orderBy('name', 'ASC')->get();
        $users = User::where('email', '!=', 'admin@ras.com')->get();

        return view('insurance.companies.create', [
            'page' => 'Insurers',
            'breadcrumbs' => [
                'Insurance Companies' => route('insurance.companies.index'),
                'Add Insurer' => route('insurance.companies.create')
            ],
            'countries' => $countries,
            'users' => $users
        ]);
    }

    public function storeCompany(Request $request)
    {
        $request->validate([
            'first_name' => ['required_without:users'],
            'last_name' => ['required_without:users'],
            'email' => ['required_without:users'],
            'phone_number' => ['required_without:users'],
            'name' => ['required'],
            'insurer_email' => ['required'],
            'insurer_phone_number' => ['required'],
            'users' => ['required_without:first_name', 'required_without:last_name', 'required_without:email', 'required_without:phone_number', 'array'],
        ], [
            'first_name.required_without' => 'Enter admin\'s first name',
            'last_name.required_without' => 'Enter admin\'s last name',
            'email.required_without' => 'Enter admin\'s email',
            'phone_number.required_without' => 'Enter admin\'s phone number'
        ]);

        $insurer = InsuranceCompany::create(
                [
                    'email' => $request->insurer_email,
                    'name' => $request->name,
                ],
                [
                    'phone_number' => $request->insurer_phone_number,
                    'country_id' => $request->has('country_id') ? $request->country_id : NULL,
                ]
            );

        if ($request->has('users') && $request->users != NULL) {
            foreach ($request->users as $user) {
                $user_details = User::find($user);

                InsuranceCompanyUser::firstOrCreate([
                    'insurance_company_id' => $insurer->id,
                    'user_id' => $user,
                ]);

                $user_details->givePermissionTo('update insurance request');
                $user_details->givePermissionTo('view insurance request');
                $user_details->givePermissionTo('create insurance report');
                $user_details->givePermissionTo('view insurance report');
                $user_details->givePermissionTo('update insurance report');
                $user_details->givePermissionTo('delete insurance report');
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

            InsuranceCompanyUser::firstOrCreate([
                'user_id' => $user->id,
                'insurance_company_id' => $insurer->id,
            ]);

            $user->givePermissionTo('create insurance report');
            $user->givePermissionTo('view insurance report');
            $user->givePermissionTo('update insurance report');
            $user->givePermissionTo('delete insurance report');
            $user->givePermissionTo('update insurance request');
            $user->givePermissionTo('view insurance request');
        }

        toastr()->success('', 'Insurer added successfully');

        return redirect()->route('insurance.companies.index');
    }

    public function updateCompany(Request $request)
    {
        $request->validate([
            'first_name' => ['required_without:users'],
            'last_name' => ['required_without:users'],
            'email' => ['required_without:users'],
            'phone_number' => ['required_without:users'],
            'name' => ['required'],
            'insurer_email' => ['required'],
            'insurer_phone_number' => ['required'],
            'users' => ['required_without:first_name', 'required_without:last_name', 'required_without:email', 'required_without:phone_number', 'array'],
        ], [
            'first_name.required_without' => 'Enter admin\'s first name',
            'last_name.required_without' => 'Enter admin\'s last name',
            'email.required_without' => 'Enter admin\'s email',
            'phone_number.required_without' => 'Enter admin\'s phone number'
        ]);

        $insurer = InsuranceCompany::create([
            'name' => $request->name,
            'email' => $request->insurer_email,
            'phone_number' => $request->insurer_phone_number,
            'country_id' => $request->has('country_id') ? $request->country_id : NULL,
        ]);

        if ($request->has('users') && $request->users != NULL) {
            foreach ($request->users as $user) {
                $user_details = User::find($user);

                InsuranceCompanyUser::firstOrCreate([
                    'insurance_company_id' => $insurer->id,
                    'user_id' => $user,
                ]);

                $user->givePermissionTo('create insurance report');
                $user->givePermissionTo('view insurance report');
                $user->givePermissionTo('update insurance report');
                $user->givePermissionTo('delete insurance report');
                $user->givePermissionTo('create insurance request');
                $user->givePermissionTo('view insurance request');
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

            InsuranceCompanyUser::firstOrCreate([
                'user_id' => $user->id,
                'insurance_company_id' => $insurer->id,
            ]);

            $user->givePermissionTo('create insurance report');
            $user->givePermissionTo('view insurance report');
            $user->givePermissionTo('update insurance report');
            $user->givePermissionTo('delete insurance report');
            $user->givePermissionTo('create insurance request');
            $user->givePermissionTo('view insurance request');
        }

        toastr()->success('', 'Insurer added successfully');

        return redirect()->route('insurance.companies.index');
    }

    public function requests()
    {
        $insurance_requests = InsuranceRequest::with('insuranceCompany', 'orderItem.product.media')->get();

        return view('insurance.requests.index', [
            'page' => 'Insurance Requests',
            'breadcrumbs' => [
                'Insurance Requests' => route('insurance.requests.index'),
            ],
            'insurance_requests' => $insurance_requests
        ]);
    }

    public function request(InsuranceRequest $insurance_request)
    {
        $insurance_request->load('orderItem.product.business', 'orderItem.product.media');

        return view('insurance.requests.show', [
            'page' => 'Insurance Request',
            'breadcrumbs' => [
                'Insurance Requests' => route('insurance.requests.index'),
                'Insurance Request Details' => route('insurance.requests.show', ['insurance_request' => $insurance_request])
            ],
            'insurance_request' => $insurance_request
        ]);
    }

    public function updateCost(Request $request, InsuranceRequest $insurance_request)
    {
        $request->validate([
            'insurance_cost' => ['required', 'integer']
        ]);

        $insurance_request->update([
            'cost' => $request->insurance_cost
        ]);

        toastr()->success('', 'Insurance request updated successfully');

        return back();
    }

    public function reports()
    {
        $insurance_reports = InsuranceReport::with('user', 'orderItem.product.media', 'insuranceCompany')->get();

        return view('insurance.reports.index', [
            'page' => 'Insurance Reports',
            'breadcrumbs' => [
                'Insurance Reports' => route('insurance.reports.index'),
            ],
            'insurance_reports' => $insurance_reports
        ]);
    }
}
