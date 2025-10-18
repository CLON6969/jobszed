<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AboutTable;
use Illuminate\Http\Request;

class WebAboutTableController extends Controller
{
    public function index()
    {
        $records = AboutTable::latest()->get();
        return view('admin.web.about.table.index', compact('records'));
    }

    public function create()
    {
        return view('admin.web.about.table.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'picture' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'title1' => 'required|string|max:255',
            'title1_content' => 'nullable|string',
            'title1_small_text' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['title1', 'title1_content', 'title1_small_text']);

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('uploads/pics', 'public');
            $data['picture'] = basename($path);
        }

        AboutTable::create($data);

        return redirect()->route('admin.web.about.table.index')->with('success', 'About item created successfully.');
    }

    public function edit(AboutTable $table)
    {
        return view('admin.web.about.table.edit', compact('table'));
    }

    public function update(Request $request, AboutTable $table)
    {
        $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'title1' => 'required|string|max:255',
            'title1_content' => 'nullable|string',
            'title1_small_text' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['title1', 'title1_content', 'title1_small_text']);

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('uploads/pics', 'public');
            $data['picture'] = basename($path);
        }

        $table->update($data);

        return redirect()->route('admin.web.about.table.index')->with('success', 'About item updated successfully.');
    }

    public function destroy(AboutTable $table)
    {
        $table->delete();
        return back()->with('success', 'About item deleted successfully.');
    }
}
