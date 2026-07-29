@php
    $modules = app(\App\Support\AdminModuleRegistry::class)->all();
    $currentModule = request()->route('module');
@endphp

<aside class="admin-sidebar" data-sidebar>
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('admin-assets/images/brand-eye.svg') }}" alt="" class="brand-mark">
            <span class="brand-copy">
                <strong>Mahaprabhu Tech</strong>
                <small>Website Admin</small>
            </span>
        </a>
        <button type="button" class="icon-button sidebar-close" data-sidebar-close aria-label="Close menu">
            <span aria-hidden="true">×</span>
        </button>
    </div>

    <div class="sidebar-body">
        <p class="sidebar-label">Overview</p>
        <nav class="sidebar-nav" aria-label="Administration">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                @include('admin.partials.icon', ['name' => 'dashboard'])
                <span>Dashboard</span>
            </a>
        </nav>

        <p class="sidebar-label">Website Content</p>
        <nav class="sidebar-nav">
            @foreach($modules as $key => $module)
                <a href="{{ route('admin.content.index', $key) }}"
                   class="nav-link {{ $currentModule === $key ? 'is-active' : '' }}">
                    @include('admin.partials.icon', ['name' => $module['icon'] ?? 'folder'])
                    <span>{{ $module['label'] }}</span>
                    @if(in_array($key, ['enquiries', 'job-applications', 'quotations'], true))
                        <span class="nav-dot" title="Incoming records"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        <p class="sidebar-label">Administration</p>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.settings.index') }}"
               class="nav-link {{ request()->routeIs('admin.settings.*') ? 'is-active' : '' }}">
                @include('admin.partials.icon', ['name' => 'settings'])
                <span>Website Settings</span>
            </a>
            @if(session('admin_user_role') === 'super_admin')
                <a href="{{ route('admin.users.index') }}"
                   class="nav-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">
                    @include('admin.partials.icon', ['name' => 'shield'])
                    <span>Administrators</span>
                </a>
            @endif
        </nav>
    </div>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <span class="avatar">{{ strtoupper(substr(session('admin_user_name', 'A'), 0, 1)) }}</span>
            <span>
                <strong>{{ session('admin_user_name', 'Administrator') }}</strong>
                <small>{{ session('admin_user_role', 'admin') === 'super_admin' ? 'Super Administrator' : 'Administrator' }}</small>
            </span>
        </div>
    </div>
</aside>
