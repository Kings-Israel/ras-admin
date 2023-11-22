<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\LogisticsCompany;
use App\Models\LogisticsCompanyUser;
use App\Models\User;
use App\Notifications\RoleUpdate;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

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

        return view('logistics.create', [
            'page' => 'Logistics Company',
            'breadcrumbs' => [
                'Logistics Companies' => route('logistics.index'),
                'Add Logistics Company' => route('logistics.create')
            ],
            'countries' => $countries,
            'users' => $users
        ]);
    }

    public function store(Request $request)
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

        $logistics_company = LogisticsCompany::create([
            'name' => $request->company_name,
            'phone_number' => $request->company_phone_number,
            'email' => $request->company_email,
            'country_id' => $request->has('country_id') ? $request->country_id : NULL,
            'city_id' => $request->has('city_id') ? $request->city_id : NULL,
        ]);

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
}
