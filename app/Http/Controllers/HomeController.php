<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\HomeTable1;
use App\Models\User;
use App\Models\Opportunity;


class HomeController extends Controller
{

public function index()
{
    // Existing
    $home = home::first();
    $home_table1 = Hometable1::all();
    $opportunities = Opportunity::all();
    

    $totalUsers = User::count();
    $totalStaff = User::where('role_id', 1)->count();
    $totalInstitutions = User::where('user_type', 'institution')->count();





    return view('welcome', compact(
        'home', 'home_table1',
        'totalUsers', 'totalStaff', 'totalInstitutions', 'opportunities'
    ));
}

}
