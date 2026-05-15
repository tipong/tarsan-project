<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! auth()->check()) {
            abort(403);
        }

        $userRole = auth()->user()->role;

        // Owner can access all admin routes
        if ($userRole === 'owner' && in_array('admin', $roles)) {
            return $next($request);
        }

        if (! in_array($userRole, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}

