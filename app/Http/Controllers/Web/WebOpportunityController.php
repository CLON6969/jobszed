<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebOpportunityController extends Controller
{
    public function index()
    {
        $opportunities = Opportunity::latest()->get();
        return view('admin.web.opportunities.index', compact('opportunities'));
    }

    public function create()
    {
        return view('admin.web.opportunities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'overlay_intro' => 'nullable|string',
            'overlay_details' => 'nullable|string',
            'image' => 'required|image|max:22048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image')->store('opportunities', 'public');
            $validated['image'] = basename($file); // store only filename
        }

        Opportunity::create($validated);

        return redirect()->route('admin.web.opportunities.index')->with('success', 'Opportunity created successfully.');
    }

    public function edit(Opportunity $opportunity)
    {
        return view('admin.web.opportunities.edit', compact('opportunity'));
    }

    public function update(Request $request, Opportunity $opportunity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'overlay_intro' => 'nullable|string',
            'overlay_details' => 'nullable|string',
            'image' => 'nullable|image|max:22048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($opportunity->image && Storage::disk('public')->exists('opportunities/' . $opportunity->image)) {
                Storage::disk('public')->delete('opportunities/' . $opportunity->image);
            }

            $file = $request->file('image')->store('opportunities', 'public');
            $validated['image'] = basename($file); // only filename
        }

        $opportunity->update($validated);

        return redirect()->route('admin.web.opportunities.index')->with('success', 'Opportunity updated successfully.');
    }

    public function destroy(Opportunity $opportunity)
    {
        // Delete associated file if exists
        if ($opportunity->image && Storage::disk('public')->exists('opportunities/' . $opportunity->image)) {
            Storage::disk('public')->delete('opportunities/' . $opportunity->image);
        }

        $opportunity->delete();

        return redirect()->route('admin.web.opportunities.index')->with('success', 'Opportunity deleted successfully.');
    }
}
