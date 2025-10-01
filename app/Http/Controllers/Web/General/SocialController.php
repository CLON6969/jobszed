<?php

namespace App\Http\Controllers\Web\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Social;

class SocialController extends Controller
{
    public function index()
    {
        $socials = Social::orderBy('sort_order')->get();
        return view('admin.web.general.socials.index', compact('socials'));
    }

    public function create()
    {
        return view('admin.web.general.socials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string|max:255',
            'name_url' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        Social::create($request->only(['icon', 'name_url', 'sort_order', 'is_active']));

        return redirect()->route('admin.web.general.socials.index')->with('success', 'Social link created successfully.');
    }

    public function edit(Social $social)
    {
        return view('admin.web.general.socials.edit', compact('social'));
    }

    public function update(Request $request, Social $social)
    {
        $request->validate([
            'icon' => 'required|string|max:255',
            'name_url' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $social->update($request->only(['icon', 'name_url', 'sort_order', 'is_active']));

        return redirect()->route('admin.web.general.socials.index')->with('success', 'Social link updated successfully.');
    }

    public function destroy(Social $social)
    {
        $social->delete();
        return back()->with('success', 'Social link deleted.');
    }
}
