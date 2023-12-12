<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Auth\Access\Response;

class WarehousePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Warehouse $warehouse): bool
    {
        $user_warehouses = $user->warehouses->pluck('id');

        if ($user->hasPermissionTo('view warehouse') && $user_warehouses->contains($warehouse->id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create warehouse') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Warehouse $warehouse): bool
    {
        $user_warehouses = $user->warehouses->pluck('id');

        if ($user->hasPermissionTo('update warehouse') && $user_warehouses->contains($warehouse->id)) {
            return true;
        }

        return false;
    }
}
