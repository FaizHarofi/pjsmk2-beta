<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->hasAnyRole(['superadmin', 'admin', 'editor'])) {
            abort(403);
        }

        return $next($request);
    }
}
