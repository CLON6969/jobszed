<?php

namespace App\Http\Controllers\User\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::where('user_id', Auth::id())->get();
        return view('user.applicant.educations.index', compact('educations'));
    }

    public function create()
    {
        return view('user.applicant.educations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
        ]);

        Education::create([
            'user_id' => Auth::id(),
            'level' => $request->level,
            'field_of_study' => $request->field_of_study,
        ]);

        return redirect()->route('user.applicant.educations.index')->with('success', 'Education added.');
    }

    public function edit(Education $education)
    {
        abort_if($education->user_id !== Auth::id(), 403);
        return view('user.applicant.educations.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        abort_if($education->user_id !== Auth::id(), 403);

        $request->validate([
            'level' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
        ]);

        $education->update($request->only(['level', 'field_of_study']));

        return redirect()->route('user.applicant.educations.index')->with('success', 'Education updated.');
    }

    public function destroy(Education $education)
    {
        abort_if($education->user_id !== Auth::id(), 403);
        $education->delete();
        return back()->with('success', 'Education deleted.');
    }
}
