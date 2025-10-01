<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Education;

class EducationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Education $education): bool
    {
        return $user->id === $education->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Education $education): bool
    {
        return $user->id === $education->user_id;
    }

    public function delete(User $user, Education $education): bool
    {
        return $user->id === $education->user_id;
    }
}
