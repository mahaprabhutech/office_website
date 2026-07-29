<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->attributes->get('adminUser'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->attributes->get('adminUser');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'current_password' => ['nullable', 'required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:10', 'confirmed'],
        ]);

        if (!empty($data['password']) && !Hash::check((string) $data['current_password'], (string) $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $payload = [
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
        ];

        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'updated_at')) {
            $payload['updated_at'] = now();
        }

        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        DB::table('users')->where('id', $user->id)->update($payload);

        session([
            'admin_user_name' => $payload['name'],
            'admin_user_email' => $payload['email'],
        ]);

        AdminActivity::record('update', 'profile', (int) $user->id, 'Updated administrator profile.');

        return back()->with('success', 'Profile updated successfully.');
    }
}
