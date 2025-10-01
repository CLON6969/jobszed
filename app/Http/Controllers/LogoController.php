<?php

namespace App\Http\Controllers\Web\General;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    public function index()
    {
        $logo = logo::latest()->get();
        return view('admin.web.general.logo.index', compact('logo'));
    }

    public function create()
    {
        return view('admin.web.general.logo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'picture2' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'background_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:11048',
            'title' => 'required|string|max:255',
            'home_url'=> 'required|string|max:255',
        ]);

        $data = $request->only(['title']);

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('uploads/pics', 'public');
            $data['picture'] = basename($path);
        }

        if ($request->hasFile('picture2')) {
            $path2 = $request->file('picture2')->store('uploads/pics', 'public');
            $data['picture2'] = basename($path2);
        }

        if ($request->hasFile('background_picture')) {
            $path2 = $request->file('background_picture')->store('uploads/pics', 'public');
            $data['background_picture'] = basename($path2);
        }

        logo::create($data);

        return redirect()->route('admin.web.general.logo.index')->with('success', 'logo created successfully.');
    }

    public function edit(logo $logo)
    {
        return view('admin.web.general.logo.edit', compact('logo'));
    }

    public function update(Request $request, logo $logo)
    {
        $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'picture2' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'background_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:11048',
            'title' => 'required|string|max:255',
            'home_url'=> 'required|string|max:255',
        ]);

        $data = $request->only(['title']);

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('uploads/pics', 'public');
            $data['picture'] = basename($path);
        }

        if ($request->hasFile('picture2')) {
            $path2 = $request->file('picture2')->store('uploads/pics', 'public');
            $data['picture2'] = basename($path2);
        }

        if ($request->hasFile('background_picture')) {
            $path2 = $request->file('background_picture')->store('uploads/pics', 'public');
            $data['background_picture'] = basename($path2);
        }


        $logo->update($data);

        return redirect()->route('admin.web.general.logo.index')->with('success', 'logo updated successfully.');
    }

    public function destroy(logo $logo)
    {
        $logo->delete();
        return back()->with('success', 'logo deleted successfully.');
    }
}
