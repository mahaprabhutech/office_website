@extends('admin.layouts.app')

@section('title', 'Administrators')
@section('page-title', 'Administrators')

@section('content')
<div class="page-heading">
    <div>
        <span class="page-kicker">Access control</span>
        <h2>Administrator Accounts</h2>
        <p>Create and manage people who can access the website administration panel.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="button button-primary">
        @include('admin.partials.icon', ['name' => 'plus', 'size' => 18])
        Add Administrator
    </a>
</div>

<section class="panel">
    <form method="GET" class="filter-bar">
        <label class="search-field">
            @include('admin.partials.icon', ['name' => 'search', 'size' => 19])
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search by name or email...">
        </label>
        <button type="submit" class="button button-dark">Search</button>
        @if(request('search'))<a href="{{ route('admin.users.index') }}" class="button button-link">Clear</a>@endif
    </form>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
            <tr>
                <th>Administrator</th>
                <th>Role</th>
                <th>Status</th>
                <th>Last login</th>
                <th class="cell-actions">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        <div class="user-cell">
                            <span class="avatar">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</span>
                            <span><strong>{{ $user->name }}</strong><small>{{ $user->email }}</small></span>
                        </div>
                    </td>
                    <td><span class="role-badge">{{ ($user->role ?? 'admin') === 'super_admin' ? 'Super Admin' : 'Admin' }}</span></td>
                    <td><span class="status-badge {{ ($user->status ?? 'active') === 'active' ? 'status-active' : 'status-inactive' }}">{{ ucfirst($user->status ?? 'active') }}</span></td>
                    <td><span class="date-cell">{{ isset($user->last_login_at) && $user->last_login_at ? \Illuminate\Support\Carbon::parse($user->last_login_at)->format('d M Y, h:i A') : 'Never' }}</span></td>
                    <td class="cell-actions">
                        <div class="table-actions">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="action-button" title="Edit">
                                @include('admin.partials.icon', ['name' => 'edit', 'size' => 17])
                            </a>
                            @if((int) session('admin_user_id') !== (int) $user->id)
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" data-confirm="Delete this administrator account?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-button action-danger" title="Delete">
                                        @include('admin.partials.icon', ['name' => 'trash', 'size' => 17])
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><div class="mini-empty">No administrator accounts found.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('admin.partials.pagination', ['paginator' => $users])
</section>
@endsection
