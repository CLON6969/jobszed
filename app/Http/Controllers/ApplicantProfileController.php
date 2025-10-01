<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicantProfile;

class ApplicantProfileController extends Controller
{
    /**
     * Show the applicant profile edit form.
     */
    public function edit()
    {
        $profile = ApplicantProfile::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        return view('applicant.profile.edit', compact('profile'));
    }

    /**
     * Update the applicant profile.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'national_id' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'nationality' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'linkedin_url' => 'nullable|url',
            'professional_summary' => 'nullable|string',
            'highest_education' => 'nullable|string|max:150',
            'field_of_study' => 'nullable|string|max:150',
            'years_of_experience' => 'nullable|integer|min:0',
            'previous_employers' => 'nullable|string',
            'job_titles' => 'nullable|string',
        ]);

        // Update or create the profile record
        ApplicantProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
