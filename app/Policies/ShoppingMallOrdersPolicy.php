<?php

namespace App\Policies;

use App\Models\ShoppingMallOrders;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShoppingMallOrdersPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShoppingMallOrders $shoppingMallOrders): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShoppingMallOrders $shoppingMallOrders): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShoppingMallOrders $shoppingMallOrders): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShoppingMallOrders $shoppingMallOrders): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShoppingMallOrders $shoppingMallOrders): bool
    {
        //
    }
}
