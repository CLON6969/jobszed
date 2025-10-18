<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Social;
use App\Models\Opportunity;

class OpportunityController extends Controller
{



public function index()
{
    $opportunities = Opportunity::all();
    return view('web.opportunities.index', compact('opportunities'));
}

}
