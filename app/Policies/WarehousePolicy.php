<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarehousePolicy
{
    /**
     * Create a new policy instance.
     */
    use HandlesAuthorization;

    public function view(User $user, Warehouse $warehouse)
    {
        // Check if the warehouse is associated with the user
        return $warehouse->users->contains($user);
    }
}
