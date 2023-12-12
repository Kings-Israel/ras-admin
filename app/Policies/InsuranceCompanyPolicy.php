<?php

namespace App\Policies;

use App\Models\InsuranceCompany;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InsuranceCompanyPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InsuranceCompany $insuranceCompany): bool
    {
        $insurers = $user->insuranceCompanies->pluck('id');

        if ($insurers->contains($insuranceCompany->id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InsuranceCompany $insuranceCompany): bool
    {
        $insurers = $user->insuranceCompanies->pluck('id');

        if ($user->hasPermissionTo('update insurance company') && $insurers->contains($insuranceCompany->id)) {
            return true;
        }

        return false;
    }
}
