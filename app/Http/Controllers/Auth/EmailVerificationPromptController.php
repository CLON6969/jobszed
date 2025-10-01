<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(match ($user->role_id) {
                1 => route('admin.dashboard'),
                2 => route('staff.dashboard'),
                3 => route('user.employer.dashboard'),
                4 => route('user.applicant.dashboard'),
                default => '/',
            });
        }

        return view('auth.verify-email');
    }
}
