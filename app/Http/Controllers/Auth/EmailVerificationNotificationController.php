<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        // If already verified, redirect based on role
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(match ($user->role_id) {
                1 => route('admin.dashboard'),
                2 => route('staff.dashboard'),
                3 => route('user.employer.dashboard'),
                4 => route('user.applicant.dashboard'),
                default => '/',
            });
        }

        // Send the email
        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
