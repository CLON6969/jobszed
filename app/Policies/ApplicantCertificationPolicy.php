<?php

namespace App\Policies;

use App\Models\ApplicantCertification;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApplicantCertificationPolicy
{
    /**
     * Allow user to view any certifications (optional: change to true if needed)
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Allow user to view their own certification
     */
    public function view(User $user, ApplicantCertification $applicantCertification): bool
    {
        return $user->id === $applicantCertification->user_id;
    }

    /**
     * Allow any authenticated user to create certifications
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Allow user to update only their own certifications
     */
    public function update(User $user, ApplicantCertification $applicantCertification): bool
    {
        return $user->id === $applicantCertification->user_id;
    }

    /**
     * Allow user to delete only their own certifications
     */
    public function delete(User $user, ApplicantCertification $applicantCertification): bool
    {
        return $user->id === $applicantCertification->user_id;
    }

    /**
     * Disallow restoring certifications (change to true if needed)
     */
    public function restore(User $user, ApplicantCertification $applicantCertification): bool
    {
        return false;
    }

    /**
     * Disallow force deleting certifications (change to true if needed)
     */
    public function forceDelete(User $user, ApplicantCertification $applicantCertification): bool
    {
        return false;
    }
}
