<?php

namespace App\Http\Controllers\User\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Job_page;
use App\Models\Logo;
use Carbon\Carbon;

class UserJobsController extends Controller
{
    /**
     * Display a list of jobs (with optional filters)
     */
    public function index(Request $request)
    {
        $today = Carbon::today();

        // Close expired jobs automatically
        JobPost::where('status', 'open')
            ->whereDate('application_deadline', '<', $today)
            ->update(['status' => 'closed']);

        $query = JobPost::where('status', 'open')
            ->whereDate('application_deadline', '>=', $today);

        // Optional filters
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('department', $request->category);
        }
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        $jobs = $query->latest()->paginate(12)->withQueryString();
        $job_page = Job_page::first();
        $logo = Logo::first();

        return view('user.applicant.jobs.index', compact('jobs', 'job_page', 'logo'));
    }

    /**
     * Show a single job
     */
    public function show($slug)
    {
        $today = Carbon::today();

        $job = JobPost::with(['skills', 'experiences', 'qualifications', 'questions'])
            ->where('slug', $slug)
            ->where('status', 'open')
            ->whereDate('application_deadline', '>=', $today)
            ->firstOrFail();

        $logo = Logo::first();

        return view('user.applicant.jobs.show', compact('job', 'logo'));
    }
}
