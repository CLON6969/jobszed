<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role_id, [1, 3, 4]);
    }

    public function view(User $user, Product $product): bool
    {
        return $user->isAdmin()
            || ($user->isSeller() && $product->seller_id === $user->id)
            || $user->isCustomer();
    }

    public function create(User $user): bool
    {
        return $user->isSeller() || $user->isAdmin();
    }

    public function update(User $user, Product $product): bool
    {
        return $user->isAdmin() || ($user->isSeller() && $product->seller_id === $user->id);
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->isAdmin() || ($user->isSeller() && $product->seller_id === $user->id);
    }
}
