<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicantCertification;
use Illuminate\Support\Facades\Auth;

class CertificationController extends Controller
{
    public function index()
    {
        $certs = ApplicantCertification::where('user_id', Auth::id())->get();
        return view('applicant.certifications.index', compact('certs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'certification_type' => 'required',
            'issuing_organization' => 'required',
            'level' => 'required',
            'status' => 'required|in:obtained,in_progress',
        ]);

        ApplicantCertification::create([
            'user_id' => Auth::id(),
            ...$request->all()
        ]);

        return back()->with('success', 'Certification added.');
    }
}

