<?php

namespace App\Http\Controllers\Web\General;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function index()
    {
        $logo = Logo::latest()->get();
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
            'home_url' => 'nullable|url|max:255', 
        ]);

        $data = $request->only(['title', 'home_url']);

        // Handle picture
        if ($request->hasFile('picture')) {
            try {
                $file = $request->file('picture')->store('uploads/logo', 'public');
                $data['picture'] = basename($file);
            } catch (\Exception $e) {
                return back()->withErrors(['picture' => 'Failed to upload picture: ' . $e->getMessage()]);
            }
        }

        // Handle picture2
        if ($request->hasFile('picture2')) {
            try {
                $file2 = $request->file('picture2')->store('uploads/logo', 'public');
                $data['picture2'] = basename($file2);
            } catch (\Exception $e) {
                return back()->withErrors(['picture2' => 'Failed to upload picture2: ' . $e->getMessage()]);
            }
        }

        // Handle background_picture
        if ($request->hasFile('background_picture')) {
            try {
                $file3 = $request->file('background_picture')->store('uploads/logo', 'public');
                $data['background_picture'] = basename($file3);
            } catch (\Exception $e) {
                return back()->withErrors(['background_picture' => 'Failed to upload background picture: ' . $e->getMessage()]);
            }
        }

        Logo::create($data);

        return redirect()->route('admin.web.general.logo.index')->with('success', 'Logo created successfully.');
    }

    public function edit(Logo $logo)
    {
        return view('admin.web.general.logo.edit', compact('logo'));
    }

    public function update(Request $request, Logo $logo)
    {
        $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'picture2' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'background_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:11048',
            'title' => 'required|string|max:255',
            'home_url' => 'nullable|url|max:255', 
        ]);

        $data = $request->only(['title', 'home_url']);

        // Handle picture
        if ($request->hasFile('picture')) {
            if ($logo->picture && Storage::disk('public')->exists('uploads/logo/' . $logo->picture)) {
                Storage::disk('public')->delete('uploads/logo/' . $logo->picture);
            }
            try {
                $file = $request->file('picture')->store('uploads/logo', 'public');
                $data['picture'] = basename($file);
            } catch (\Exception $e) {
                return back()->withErrors(['picture' => 'Failed to upload picture: ' . $e->getMessage()]);
            }
        }

        // Handle picture2
        if ($request->hasFile('picture2')) {
            if ($logo->picture2 && Storage::disk('public')->exists('uploads/logo/' . $logo->picture2)) {
                Storage::disk('public')->delete('uploads/logo/' . $logo->picture2);
            }
            try {
                $file2 = $request->file('picture2')->store('uploads/logo', 'public');
                $data['picture2'] = basename($file2);
            } catch (\Exception $e) {
                return back()->withErrors(['picture2' => 'Failed to upload picture2: ' . $e->getMessage()]);
            }
        }

        // Handle background_picture
        if ($request->hasFile('background_picture')) {
            if ($logo->background_picture && Storage::disk('public')->exists('uploads/logo/' . $logo->background_picture)) {
                Storage::disk('public')->delete('uploads/logo/' . $logo->background_picture);
            }
            try {
                $file3 = $request->file('background_picture')->store('uploads/logo', 'public');
                $data['background_picture'] = basename($file3);
            } catch (\Exception $e) {
                return back()->withErrors(['background_picture' => 'Failed to upload background picture: ' . $e->getMessage()]);
            }
        }

        $logo->update($data);

        return redirect()->route('admin.web.general.logo.index')->with('success', 'Logo updated successfully.');
    }

    public function destroy(Logo $logo)
    {
        // Delete all associated files
        foreach (['picture', 'picture2', 'background_picture'] as $field) {
            if ($logo->$field && Storage::disk('public')->exists('uploads/logo/' . $logo->$field)) {
                Storage::disk('public')->delete('uploads/logo/' . $logo->$field);
            }
        }

        $logo->delete();

        return back()->with('success', 'Logo deleted successfully.');
    }
}
