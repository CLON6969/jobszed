<?php

namespace App\Http\Controllers\User\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\JobApplication;
use App\Models\ShortlistedDetail;
use App\Models\RejectedDetail;
use App\Models\InterviewDetail;
use App\Models\AcceptedDetail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmployerOverviewController extends Controller
{
    public function index()
    {
        $employerId = Auth::id();

        // Jobs
        $jobs = JobPost::where('posted_by', $employerId)->get();
        $activeJobs = $jobs->where('application_deadline', '>=', Carbon::today());
        $closedJobs = $jobs->where('application_deadline', '<', Carbon::today());

        // Applications
        $applications = JobApplication::whereIn('job_post_id', $jobs->pluck('id'))->get();
        $statusCounts = $applications->groupBy('status')->map->count();

        // Skills / Job Types
        $jobTypes = $jobs->groupBy('employment_type')->map->count();

        // Hiring Efficiency
        $acceptedCount = AcceptedDetail::whereIn('job_post_id', $jobs->pluck('id'))->count();
        $rejectedCount = RejectedDetail::whereIn('job_post_id', $jobs->pluck('id'))->count();
        $interviewCount = InterviewDetail::whereIn('job_post_id', $jobs->pluck('id'))->count();
        $shortlistedCount = ShortlistedDetail::whereIn('job_post_id', $jobs->pluck('id'))->count();

        // Time-based trends (Jobs Posted Per Month)
        $jobsPerMonth = $jobs->groupBy(function ($job) {
            return Carbon::parse($job->created_at)->format('M Y');
        })->map->count();

        // Job-level analytics
        $applicationsPerJob = $jobs->mapWithKeys(function($job) use ($applications) {
            $jobApps = $applications->where('job_post_id', $job->id);
            return [
                $job->title => [
                    'total' => $jobApps->count(),
                    'status' => $jobApps->groupBy('status')->map->count()
                ]
            ];
        });

        return view('user.employer.dashboard.overview', compact(
            'jobs', 'activeJobs', 'closedJobs', 'applications',
            'statusCounts', 'jobTypes',
            'acceptedCount', 'rejectedCount', 'interviewCount', 'shortlistedCount',
            'jobsPerMonth', 'applicationsPerJob'
        ));
    }
}
