<?php

namespace App\Http\Controllers\User\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicantLocation;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

class ApplicantLocationController extends Controller
{
    public function index()
    {
        $items = ApplicantLocation::where('user_id', Auth::id())->with('location')->get();
        return view('user.applicant.locations.index', compact('items'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('user.applicant.locations.create', compact('locations'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'location_id' => 'nullable|integer|exists:locations,id',
            'new_province' => 'nullable|string|max:255',
            'new_city' => 'nullable|string|max:255',
        ]);

        if ($r->filled(['new_province', 'new_city'])) {
            $location = Location::create([
                'province' => $r->new_province,
                'city' => $r->new_city,
            ]);
            $locationId = $location->id;
        } elseif ($r->filled('location_id')) {
            $locationId = $r->location_id;
        } else {
            return back()->withErrors(['Please select or enter a location.']);
        }

        ApplicantLocation::create([
            'user_id' => Auth::id(),
            'location_id' => $locationId
        ]);

        return redirect()->route('user.applicant.locations.index')->with('success', 'Location added.');
    }

    public function edit(ApplicantLocation $location)
    {
        abort_if($location->user_id !== Auth::id(), 403);
        $locations = Location::all();
        return view('user.applicant.locations.edit', compact('location', 'locations'));
    }

    public function update(Request $r, ApplicantLocation $location)
    {
        abort_if($location->user_id !== Auth::id(), 403);

        $r->validate([
            'location_id' => 'nullable|integer|exists:locations,id',
            'new_province' => 'nullable|string|max:255',
            'new_city' => 'nullable|string|max:255',
        ]);

        if ($r->filled(['new_province', 'new_city'])) {
            $newLocation = Location::create([
                'province' => $r->new_province,
                'city' => $r->new_city,
            ]);
            $location->update(['location_id' => $newLocation->id]);
        } elseif ($r->filled('location_id')) {
            $location->update(['location_id' => $r->location_id]);
        } else {
            return back()->withErrors(['Please select or enter a location.']);
        }

        return redirect()->route('user.applicant.locations.index')->with('success', 'Location updated.');
    }

    public function destroy(ApplicantLocation $location)
    {
        abort_if($location->user_id !== Auth::id(), 403);
        $location->delete();
        return back()->with('success', 'Location deleted.');
    }
}
