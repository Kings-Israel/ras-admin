<?php

namespace App\Policies;

use App\Models\FinancingInstitutionUser;
use App\Models\FinancingRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FinancingRequestPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FinancingRequest $financingRequest): bool
    {
        $user_financing_institution = FinancingInstitutionUser::where('user_id', $user->id)->where('financing_institution_id', $financingRequest->financingInstitution->id)->first();

        if (!$user_financing_institution && $user->hasPermissionTo('view financing request')) {
            return true;
        }

        if ($user->hasPermissionTo('view financing request') && $user_financing_institution) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FinancingRequest $financingRequest): bool
    {
        $user_financing_institution = FinancingInstitutionUser::where('user_id', $user->id)->where('financing_institution_id', $financingRequest->financingInstitution->id)->first();

        if ($user->hasPermissionTo('update financing request') && $user_financing_institution) {
            return true;
        }

        return false;
    }
}
