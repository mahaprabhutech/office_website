<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensureSuperAdmin();
        abort_unless(Schema::hasTable('users'), 404);

        $query = DB::table('users');

        if (Schema::hasColumn('users', 'role')) {
            $query->whereIn('role', ['admin', 'super_admin']);
        }

        if ($search = trim((string) $request->query('search'))) {
            $query->where(function ($inner) use ($search): void {
                $inner->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderByDesc('id')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $this->ensureSuperAdmin();
        return view('admin.users.form', ['user' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureSuperAdmin();
        $data = $request->validate($this->rules());
        $columns = Schema::getColumnListing('users');

        $payload = [
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'password' => Hash::make($data['password']),
        ];

        if (in_array('role', $columns, true)) {
            $payload['role'] = $data['role'];
        }
        if (in_array('status', $columns, true)) {
            $payload['status'] = $data['status'];
        }
        if (in_array('email_verified_at', $columns, true)) {
            $payload['email_verified_at'] = now();
        }
        if (in_array('created_at', $columns, true)) {
            $payload['created_at'] = now();
        }
        if (in_array('updated_at', $columns, true)) {
            $payload['updated_at'] = now();
        }

        $id = DB::table('users')->insertGetId($payload);

        AdminActivity::record('create', 'admin-users', (int) $id, "Created administrator {$payload['email']}.");

        return redirect()->route('admin.users.index')
            ->with('success', 'Administrator created successfully.');
    }

    public function edit(int $user): View
    {
        $this->ensureSuperAdmin();
        return view('admin.users.form', ['user' => $this->find($user)]);
    }

    public function update(Request $request, int $user): RedirectResponse
    {
        $this->ensureSuperAdmin();
        $existing = $this->find($user);
        $data = $request->validate($this->rules($user));
        $columns = Schema::getColumnListing('users');

        $payload = [
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
        ];

        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }
        if (in_array('role', $columns, true)) {
            $payload['role'] = $data['role'];
        }
        if (in_array('status', $columns, true)) {
            $payload['status'] = $data['status'];
        }
        if (in_array('updated_at', $columns, true)) {
            $payload['updated_at'] = now();
        }

        if ((int) session('admin_user_id') === $user) {
            $payload['status'] = 'active';
            session([
                'admin_user_name' => $payload['name'],
                'admin_user_email' => $payload['email'],
                'admin_user_role' => $payload['role'] ?? ($existing->role ?? 'admin'),
            ]);
        }

        DB::table('users')->where('id', $user)->update($payload);

        AdminActivity::record('update', 'admin-users', $user, "Updated administrator {$payload['email']}.");

        return redirect()->route('admin.users.index')
            ->with('success', 'Administrator updated successfully.');
    }

    public function destroy(int $user): RedirectResponse
    {
        $this->ensureSuperAdmin();
        abort_if((int) session('admin_user_id') === $user, 422, 'You cannot delete your own signed-in account.');

        $existing = $this->find($user);
        DB::table('users')->where('id', $user)->delete();

        AdminActivity::record('delete', 'admin-users', $user, "Deleted administrator {$existing->email}.");

        return back()->with('success', 'Administrator deleted.');
    }

    private function ensureSuperAdmin(): void
    {
        abort_unless(
            session('admin_user_role') === 'super_admin',
            403,
            'Only a super administrator can manage administrator accounts.'
        );
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($ignoreId),
            ],
            'password' => [$ignoreId ? 'nullable' : 'required', 'string', 'min:10', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'super_admin'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    private function find(int $id): object
    {
        $user = DB::table('users')->where('id', $id)->first();
        abort_unless($user, 404);

        if (Schema::hasColumn('users', 'role')) {
            abort_unless(in_array($user->role, ['admin', 'super_admin'], true), 404);
        }

        return $user;
    }
}
