<?php

namespace App\Http\Controllers\Web\General;

use App\Http\Controllers\Controller;
use App\Models\Partners;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    public function index()
    {
        $partners = Partners::orderBy('sort_order')->get();
        return view('admin.web.general.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.web.general.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'name_url' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        Partners::create($request->only(['icon', 'name', 'name_url', 'sort_order', 'is_active']));

        return redirect()->route('admin.web.general.partners.index')->with('success', 'Partner created successfully.');
    }

    public function edit(Partners $partner)
    {
        return view('admin.web.general.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partners $partner)
    {
        $request->validate([
            'icon' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'name_url' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $partner->update($request->only(['icon', 'name', 'name_url', 'sort_order', 'is_active']));

        return redirect()->route('admin.web.general.partners.index')->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partners $partner)
    {
        $partner->delete();
        return back()->with('success', 'Partner deleted successfully.');
    }
}
