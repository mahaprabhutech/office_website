@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="page-heading">
    <div>
        <span class="page-kicker">Website control centre</span>
        <h2>Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ explode(' ', session('admin_user_name', 'Administrator'))[0] }}.</h2>
        <p>Here is a live overview of your corporate website content and incoming requests.</p>
    </div>
    <div class="page-heading-actions">
        <a href="{{ config('app.url') }}" target="_blank" rel="noopener" class="button button-outline">
            @include('admin.partials.icon', ['name' => 'external-link', 'size' => 18])
            Open Live Website
        </a>
    </div>
</div>

<section class="hero-panel">
    <div class="hero-copy">
        <span class="hero-badge">Mahaprabhu Tech Admin</span>
        <h3>Everything required to manage the website, in one place.</h3>
        <p>Publish updates, handle customer enquiries and keep the company profile current without changing code.</p>
        <div class="hero-actions">
            @if(isset($availableModules['blog-posts']))
                <a href="{{ route('admin.content.create', 'blog-posts') }}" class="button button-light">
                    @include('admin.partials.icon', ['name' => 'plus', 'size' => 18])
                    Create Blog Post
                </a>
            @endif
            @if(isset($availableModules['projects']))
                <a href="{{ route('admin.content.create', 'projects') }}" class="button button-ghost-light">
                    Add Project
                </a>
            @endif
        </div>
    </div>
    <div class="hero-visual">
        <div class="hero-ring hero-ring-one"></div>
        <div class="hero-ring hero-ring-two"></div>
        <img src="{{ asset('admin-assets/images/brand-eye.svg') }}" alt="" class="hero-logo">
    </div>
</section>

<div class="stats-grid">
    <article class="stat-card stat-card-primary">
        <div class="stat-icon">@include('admin.partials.icon', ['name' => 'folder', 'size' => 22])</div>
        <div>
            <span>Active Modules</span>
            <strong>{{ count($cards) }}</strong>
            <small>Connected website sections</small>
        </div>
    </article>

    <article class="stat-card">
        <div class="stat-icon">@include('admin.partials.icon', ['name' => 'inbox', 'size' => 22])</div>
        <div>
            <span>Needs Attention</span>
            <strong>{{ number_format($attention) }}</strong>
            <small>New incoming requests</small>
        </div>
    </article>

    <article class="stat-card">
        <div class="stat-icon">@include('admin.partials.icon', ['name' => 'clock', 'size' => 22])</div>
        <div>
            <span>Last Login</span>
            <strong class="stat-text">{{ isset($adminUser->last_login_at) && $adminUser->last_login_at ? \Illuminate\Support\Carbon::parse($adminUser->last_login_at)->format('d M, h:i A') : 'First session' }}</strong>
            <small>Administrator activity</small>
        </div>
    </article>

    <article class="stat-card">
        <div class="stat-icon">@include('admin.partials.icon', ['name' => 'shield', 'size' => 22])</div>
        <div>
            <span>System Status</span>
            <strong class="status-online"><i></i> Online</strong>
            <small>Admin panel is operational</small>
        </div>
    </article>
</div>

<section class="content-section">
    <div class="section-heading">
        <div>
            <span class="section-kicker">Content overview</span>
            <h3>Website modules</h3>
        </div>
        <p>Select a module to view, add or update website content.</p>
    </div>

    <div class="module-grid">
        @forelse($cards as $card)
            <a href="{{ route('admin.content.index', $card['key']) }}" class="module-card">
                <span class="module-icon">
                    @include('admin.partials.icon', ['name' => $card['icon'], 'size' => 23])
                </span>
                <span class="module-copy">
                    <strong>{{ $card['label'] }}</strong>
                    <small>{{ $card['description'] }}</small>
                </span>
                <span class="module-count">{{ number_format($card['count']) }}</span>
                <span class="module-arrow">→</span>
            </a>
        @empty
            <div class="empty-state">
                <span class="empty-icon">@include('admin.partials.icon', ['name' => 'alert', 'size' => 28])</span>
                <h3>No supported content tables found</h3>
                <p>Confirm that the website migrations have been run and the database in <code>.env</code> is correct.</p>
            </div>
        @endforelse
    </div>
</section>

<div class="dashboard-columns">
    <section class="panel">
        <div class="panel-header">
            <div>
                <span class="section-kicker">Latest records</span>
                <h3>Recent website activity</h3>
            </div>
        </div>
        <div class="activity-list">
            @forelse($recentItems as $item)
                <a href="{{ route('admin.content.show', [$item['module'], $item['id']]) }}" class="activity-item">
                    <span class="activity-symbol">@include('admin.partials.icon', ['name' => 'file-text', 'size' => 18])</span>
                    <span class="activity-copy">
                        <strong>{{ $item['title'] }}</strong>
                        <small>{{ $item['module_label'] }}</small>
                    </span>
                    <time>{{ $item['date'] ? \Illuminate\Support\Carbon::parse($item['date'])->diffForHumans() : 'Recently' }}</time>
                </a>
            @empty
                <div class="mini-empty">No recent records are available.</div>
            @endforelse
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div>
                <span class="section-kicker">Audit trail</span>
                <h3>Administrator activity</h3>
            </div>
        </div>
        <div class="activity-list">
            @forelse($activities as $activity)
                <div class="activity-item">
                    <span class="activity-symbol activity-symbol-dark">
                        @include('admin.partials.icon', ['name' => in_array($activity->action, ['create', 'upload']) ? 'plus' : ($activity->action === 'delete' ? 'trash' : 'edit'), 'size' => 18])
                    </span>
                    <span class="activity-copy">
                        <strong>{{ $activity->description ?: ucfirst($activity->action) }}</strong>
                        <small>{{ $activity->user_name ?? 'Administrator' }} · {{ $activity->module ?: 'System' }}</small>
                    </span>
                    <time>{{ \Illuminate\Support\Carbon::parse($activity->created_at)->diffForHumans() }}</time>
                </div>
            @empty
                <div class="mini-empty">Activity history will appear after administrators make changes.</div>
            @endforelse
        </div>
    </section>
</div>
@endsection
