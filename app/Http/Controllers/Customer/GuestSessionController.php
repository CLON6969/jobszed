<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\GuestSession;
use Illuminate\Http\Request;

class GuestSessionController extends Controller
{
    public function index()
    {
        $sessions = GuestSession::latest()->paginate(20);
        return view('Customer.guest_sessions.index', compact('sessions'));
    }

    public function show(GuestSession $guestSession)
    {
        return view('Customer.guest_sessions.show', compact('guestSession'));
    }
}
