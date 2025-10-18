<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view any orders.
     */
    public function viewAny(User $user): bool
    {
        // Admin, seller, or customer can view their own orders
        return in_array($user->role_id, [1, 3, 4]);
    }

    /**
     * Determine whether the user can view a specific order.
     */
    public function view(User $user, Order $order): bool
    {
        // Admin can view all, seller can view orders they received, customer can view their own
        return $user->isAdmin()
            || ($user->isSeller() && $order->seller_id === $user->id)
            || ($user->isCustomer() && $order->buyer_id === $user->id);
    }

    /**
     * Determine whether the user can create orders.
     */
    public function create(User $user): bool
    {
        // Only customers can place orders
        return $user->isCustomer();
    }

    /**
     * Determine whether the user can update an order.
     */
    public function update(User $user, Order $order): bool
    {
        // Admin or the buyer who placed the order
        return $user->isAdmin() || ($user->isCustomer() && $order->buyer_id === $user->id);
    }

    /**
     * Determine whether the user can delete (cancel) an order.
     */
    public function delete(User $user, Order $order): bool
    {
        // Admin can delete any, customer can cancel if still pending
        return $user->isAdmin() || ($user->isCustomer() && $order->status === 'pending');
    }
}
