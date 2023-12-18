<?php

namespace App\Policies;

use App\Models\OrderRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DeliveryRequestPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrderRequest $orderRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OrderRequest $orderRequest): bool
    {
        //
    }
}
