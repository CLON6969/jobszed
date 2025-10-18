<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\JobSkill;
use App\Models\JobExperience;
use App\Models\JobQualification;
use App\Models\JobQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WebJobPostController extends Controller
{
    // List only non-expired job posts
    public function index()
    {
        $jobs = JobPost::with(['skills', 'experiences', 'qualifications', 'questions'])
            ->whereDate('application_deadline', '>=', Carbon::today())
            ->latest()
            ->get();

        return view('admin.web.job.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.web.job.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:job_posts,slug',
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
            'posted_by' => 'required|exists:users,id',

            'skills' => 'nullable|array',
            'skills.*.name' => 'required|string|max:255',
            'skills.*.type' => 'nullable|string',
            'skills.*.is_required' => 'nullable|boolean',

            'experiences' => 'nullable|array',
            'experiences.*.title' => 'required|string|max:255',
            'experiences.*.description' => 'required|string',
            'experiences.*.is_required' => 'nullable|boolean',

            'qualifications' => 'nullable|array',
            'qualifications.*.title' => 'required|string|max:255',
            'qualifications.*.level' => 'nullable|string',
            'qualifications.*.is_required' => 'nullable|boolean',

            'questions' => 'nullable|array',
            'questions.*.question' => 'required|string',
            'questions.*.required' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated) {
            // Determine job status based on deadline
            $validated['status'] = Carbon::parse($validated['application_deadline'])->isPast() ? 'closed' : 'open';

            $job = JobPost::create($validated);

            foreach ($validated['skills'] ?? [] as $skill) {
                $job->skills()->create($skill);
            }

            foreach ($validated['experiences'] ?? [] as $exp) {
                $job->experiences()->create($exp);
            }

            foreach ($validated['qualifications'] ?? [] as $qual) {
                $job->qualifications()->create($qual);
            }

            foreach ($validated['questions'] ?? [] as $question) {
                $job->questions()->create($question);
            }
        });

        return redirect()->route('admin.web.job.index')->with('success', 'Job post created successfully.');
    }

    public function edit(JobPost $job)
    {
        $job->load(['skills', 'experiences', 'qualifications', 'questions']);
        return view('admin.web.job.edit', compact('job'));
    }

    public function update(Request $request, JobPost $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:job_posts,slug,' . $job->id,
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
            'posted_by' => 'required|exists:users,id',

            'skills' => 'nullable|array',
            'skills.*.id' => 'nullable|exists:job_skills,id',
            'skills.*.name' => 'required|string|max:255',
            'skills.*.type' => 'nullable|string',
            'skills.*.is_required' => 'nullable|boolean',

            'experiences' => 'nullable|array',
            'experiences.*.id' => 'nullable|exists:job_experiences,id',
            'experiences.*.title' => 'required|string|max:255',
            'experiences.*.description' => 'required|string',
            'experiences.*.is_required' => 'nullable|boolean',

            'qualifications' => 'nullable|array',
            'qualifications.*.id' => 'nullable|exists:job_qualifications,id',
            'qualifications.*.title' => 'required|string|max:255',
            'qualifications.*.level' => 'nullable|string',
            'qualifications.*.is_required' => 'nullable|boolean',

            'questions' => 'nullable|array',
            'questions.*.id' => 'nullable|exists:job_questions,id',
            'questions.*.question' => 'required|string',
            'questions.*.required' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated, $job) {
            // Update status automatically based on deadline
            $validated['status'] = Carbon::parse($validated['application_deadline'])->isPast() ? 'closed' : 'open';

            $job->update($validated);

            // Sync Skills
            $existingSkills = $job->skills()->pluck('id')->toArray();
            $newSkillIds = [];

            foreach ($validated['skills'] ?? [] as $skillData) {
                if (!empty($skillData['id']) && in_array($skillData['id'], $existingSkills)) {
                    $skill = JobSkill::find($skillData['id']);
                    $skill->update($skillData);
                } else {
                    $skill = $job->skills()->create($skillData);
                }
                $newSkillIds[] = $skill->id;
            }
            $job->skills()->whereNotIn('id', $newSkillIds)->delete();

            // Sync Experiences
            $existingExperiences = $job->experiences()->pluck('id')->toArray();
            $newExperienceIds = [];

            foreach ($validated['experiences'] ?? [] as $expData) {
                if (!empty($expData['id']) && in_array($expData['id'], $existingExperiences)) {
                    $experience = JobExperience::find($expData['id']);
                    $experience->update($expData);
                } else {
                    $experience = $job->experiences()->create($expData);
                }
                $newExperienceIds[] = $experience->id;
            }
            $job->experiences()->whereNotIn('id', $newExperienceIds)->delete();

            // Sync Qualifications
            $existingQualifications = $job->qualifications()->pluck('id')->toArray();
            $newQualificationIds = [];

            foreach ($validated['qualifications'] ?? [] as $qualData) {
                if (!empty($qualData['id']) && in_array($qualData['id'], $existingQualifications)) {
                    $qualification = JobQualification::find($qualData['id']);
                    $qualification->update($qualData);
                } else {
                    $qualification = $job->qualifications()->create($qualData);
                }
                $newQualificationIds[] = $qualification->id;
            }
            $job->qualifications()->whereNotIn('id', $newQualificationIds)->delete();

            // Sync Questions
            $existingQuestions = $job->questions()->pluck('id')->toArray();
            $newQuestionIds = [];

            foreach ($validated['questions'] ?? [] as $qData) {
                if (!empty($qData['id']) && in_array($qData['id'], $existingQuestions)) {
                    $question = JobQuestion::find($qData['id']);
                    $question->update($qData);
                } else {
                    $question = $job->questions()->create($qData);
                }
                $newQuestionIds[] = $question->id;
            }
            $job->questions()->whereNotIn('id', $newQuestionIds)->delete();
        });

        return redirect()->route('admin.web.job.index')->with('success', 'Job post updated successfully.');
    }

    public function allPosts(Request $request)
{
    $query = JobPost::with(['skills', 'experiences', 'qualifications', 'questions']);

    // Filtering by title (partial match)
    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    // Filter by department exact match
    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }

    // Filter by employment_type exact match
    if ($request->filled('employment_type')) {
        $query->where('employment_type', $request->employment_type);
    }

    // Filter by application_deadline range
    if ($request->filled('deadline_from')) {
        $query->whereDate('application_deadline', '>=', $request->deadline_from);
    }
    if ($request->filled('deadline_to')) {
        $query->whereDate('application_deadline', '<=', $request->deadline_to);
    }

    // Order by deadline descending by default
    $posts = $query->orderBy('application_deadline', 'desc')->paginate(10);

    // Get filter dropdown options (distinct values)
    $departments = JobPost::select('department')->distinct()->pluck('department');
    $employmentTypes = JobPost::select('employment_type')->distinct()->pluck('employment_type');

    return view('admin.web.job.all_posts', compact('posts', 'departments', 'employmentTypes'));
}


    public function destroy(JobPost $job)
    {
        $job->delete();
        return back()->with('success', 'Job post deleted successfully.');
    }
}
