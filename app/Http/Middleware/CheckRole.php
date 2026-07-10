<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userRole = $request->user()->role->name ?? null;

        if (!in_array($userRole, $roles)) {
            abort(403, "You do not have access to this section.");
        }

        return $next($request);
    }
}
