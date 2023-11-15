<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\FinancingInstitution;
use App\Models\FinancingInstitutionUser;
use App\Models\User;
use App\Notifications\RoleUpdate;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
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
        $financing_institutions = FinancingInstitution::withCount('users')->get();

        if (auth()->user()->hasPermissionTo('view financing request') && auth()->user()->financingInstitutions->count() <= 0) {
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
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'institution_name' => ['required'],
            'institution_phone_number' => ['required', new PhoneNumber],
            'institution_email' => ['required'],
            'maker_first_name' => ['required_without:maker_user',],
            'maker_last_name' => ['required_without:maker_user'],
            'maker_email' => ['required_without:maker_user', 'nullable', 'different:checker_email'],
            'maker_phone_number' => ['required_without:maker_users', 'nullable', 'different:checker_phone_number'],
            'maker_user_id' => ['required_without:maker_first_name', 'required_without:maker_last_name', 'required_without:maker_email', 'required_without:maker_phone_number', 'nullable', 'different:checker_user_id'],
            'checker_first_name' => ['required_without:checker_user'],
            'checker_last_name' => ['required_without:checker_user'],
            'checker_email' => ['required_without:checker_user', 'nullable', 'different:maker_email'],
            'checker_phone_number' => ['required_without:checker_user', 'nullable', 'different:maker_phone_number'],
            'checker_user_id' => ['required_without:checker_first_name', 'required_without:checker_last_name', 'required_without:checker_email', 'required_without:checker_phone_number', 'nullable', 'different:maker_user_id'],
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

        $financing_institution = FinancingInstitution::create([
            'name' => $request->institution_name,
            'phone_number' => $request->institution_phone_number,
            'email' => $request->institution_email,
            'country_id' => $request->has('country_id') ? $request->country_id : NULL,
            'city_id' => $request->has('city_id') ? $request->city_id : NULL,
        ]);

        // Create Maker User
        if ($request->has('maker_user')) {
            $maker = User::find($request->maker_user_id);
        } else {
            $maker = User::where('email', $request->maker_email)->orWhere('phone_number', $request->maker_phone_number)->first();
            if (!$maker) {
                $maker = User::firstOrCreate([
                    'email' => $request->maker_email,
                    'phone_number' => $request->maker_phone_number,
                    'first_name' => $request->maker_first_name,
                    'last_name' => $request->maker_last_name,
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
        if ($request->has('checker_user')) {
            $checker = User::find($request->checker_user_id);
        } else {
            $checker = User::where('email', $request->checker_email)->orWhere('phone_number', $request->checker_phone_number)->first();
            if (!$checker) {
                $checker = User::create([
                    'email' => $request->checker_email,
                    'phone_number' => $request->checker_phone_number,
                    'first_name' => $request->checker_first_name,
                    'last_name' => $request->checker_last_name,
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

        return redirect()->route('financing-institutions.index');
    }

    public function edit(FinancingInstitution $financingInstitution)
    {
        $countries = Country::with('cities')->get();
        $cities = City::all();
        $users = User::where('email', '!=', 'admin@ras.com')->get();

        return view('financiers.edit', [
            'page' => 'Edit Financing Institutions',
            'breadcrumbs' => [
                'Financing Institutions' => route('financing-institutions.index'),
                'Edit Financing Institutions' => route('financing-institutions.edit', ['financing_institution' => $financingInstitution])
            ],
            'countries' => $countries,
            'cities' => $cities,
            'users' => $users,
            'financing_institution' => $financingInstitution->load('users')
        ]);
    }

    public function update(Request $request, FinancingInstitution $financing_institution)
    {
        $request->validate([
            'maker_first_name' => ['required_without:maker_user'],
            'maker_last_name' => ['required_without:maker_user'],
            'maker_email' => ['required_without:maker_user'],
            'maker_phone_number' => ['required_without:maker_users'],
            'maker_user_id' => ['required_without:maker_first_name', 'required_without:maker_last_name', 'required_without:maker_email', 'required_without:maker_phone_number'],
            'checker_first_name' => ['required_without:checker_user'],
            'checker_last_name' => ['required_without:checker_user'],
            'checker_email' => ['required_without:checker_user'],
            'checker_phone_number' => ['required_without:checker_user'],
            'checker_user_id' => ['required_without:checker_first_name', 'required_without:checker_last_name', 'required_without:checker_email', 'required_without:checker_phone_number'],
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

        $financing_institution->udpate([
            'name' => $request->institution_name,
            'phone_number' => $request->institution_phone_number,
            'email' => $request->institution_email,
            'country_id' => $request->has('country_id') ? $request->country_id : NULL,
            'city_id' => $request->has('city_id') ? $request->city_id : NULL,
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
}
