<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = session('admin_user_id');

        if (!$userId || !Schema::hasTable('users')) {
            return redirect()->route('admin.login')
                ->with('error', 'Please sign in to continue.');
        }

        $query = DB::table('users')->where('id', $userId);

        if (Schema::hasColumn('users', 'role')) {
            $query->whereIn('role', ['admin', 'super_admin']);
        }

        if (Schema::hasColumn('users', 'status')) {
            $query->where('status', 'active');
        }

        $admin = $query->first();

        if (!$admin) {
            session()->forget(['admin_user_id', 'admin_user_name', 'admin_user_email', 'admin_user_role']);
            return redirect()->route('admin.login')
                ->with('error', 'Your administrator session is no longer valid.');
        }

        $request->attributes->set('adminUser', $admin);
        view()->share('adminUser', $admin);

        return $next($request);
    }
}
