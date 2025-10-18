<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Job_page;
use App\Models\Logo;
use Carbon\Carbon;

class JobController extends Controller
{
    /**
     * Show all open and non-expired jobs with optional filters.
     */
    public function index(Request $request)
    {
        $today = Carbon::today();

        // ✅ Close expired jobs automatically
        JobPost::where('status', 'open')
            ->whereDate('application_deadline', '<', $today)
            ->update(['status' => 'closed']);

        // ✅ Fetch only active, open, non-expired jobs
        $query = JobPost::query()
            ->where('status', 'open')
            ->whereDate('application_deadline', '>=', $today)
            ->with('user'); // 👈 include employer relation

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

        // ✅ Add "time ago" and fallback for employer profile picture
        $jobs->getCollection()->transform(function ($job) {
            $job->posted_time = $job->created_at->diffForHumans();
            $job->employer_name = $job->user->name ?? 'Unknown Employer';
            $job->employer_picture = $job->user->profile_picture 
                ? asset('public/storage/' . $job->user->profile_picture)
                : asset('public/uploads/pics/default.png');
            return $job;
        });

        $job_page = Job_page::first();
        $logo = Logo::first();

        return view('jobs.index', compact('jobs', 'job_page', 'logo'));
    }

    /**
     * Show job details (only if open and not expired).
     */
    public function show($slug)
    {
        $today = Carbon::today();

        $job = JobPost::with(['skills', 'experiences', 'qualifications', 'questions', 'user'])
            ->where('slug', $slug)
            ->where('status', 'open')
            ->whereDate('application_deadline', '>=', $today)
            ->firstOrFail();

        $job->posted_time = $job->created_at->diffForHumans();
        $job->employer_name = $job->user->name ?? 'Unknown Employer';
        $job->employer_picture = $job->user->profile_picture 
            ? asset('public/storage/' . $job->user->profile_picture)
            : asset('public/uploads/pics/default.png');

        $logo = Logo::first();

        return view('jobs.show', compact('job', 'logo'));
    }
}
