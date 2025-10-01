<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $roleName = optional($user->role)->name;

        switch ($roleName) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'staff':
                return redirect()->route('staff.dashboard');
            case 'user':
                return redirect()->route('user.dashboard');
            case 'applicant':
                return redirect()->route('user.applicant.dashboard');
            default:
                abort(403, 'Unauthorized role.');
        }
    }
}
