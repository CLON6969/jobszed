<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can manage any model
     */
    public function manage(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine if admin can delete inappropriate content
     */
    public function deleteContent(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine if admin can approve guest reviews
     */
    public function approveReview(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine if admin can access analytics
     */
    public function viewAnalytics(User $user)
    {
        return $user->isAdmin();
    }
}
