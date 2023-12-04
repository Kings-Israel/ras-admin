<?php

namespace App\Policies;

use App\Models\InspectingInstitution;
use App\Models\OrderRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InspectionRequestPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrderRequest $orderRequest): bool
    {
        $inspection_institutions = $user->inspectors->pluck('id');

        if ($user->hasPermissionTo('view inspection request') && $inspection_institutions->contains($orderRequest->requesteable_id) && $orderRequest->requesteable_type == InspectingInstitution::class) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OrderRequest $orderRequest): bool
    {
        $inspection_institutions = $user->inspectors->pluck('id');

        if ($user->hasPermissionTo('update inspection request') && $inspection_institutions->contains($orderRequest->id) && $orderRequest->requesteable_type == InspectingInstitution::class) {
            return true;
        }

        return false;
    }
}
