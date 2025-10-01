<?php
namespace App\Policies;

use App\Models\User;
use App\Models\ApplicantLocation;

class ApplicantLocationPolicy
{
    public function update(User $user, ApplicantLocation $location): bool
    {
        return $user->id === $location->user_id;
    }

    public function delete(User $user, ApplicantLocation $location): bool
    {
        return $user->id === $location->user_id;
    }
}
