<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PagePermissionMiddleware
{
    public function handle(Request $request, Closure $next, $page, $action)
    {
        $user = auth()->user();

        if ($user && $user->hasPagePermission($page, $action)) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
