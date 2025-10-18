<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\JobApplication;
use App\Models\ApplicantProfile;
use App\Models\Education;
use App\Models\Experience;
use App\Models\ApplicantCertification;
use App\Models\VoluntaryDisclosure;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InterviewMail;
use App\Mail\ShortlistedMail;
use App\Mail\RejectedMail;
use App\Mail\JobOfferMail;
use Illuminate\Support\Collection;


class WebJobApplicationController extends Controller
{

    public function index()
    {
        $jobs = JobPost::withCount('applications')->latest()->get();
        return view('admin.web.applications.index', compact('jobs'));
    }

    // List applicants for a specific job
    public function applicants(JobPost $job)
    {
        $applications = JobApplication::with(['user', 'user.profile'])
            ->where('job_post_id', $job->id)
            ->get();

        return view('admin.web.applications.applicants', compact('job', 'applications'));
    }

    // View individual applicant
 public function show($id)
    {
        $application = JobApplication::with('jobPost')->findOrFail($id);
        $user = $application->user;

        $profile = ApplicantProfile::where('user_id', $user->id)->first();
        $certifications = ApplicantCertification::where('user_id', $user->id)->get();
        $experiences = Experience::where('user_id', $user->id)->get();
        $educations = Education::where('user_id', $user->id)->get();
        $disclosure = VoluntaryDisclosure::where('user_id', $user->id)->first();

        return view('admin.web.applications.show', compact(
            'application',
            'user',
            'profile',
            'certifications',
            'experiences',
            'educations',
            'disclosure'
        ));
    }

public function updateStatus(Request $request, JobApplication $application)
{
    $request->validate([
        'status' => 'required|string',
    ]);

    try {
        $application->update(['status' => $request->status]);

        switch ($request->status) {
            case 'accepted':
                Mail::to($application->user->email)->send(new JobOfferMail($application));
                break;

            case 'interview':
                Mail::to($application->user->email)->send(new InterviewMail($application));
                break;

            case 'shortlisted':
                Mail::to($application->user->email)->send(new ShortlistedMail($application));
                break;

            case 'rejected':
                Mail::to($application->user->email)->send(new RejectedMail($application));
                break;
        }

        return back()->with('success', 'Application status updated successfully.');

    } catch (\Exception $e) {
        return back()->with('error', 'Failed to update application status. Please try again.');
    }
}

}
