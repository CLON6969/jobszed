<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\GuestSession;

class GuestSessionController extends Controller
{
    public function index()
    {
        $sessions = GuestSession::paginate(20);
        return view('seller.guestsessions.index', compact('sessions'));
    }
}
