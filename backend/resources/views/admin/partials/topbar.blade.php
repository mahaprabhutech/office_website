<header class="admin-topbar">
    <div class="topbar-left">
        <button type="button" class="icon-button menu-toggle" data-sidebar-open aria-label="Open menu">
            @include('admin.partials.icon', ['name' => 'menu'])
        </button>
        <div>
            <p class="topbar-eyebrow">Mahaprabhu Tech Innovation</p>
            <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
        </div>
    </div>

    <div class="topbar-actions">
        <a href="{{ config('app.url') }}" target="_blank" rel="noopener" class="button button-soft topbar-site-link">
            @include('admin.partials.icon', ['name' => 'external-link', 'size' => 18])
            <span>View Website</span>
        </a>

        <div class="profile-menu" data-profile-menu>
            <button type="button" class="profile-trigger" data-profile-trigger aria-expanded="false">
                <span class="avatar avatar-small">{{ strtoupper(substr(session('admin_user_name', 'A'), 0, 1)) }}</span>
                <span class="profile-trigger-copy">
                    <strong>{{ session('admin_user_name', 'Administrator') }}</strong>
                    <small>{{ session('admin_user_email') }}</small>
                </span>
                <span class="profile-caret">⌄</span>
            </button>

            <div class="profile-dropdown" data-profile-dropdown>
                <a href="{{ route('admin.profile.edit') }}">
                    @include('admin.partials.icon', ['name' => 'user', 'size' => 18])
                    My Profile
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit">
                        @include('admin.partials.icon', ['name' => 'logout', 'size' => 18])
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
