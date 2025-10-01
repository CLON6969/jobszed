<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\AboutTable;
use App\Models\CompanyStatement;
use App\Models\User;
use App\Models\SolutionTable;
use App\Models\services_table;
use App\Models\Package;

class AboutController extends Controller
{

public function index()
{
    // Existing
    $about = About::first();
    $about_table = AboutTable::all();
    $statements = CompanyStatement::all();

    $totalUsers = User::count();
    $totalStaff = User::where('role_id', 1)->count();
    $totalInstitutions = User::where('user_type', 'institution')->count();

   // $solutions = SolutionTable::all();
   // $services = services_table::all();
   // $packages = Package::with('plans')->get();

    //  Select top 4 team members by job_title or role
    $team = User::whereIn('job_title', [
        'Chief Executive Officer',
        'Chief Technology Officer',
        'Lead UX Designer',
        'Product Manager'
    ])
    ->take(4)
    ->get();

    return view('about', compact(
        'about', 'about_table', 'statements',
        'totalUsers', 'totalStaff', 'totalInstitutions',
        //'solutions', 'services', 'packages',
        'team' 
    ));
}

}
