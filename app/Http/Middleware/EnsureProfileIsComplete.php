<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * Redirect users who haven't completed their profiles
     * to the appropriate edit page based on their role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && ! $user->profile_completed) {
            // Determine the correct profile edit/update routes for the user's role
            $editRoute = match($user->role->name) {
                '1' => 'admin.profile.edit',
                '2' => 'staff.profile.edit',
                default => 'user.profile.edit',
            };

            $updateRoute = match($user->role->name) {
                '1' => 'admin.profile.update',
                '2' => 'staff.profile.update',
                default => 'user.profile.update',
            };

            // If they're not already on their edit or update route, redirect them
            if (! $request->routeIs($editRoute) && ! $request->routeIs($updateRoute)) {
                return redirect()->route($editRoute);
            }
        }

        return $next($request);
    }
}
