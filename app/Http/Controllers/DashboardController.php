<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobApplication;
use App\Models\User;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard');
    }

    public function staff()
    {
        return view('staff.dashboard');
    }

    public function user()
    {
        return view('user.dashboard');
    }

        public function employer()
    {
        return view('user.employer.dashboard');
    }



public function jobUserSummary()
{
    // Count jobs by status
    $openJobs = JobPost::where('status', 'open')->count();
    $closedJobs = JobPost::where('status', 'closed')->count();

    // Applications count
    $totalApplications = JobApplication::count();
    $applicationsToday = JobApplication::whereDate('created_at', now()->toDateString())->count();

    // Users by role
    $applicants = User::where('role_id', 3)->count(); // applicants role_id = 3
    $staff = User::where('role_id', 2)->count();      // staff role_id = 2
    $totalUsers = User::count();

    // Shortlisted count — assuming you track it in JobApplication status
    $totalShortlisted = JobApplication::where('status', 'shortlisted')->count();

    // Latest 5 job posts with poster info
    $latestJobs = JobPost::latest()->take(5)->with('user')->get();

    // Job trends: count per month for last 6 months
    $jobTrends = JobPost::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    $jobTrendLabels = $jobTrends->pluck('month')->map(function ($m) {
        return Carbon::createFromFormat('Y-m', $m)->format('M Y');
    })->toArray();

    $jobTrendCounts = $jobTrends->pluck('count')->toArray();

    // Latest 50 users with their roles
    $users = User::with('role')->latest()->take(50)->get();

    return view('admin.job_user_summary.index', compact(
        'openJobs',
        'closedJobs',
        'totalApplications',
        'applicationsToday',
        'applicants',
        'staff',
        'totalUsers',
        'totalShortlisted',
        'latestJobs',
        'jobTrendLabels',
        'jobTrendCounts',
        'users'
    ));
}




    public function applicant()
    {
        $user = Auth::user();

        if (!$user->onboarding_complete) {
            return redirect()->route('onboarding.step1');
        }

        return view('user.applicant.dashboard');
    }
}
