<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(match ($user->role_id) {
                1 => route('admin.dashboard'),
                2 => route('staff.dashboard'),
                3 => route('Seller.dashboard'),
                4 => route('user.Customer.dashboard'),
                default => '/',
            } . '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended(match ($user->role_id) {
            1 => route('admin.dashboard'),
            2 => route('staff.dashboard'),
            3 => route('Seller.dashboard'),
            4 => route('user.Customer.dashboard'),
            default => '/',
        } . '?verified=1');
    }
}
