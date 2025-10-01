<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPost;
use App\Models\JobApplication;

class ApplicationController extends Controller
{
    // Show the job application form
    public function create($slug)
    {
        $job = JobPost::with(['skills', 'experiences', 'qualifications', 'questions'])
                      ->where('slug', $slug)
                      ->firstOrFail();

        $alreadyApplied = JobApplication::where('user_id', Auth::id())
            ->where('job_post_id', $job->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('jobs.show', $slug)
                ->with('error', 'You have already applied for this job.');
        }

        return view('applications.create', compact('job'));
    }

    // Handle job application submission
   public function store(Request $request, $slug)
{
    $job = JobPost::with('questions')->where('slug', $slug)->firstOrFail();

    $rules = [
        'cover_letter' => 'nullable|string|max:5000',
        'cv' => 'required|mimes:pdf,doc,docx|max:2048', // CV validation
    ];

    foreach ($job->questions as $q) {
        $rules["answers.{$q->id}"] = $q->required ? 'required|string' : 'nullable|string';
    }

    $request->validate($rules);

    $alreadyApplied = JobApplication::where('user_id', Auth::id())
        ->where('job_post_id', $job->id)
        ->exists();

    if ($alreadyApplied) {
        return redirect()->route('jobs.show', $slug)
            ->with('error', 'You have already applied for this job.');
    }

    // Upload CV
    $cvPath = $request->file('cv')->store('cvs', 'public');

    JobApplication::create([
        'user_id' => Auth::id(),
        'job_post_id' => $job->id,
        'cover_letter' => $request->input('cover_letter'),
        'answers' => $request->input('answers'),
        'cv' => $cvPath,
        'status' => 'submitted',
        'submitted_at' => now(),
    ]);

    return redirect()->route('jobs.show', $slug)
        ->with('success', 'Your application has been submitted successfully.');
}

}
