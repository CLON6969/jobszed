<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Experience;

class ExperiencePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Experience $experience): bool
    {
        return $user->id === $experience->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Experience $experience): bool
    {
        return $user->id === $experience->user_id;
    }

    public function delete(User $user, Experience $experience): bool
    {
        return $user->id === $experience->user_id;
    }
}
