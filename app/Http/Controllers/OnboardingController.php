<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    ApplicantProfile,
    Experience,
    Education,
    ApplicantLocation,
    Location,
    ApplicantCertification,
    VoluntaryDisclosure
};

class OnboardingController extends Controller
{
    public function step1()
    {
        $user = Auth::user();
        $profile = ApplicantProfile::firstOrCreate(['user_id' => $user->id]);

        return view('onboarding.step1', compact('user', 'profile'))
            ->with(['step' => 1, 'progress' => 16]);
    }

    public function postStep1(Request $request)
    {
        $request->validate([
            'national_id' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'nationality' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'linkedin_url' => 'nullable|url',
            'professional_summary' => 'nullable|string',
            'years_of_experience' => 'nullable|integer|min:0',
        ]);

        ApplicantProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only([
                'national_id', 'date_of_birth', 'gender', 'nationality',
                'address', 'postal_code', 'linkedin_url', 'professional_summary',
                'years_of_experience'
            ]) + ['user_id' => Auth::id()]
        );

        return redirect()->route('onboarding.step2');
    }

    public function step2()
    {
        $user = Auth::user();
        $experience = Experience::where('user_id', $user->id)->latest()->first();

        return view('onboarding.step2', compact('experience'))
            ->with(['step' => 2, 'progress' => 32]);
    }

    public function postStep2(Request $request)
    {
        $request->validate([
            'employer' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Experience::updateOrCreate(
            ['user_id' => Auth::id(), 'id' => $request->input('experience_id')],
            [
                'employer' => $request->employer,
                'job_title' => $request->job_title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'user_id' => Auth::id()
            ]
        );

        return redirect()->route('onboarding.step3');
    }

    public function step3()
    {
        $user = Auth::user();
        $education = Education::where('user_id', $user->id)->latest()->first();

        return view('onboarding.step3', compact('education'))
            ->with(['step' => 3, 'progress' => 48]);
    }

    public function postStep3(Request $request)
    {
        $request->validate([
            'level' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
        ]);

        Education::updateOrCreate(
            ['user_id' => Auth::id(), 'id' => $request->input('education_id')],
            [
                'level' => $request->level,
                'field_of_study' => $request->field_of_study,
                'user_id' => Auth::id()
            ]
        );

        return redirect()->route('onboarding.step4');
    }
public function step4()
{
    $user = Auth::user();
    // Get all certifications for the user
    $certifications = ApplicantCertification::where('user_id', $user->id)->get();

    return view('onboarding.step4', compact('certifications'))
        ->with(['step' => 4, 'progress' => 64]);
}

public function postStep4(Request $request)
{
    $data = $request->validate([
        'certifications' => 'required|array',
        'certifications.*.id' => 'nullable|exists:applicant_certifications,id',
        'certifications.*.name' => 'required|string|max:255',
        'certifications.*.certification_type' => 'required|string|max:255',
        'certifications.*.issuing_organization' => 'required|string|max:255',
        'certifications.*.registered_with_authority' => 'required|boolean',
        'certifications.*.registration_number' => 'nullable|string|max:255',
        'certifications.*.authority_certificate_path' => 'nullable|string|max:255',
        'certifications.*.level' => 'nullable|string|max:255',
        'certifications.*.status' => 'required|in:obtained,in_progress',
        'certifications.*.obtained_date' => 'nullable|date',
    ]);

    $userId = Auth::id();

    foreach ($data['certifications'] as $cert) {
        if (!empty($cert['id'])) {
            // Update existing certification
            ApplicantCertification::where('user_id', $userId)
                ->where('id', $cert['id'])
                ->update($cert);
        } else {
            // Create new certification
            ApplicantCertification::create(array_merge($cert, ['user_id' => $userId]));
        }
    }

    return redirect()->route('onboarding.step5');
}


    public function step5()
    {
        $user = Auth::user();
        $disclosure = VoluntaryDisclosure::firstOrCreate(['user_id' => $user->id]);

        return view('onboarding.step5', compact('disclosure'))
            ->with(['step' => 5, 'progress' => 80]);
    }

    public function postStep5(Request $request)
    {
        $request->validate([
            'disability_status' => 'required|in:yes,no,prefer_not_to_say',
            'ethnicity' => 'nullable|string|max:255',
            'gender_identity' => 'nullable|string|max:255',
            'is_veteran' => 'required|boolean',
        ]);

        VoluntaryDisclosure::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only('disability_status', 'ethnicity', 'gender_identity', 'is_veteran') + ['user_id' => Auth::id()]
        );

        return redirect()->route('onboarding.review');
    }

    public function review()
    {
        $user = Auth::user();

        $profile = ApplicantProfile::where('user_id', $user->id)->first();
        $experience = Experience::where('user_id', $user->id)->latest()->first();
        $education = Education::where('user_id', $user->id)->latest()->first();
        $certification = ApplicantCertification::where('user_id', $user->id)->latest()->first();
        $disclosure = VoluntaryDisclosure::where('user_id', $user->id)->first();

        return view('onboarding.review', compact('user', 'profile', 'experience', 'education', 'certification', 'disclosure'))
            ->with(['step' => 6, 'progress' => 100]);
    }

    public function submit()
    {
        $user = Auth::user();
        $user->update(['onboarding_complete' => true]);

        return redirect()->route('user.applicant.dashboard')->with('success', 'Onboarding completed successfully.');
    }
}
