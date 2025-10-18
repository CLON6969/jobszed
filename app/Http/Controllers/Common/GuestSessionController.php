<?php

namespace App\Http\Controllers;

use App\Models\GuestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestSessionController extends Controller
{
    public function index()
    {
        return response()->json(GuestSession::latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $session = GuestSession::create([
            'session_token' => Str::uuid(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'interactions' => [],
            'expires_at' => now()->addDays(3),
        ]);

        return response()->json($session, 201);
    }

    public function show(GuestSession $guestSession)
    {
        return response()->json($guestSession);
    }

    public function update(Request $request, GuestSession $guestSession)
    {
        $guestSession->update([
            'interactions' => $request->input('interactions', $guestSession->interactions),
        ]);

        return response()->json($guestSession);
    }

    public function destroy(GuestSession $guestSession)
    {
        $guestSession->delete();
        return response()->json(['message' => 'Guest session deleted']);
    }
}
