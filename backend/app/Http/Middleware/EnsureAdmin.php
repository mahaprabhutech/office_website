<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        abort_unless($user && $user->is_active, 403, 'This account is not active.');
        abort_unless(in_array($user->role, ['super_admin', 'admin', 'editor', 'hr', 'sales', 'viewer'], true), 403);

        return $next($request);
    }
}
