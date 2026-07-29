<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (session()->has('admin_user_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        if (!Schema::hasTable('users')) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'The users table is unavailable. Run the migrations first.');
        }

        $query = DB::table('users')->where('email', strtolower($credentials['email']));

        if (Schema::hasColumn('users', 'role')) {
            $query->whereIn('role', ['admin', 'super_admin']);
        }

        $user = $query->first();

        $isInactive = $user
            && Schema::hasColumn('users', 'status')
            && strtolower((string) $user->status) !== 'active';

        if (!$user || $isInactive || !Hash::check($credentials['password'], (string) $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'The administrator email or password is incorrect.']);
        }

        $request->session()->regenerate();

        session([
            'admin_user_id' => $user->id,
            'admin_user_name' => $user->name ?? 'Administrator',
            'admin_user_email' => $user->email,
            'admin_user_role' => $user->role ?? 'admin',
        ]);

        if (Schema::hasColumn('users', 'last_login_at')) {
            DB::table('users')->where('id', $user->id)->update([
                'last_login_at' => now(),
                ...(Schema::hasColumn('users', 'updated_at') ? ['updated_at' => now()] : []),
            ]);
        }

        AdminActivity::record('login', 'authentication', (int) $user->id, 'Administrator signed in.');

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Welcome back, '.($user->name ?? 'Administrator').'.');
    }

    public function logout(Request $request): RedirectResponse
    {
        AdminActivity::record('logout', 'authentication', (int) session('admin_user_id'), 'Administrator signed out.');

        $request->session()->forget([
            'admin_user_id',
            'admin_user_name',
            'admin_user_email',
            'admin_user_role',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been signed out securely.');
    }
}
