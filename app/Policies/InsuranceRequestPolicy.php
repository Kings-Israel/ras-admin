<?php

namespace App\Policies;

use App\Models\InsuranceCompany;
use App\Models\OrderRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InsuranceRequestPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrderRequest $orderRequest): bool
    {
        $insurers = $user->insuranceCompanies->pluck('id');

        if ($user->hasPermissionTo('view insurance request') && $insurers->contains($orderRequest->requesteable_id) && $orderRequest->requesteable_type == InsuranceCompany::class) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OrderRequest $orderRequest): bool
    {
        $insurers = $user->insuranceCompanies->pluck('id');

        if ($user->hasPermissionTo('update insurance request') && $insurers->contains($orderRequest->id) && $orderRequest->requesteable_type == InsuranceCompany::class) {
            return true;
        }

        return false;
    }
}
