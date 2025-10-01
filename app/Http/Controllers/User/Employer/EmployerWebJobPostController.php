<?php

namespace App\Http\Controllers\User\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\JobSkill;
use App\Models\JobExperience;
use App\Models\JobQualification;
use App\Models\JobQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmployerWebJobPostController extends Controller
{
    // List only non-expired job posts by this employer
    public function index()
    {
        $jobs = JobPost::with(['skills', 'experiences', 'qualifications', 'questions'])
            ->where('posted_by', Auth::id())
            ->whereDate('application_deadline', '>=', Carbon::today())
            ->latest()
            ->get();

        return view('user.employer.web.job.index', compact('jobs'));
    }

    // List all jobs, including expired ones, for employer dashboard
    public function allPosts(Request $request)
    {
        $query = JobPost::with(['skills', 'experiences', 'qualifications', 'questions'])
            ->where('posted_by', Auth::id());

        // Apply filters
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }
        if ($request->filled('deadline_from')) {
            $query->whereDate('application_deadline', '>=', $request->deadline_from);
        }
        if ($request->filled('deadline_to')) {
            $query->whereDate('application_deadline', '<=', $request->deadline_to);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        // For filter dropdowns
        $departments = JobPost::select('department')->distinct()->pluck('department');
        $employmentTypes = JobPost::select('employment_type')->distinct()->pluck('employment_type');

        return view('user.employer.web.job.all_posts', compact('posts', 'departments', 'employmentTypes'));
    }

    public function create()
    {
        return view('user.employer.web.job.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateJob($request);

        $validated['posted_by'] = Auth::id();
        $validated['status'] = Carbon::parse($validated['application_deadline'])->isPast() ? 'closed' : 'open';

        DB::transaction(function () use ($validated) {
            $job = JobPost::create($validated);
            $this->syncRelations($job, $validated);
        });

        return redirect()->route('user.employer.web.job.index')
            ->with('success', 'Job post created successfully.');
    }

    public function edit(JobPost $job)
    {
        $this->authorizeOwner($job);
        $job->load(['skills', 'experiences', 'qualifications', 'questions']);
        return view('user.employer.web.job.edit', compact('job'));
    }

    public function update(Request $request, JobPost $job)
    {
        $this->authorizeOwner($job);

        $validated = $this->validateJob($request, $job->id);

        $validated['status'] = Carbon::parse($validated['application_deadline'])->isPast() ? 'closed' : 'open';

        DB::transaction(function () use ($job, $validated) {
            $job->update($validated);
            $this->syncRelations($job, $validated);
        });

        return redirect()->route('user.employer.web.job.index')
            ->with('success', 'Job post updated successfully.');
    }

    public function destroy(JobPost $job)
    {
        $this->authorizeOwner($job);
        $job->delete();
        return back()->with('success', 'Job post deleted successfully.');
    }

    private function authorizeOwner(JobPost $job)
    {
        if ($job->posted_by !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }

    private function validateJob(Request $request, $jobId = null)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($jobId) {
                    $exists = JobPost::where('slug', $value)
                        ->when($jobId, fn($q) => $q->where('id', '!=', $jobId))
                        ->where('posted_by', Auth::id())
                        ->exists();
                    if ($exists) {
                        $fail('The slug has already been taken for your account.');
                    }
                }
            ],
            'description' => 'required|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
            'employment_type' => 'required|string',
            'work_setup' => 'required|string',
            'location' => 'required|string',
            'country' => 'required|string',
            'department' => 'required|string',
            'level' => 'nullable|string',
            'salary_range' => 'nullable|string',
            'application_deadline' => 'required|date',
            'skills' => 'nullable|array',
            'experiences' => 'nullable|array',
            'qualifications' => 'nullable|array',
            'questions' => 'nullable|array',
        ]);
    }

    private function syncRelations(JobPost $job, array $validated)
    {
        $this->syncRelation($job->skills(), $validated['skills'] ?? []);
        $this->syncRelation($job->experiences(), $validated['experiences'] ?? []);
        $this->syncRelation($job->qualifications(), $validated['qualifications'] ?? []);
        $this->syncRelation($job->questions(), $validated['questions'] ?? []);
    }

    private function syncRelation($relation, array $data)
    {
        $existingIds = $relation->pluck('id')->toArray();
        $newIds = [];

        foreach ($data as $item) {
            if (!empty($item['id']) && in_array($item['id'], $existingIds)) {
                $model = $relation->find($item['id']);
                $model->update($item);
            } else {
                $model = $relation->create($item);
            }
            $newIds[] = $model->id;
        }

        $relation->whereNotIn('id', $newIds)->delete();
    }
}
