<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestSession;

class GuestSessionController extends Controller
{
    public function index()
    {
        $sessions = GuestSession::paginate(20);
        return view('admin.guestsessions.index', compact('sessions'));
    }

    public function destroy(GuestSession $session)
    {
        $session->delete();
        return back()->with('success','Guest session deleted');
    }
}
