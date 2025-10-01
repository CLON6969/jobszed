<?php

namespace App\Http\Controllers\User\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicantProfile;
use Illuminate\Support\Facades\Auth;

class ApplicantProfileController extends Controller
{
    public function index()
    {
        $profile = ApplicantProfile::where('user_id', Auth::id())->first();
        return view('user.applicant.profiles.index', compact('profile'));
    }

    public function create()
    {
        // prevent creating duplicate profiles
        if (ApplicantProfile::where('user_id', Auth::id())->exists()) {
            return redirect()->route('user.applicant.profiles.index')
                ->with('error', 'You already have a profile.');
        }

        return view('user.applicant.profiles.create');
    }

    public function store(Request $r)
    {
        $r->validate([
            'recruitment_status' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'national_id' => 'nullable|string|max:255',
            'gender' => 'required|string|max:20',
            'nationality' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'postal_code' => 'nullable|string|max:20',
            'linkedin_url' => 'nullable|url',
            'professional_summary' => 'nullable|string',
            'years_of_experience' => 'nullable|numeric',
        ]);

        ApplicantProfile::create(array_merge(
            $r->only([
                'recruitment_status','national_id','date_of_birth','gender',
                'nationality','address','postal_code','linkedin_url',
                'professional_summary','years_of_experience'
            ]),
            ['user_id' => Auth::id()]
        ));

        return redirect()->route('user.applicant.profiles.index')
            ->with('success', 'Profile created.');
    }

    public function edit(ApplicantProfile $profile)
    {
        abort_if($profile->user_id !== Auth::id(), 403);
        return view('user.applicant.profiles.edit', compact('profile'));
    }

    public function update(Request $r, ApplicantProfile $profile)
    {
        abort_if($profile->user_id !== Auth::id(), 403);

        $r->validate([
            'recruitment_status' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'national_id' => 'nullable|string|max:255',
            'gender' => 'required|string|max:20',
            'nationality' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'postal_code' => 'nullable|string|max:20',
            'linkedin_url' => 'nullable|url',
            'professional_summary' => 'nullable|string',
            'years_of_experience' => 'nullable|numeric',
        ]);

        $profile->update($r->only([
            'recruitment_status','national_id','date_of_birth','gender',
            'nationality','address','postal_code','linkedin_url',
            'professional_summary','years_of_experience'
        ]));

        return redirect()->route('user.applicant.profiles.index')
            ->with('success', 'Profile updated.');
    }

    public function destroy(ApplicantProfile $profile)
    {
        abort_if($profile->user_id !== Auth::id(), 403);
        $profile->delete();

        return back()->with('success', 'Profile deleted.');
    }
}
