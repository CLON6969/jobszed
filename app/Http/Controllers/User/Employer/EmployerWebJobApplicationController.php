<?php

namespace App\Http\Controllers\User\employer;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\JobApplication;
use App\Models\ApplicantProfile;
use App\Models\Education;
use App\Models\Experience;
use App\Models\ApplicantCertification;
use App\Models\VoluntaryDisclosure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InterviewMail;
use App\Mail\ShortlistedMail;
use App\Mail\RejectedMail;
use App\Mail\JobOfferMail;

class EmployerWebJobApplicationController extends Controller
{
    /**
     * List all job posts for the logged-in employer
     */
    public function index()
    {
        $employerId = auth()->id();

        $jobs = JobPost::withCount('applications')
            ->where('posted_by', $employerId) // ✅ only employer's own jobs
            ->latest()
            ->get();

        return view('user.employer.web.applications.index', compact('jobs'));
    }

    /**
     * List applicants for a specific job
     */
    public function applicants(JobPost $job)
    {
        $this->authorizeJob($job);

        $applications = JobApplication::with(['user', 'user.profile'])
            ->where('job_post_id', $job->id)
            ->get();

        return view('user.employer.web.applications.applicants', compact('job', 'applications'));
    }

    /**
     * View individual applicant
     */
    public function show($id)
    {
        $application = JobApplication::with('jobPost')->findOrFail($id);

        $this->authorizeJob($application->jobPost);

        $user = $application->user; // ✅ correct relationship
        $profile = ApplicantProfile::where('user_id', $user->id)->first();
        $certifications = ApplicantCertification::where('user_id', $user->id)->get();
        $experiences = Experience::where('user_id', $user->id)->get();
        $educations = Education::where('user_id', $user->id)->get();
        $disclosure = VoluntaryDisclosure::where('user_id', $user->id)->first();

        return view('user.employer.web.applications.show', compact(
            'application',
            'user',
            'profile',
            'certifications',
            'experiences',
            'educations',
            'disclosure'
        ));
    }

    /**
     * Update the status of an application
     */
    public function updateStatus(Request $request, JobApplication $application)
    {
        $this->authorizeJob($application->jobPost);

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

    /**
     * Helper to ensure employer can only access their own job posts
     */
    protected function authorizeJob(JobPost $job)
    {
        if ($job->posted_by !== auth()->id()) {
            abort(403, 'Unauthorized action. You can only access your own job posts.');
        }
    }
}
