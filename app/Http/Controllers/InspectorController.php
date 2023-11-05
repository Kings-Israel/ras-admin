<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Country;
use App\Models\InspectingInstitution;
use App\Models\InspectorUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class InspectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view inspector', ['only' => ['index', 'show']]);
        $this->middleware('can:create inspector', ['only' => ['create', 'store']]);
        $this->middleware('can:update inspector', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete inspector', ['only' => ['destroy']]);
    }


    public function index()
    {
        $inspectors = InspectingInstitution::withCount('users')->get();

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
            'users' => $users
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
}
