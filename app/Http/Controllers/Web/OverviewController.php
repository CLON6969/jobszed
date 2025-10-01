<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicantProfile;
use App\Models\Education;
use App\Models\Experience;
use App\Models\ApplicantCertification;
use App\Models\VoluntaryDisclosure;


class OverviewController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $profile = ApplicantProfile::where('user_id', $user->id)->first();
        $educations = Education::where('user_id', $user->id)->get();
        $experiences = Experience::where('user_id', $user->id)->get();
        $certifications = ApplicantCertification::where('user_id', $user->id)->get();
        $disclosure = VoluntaryDisclosure::where('user_id', $user->id)->first();

        return view('user.applicant.overviews.index', compact(
            'user',
            'profile',
            'educations',
            'experiences',
            'certifications',
            'disclosure'
        ));
    }
}
