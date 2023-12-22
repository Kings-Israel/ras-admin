<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        if ($user->hasPermissionTo('view warehouse')) {
            $user_warehouses = $user->warehouses->pluck('id');
            if ($product->warehouses()->exists() && !$user_warehouses->intersect($product->warehouses->pluck('id'))->isEmpty()) {
                return true;
            }
        }

        return false;
    }
}
