<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role_id, [1, 3, 4]);
    }

    public function view(User $user, Review $review): bool
    {
        return $user->isAdmin()
            || ($user->isCustomer() && $review->user_id === $user->id)
            || ($user->isSeller() && $review->product->seller_id === $user->id);
    }

    public function create(User $user): bool
    {
        return $user->isCustomer();
    }

    public function update(User $user, Review $review): bool
    {
        return $user->isAdmin() || ($user->isCustomer() && $review->user_id === $user->id);
    }

    public function delete(User $user, Review $review): bool
    {
        return $user->isAdmin() || ($user->isCustomer() && $review->user_id === $user->id);
    }
}
