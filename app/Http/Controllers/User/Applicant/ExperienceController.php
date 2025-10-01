<?php
namespace App\Http\Controllers\User\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    public function index()
    {
        $items = Experience::where('user_id', Auth::id())->get();
        return view('user.applicant.experiences.index', compact('items'));
    }

    public function create()
    {
        return view('user.applicant.experiences.create');
    }

    public function store(Request $r)
    {
        $r->validate([
            'employer' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        Experience::create(array_merge($r->only(['employer','job_title','start_date','end_date']), ['user_id'=>Auth::id()]));
        return redirect()->route('user.applicant.experiences.index')->with('success','Experience added.');
    }

    public function edit(Experience $experience)
    {
        abort_if($experience->user_id !== Auth::id(),403);
        return view('user.applicant.experiences.edit', compact('experience'));
    }

    public function update(Request $r, Experience $experience)
    {
        abort_if($experience->user_id !== Auth::id(),403);
        $r->validate([
            'employer' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        $experience->update($r->only(['employer','job_title','start_date','end_date']));
        return redirect()->route('user.applicant.experiences.index')->with('success','Experience updated.');
    }

    public function destroy(Experience $experience)
    {
        abort_if($experience->user_id !== Auth::id(),403);
        $experience->delete();
        return back()->with('success','Experience deleted.');
    }
}
