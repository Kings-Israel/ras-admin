<?php

namespace App\Policies;

use App\Models\FinancingInstitution;
use App\Models\FinancingInstitutionUser;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FinancingInstitutionPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FinancingInstitution $financingInstitution): bool
    {
        $user_financing_institution = FinancingInstitutionUser::where('user_id', $user->id)->where('financing_institution_id', $financingInstitution->id)->first();
        if ($user->hasPermissionTo('view financier') && $user_financing_institution) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FinancingInstitution $financingInstitution): bool
    {
        $user_financing_institution = FinancingInstitutionUser::where('user_id', $user->id)->where('financing_institution_id', $financingInstitution->id)->first();
        if ($user->hasPermissionTo('update financier') && $user_financing_institution) {
            return true;
        }

        return false;
    }
}
