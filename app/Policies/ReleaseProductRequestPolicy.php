<?php

namespace App\Policies;

use App\Models\ReleaseProductRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReleaseProductRequestPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ReleaseProductRequest $releaseProductRequest): bool
    {
        $user_warehouses = $user->warehouses->pluck('id');

        if ($user->hasPermissionTo('view stocklift request') && $user_warehouses->contains($releaseProductRequest->warehouse_id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ReleaseProductRequest $releaseProductRequest): bool
    {
        $user_warehouses = $user->warehouses->pluck('id');

        if ($user->hasPermissionTo('update stocklift request') && $user_warehouses->contains($releaseProductRequest->warehouse_id)) {
            return true;
        }

        return false;
    }
}
