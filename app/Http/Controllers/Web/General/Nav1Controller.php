<?php

namespace App\Http\Controllers\Web\General;

use App\Http\Controllers\Controller;
use App\Models\Nav1;
use Illuminate\Http\Request;

class Nav1Controller extends Controller
{
    public function index()
    {
        $navItems = Nav1::with('parent')->orderBy('id', 'asc')->get();
        return view('admin.web.general.nav1.index', compact('navItems'));
    }

    public function create()
    {
        $parents = Nav1::all();
        return view('admin.web.general.nav1.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:nav1,id',
        ]);

        Nav1::create($request->all());

        return redirect()->route('admin.web.general.nav1.index')
                         ->with('status', '✅ Navigation item created successfully!');
    }

    public function edit($id)
    {
        $navItem = Nav1::findOrFail($id);
        $parents = Nav1::where('id', '!=', $id)->get(); // prevent self as parent
        return view('admin.web.general.nav1.edit', compact('navItem', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:nav1,id',
        ]);

        $navItem = Nav1::findOrFail($id);
        $navItem->update($request->all());

        return redirect()->route('admin.web.general.nav1.index')
                         ->with('status', '✅ Navigation item updated successfully!');
    }

    public function destroy($id)
    {
        $navItem = Nav1::findOrFail($id);
        $navItem->delete();

        return redirect()->route('admin.web.general.nav1.index')
                         ->with('status', '🗑 Navigation item deleted successfully!');
    }
}
