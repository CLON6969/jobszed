<?php
// app/Http/Middleware/EnsureUserIsApplicant.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApplicant
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->role_id == 4) {
            if (!$user->onboarding_complete && !$request->is('onboarding/*')) {
                return redirect()->route('onboarding.step1');
            }
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}


