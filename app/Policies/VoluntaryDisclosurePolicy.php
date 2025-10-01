<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VoluntaryDisclosure;

class VoluntaryDisclosurePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, VoluntaryDisclosure $disclosure): bool
    {
        return $user->id === $disclosure->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, VoluntaryDisclosure $disclosure): bool
    {
        return $user->id === $disclosure->user_id;
    }

    public function delete(User $user, VoluntaryDisclosure $disclosure): bool
    {
        return $user->id === $disclosure->user_id;
    }
}
