<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureModuleAccess
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $role = $request->user()?->role;

        if (in_array($role, ['super_admin', 'admin'], true)) {
            return $next($request);
        }

        if ($role === 'viewer' && $module !== 'settings' && in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'], true)) {
            return $next($request);
        }

        $permissions = [
            'editor' => ['content'],
            'hr' => ['hr'],
            'sales' => ['sales'],
        ];

        abort_unless(in_array($module, $permissions[$role] ?? [], true), 403, 'Your role does not have access to this module.');

        return $next($request);
    }
}
