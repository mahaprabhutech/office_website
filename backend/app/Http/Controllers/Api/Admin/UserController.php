<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return User::latest()->paginate(30);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        return response()->json(User::create($data), 201);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validated($request, $user->id, false);
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }
        $user->update($data);

        return $user->fresh();
    }

    public function destroy(Request $request, User $user)
    {
        abort_if($request->user()->is($user), 422, 'You cannot delete your own account.');
        abort_if($user->role === 'super_admin', 422, 'The super administrator account cannot be deleted.');
        $user->delete();

        return response()->noContent();
    }

    private function validated(Request $request, ?int $id = null, bool $passwordRequired = true): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($id)],
            'password' => [$passwordRequired ? 'required' : 'nullable', 'string', 'min:8', 'max:100'],
            'role' => ['required', Rule::in(['super_admin', 'admin', 'editor', 'hr', 'sales', 'viewer'])],
            'is_active' => ['boolean'],
        ]);
    }
}
