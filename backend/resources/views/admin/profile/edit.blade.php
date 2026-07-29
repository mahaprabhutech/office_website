@extends('admin.layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="page-heading">
    <div>
        <span class="page-kicker">Account security</span>
        <h2>My Profile</h2>
        <p>Update your administrator name, email address and password.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.profile.update') }}" class="profile-layout">
    @csrf
    @method('PUT')

    <aside class="panel profile-card">
        <span class="profile-avatar-large">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</span>
        <h3>{{ $user->name }}</h3>
        <p>{{ $user->email }}</p>
        <span class="role-badge">{{ ($user->role ?? 'admin') === 'super_admin' ? 'Super Administrator' : 'Administrator' }}</span>
        @if(isset($user->last_login_at) && $user->last_login_at)
            <small>Last login {{ \Illuminate\Support\Carbon::parse($user->last_login_at)->diffForHumans() }}</small>
        @endif
    </aside>

    <div class="profile-sections">
        <section class="panel">
            <div class="panel-header">
                <div><span class="section-kicker">Personal details</span><h3>Account information</h3></div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Full name <i>*</i></label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="@error('name') is-invalid @enderror">
                    @error('name')<small class="field-error">{{ $message }}</small>@enderror
                </div>
                <div class="form-group">
                    <label for="email">Email address <i>*</i></label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="@error('email') is-invalid @enderror">
                    @error('email')<small class="field-error">{{ $message }}</small>@enderror
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-header">
                <div><span class="section-kicker">Password</span><h3>Change password</h3></div>
            </div>
            <p class="panel-intro">Leave these fields empty when you do not need to change your password.</p>
            <div class="form-grid">
                <div class="form-group span-2">
                    <label for="current_password">Current password</label>
                    <input id="current_password" type="password" name="current_password" autocomplete="current-password" class="@error('current_password') is-invalid @enderror">
                    @error('current_password')<small class="field-error">{{ $message }}</small>@enderror
                </div>
                <div class="form-group">
                    <label for="password">New password</label>
                    <input id="password" type="password" name="password" autocomplete="new-password" class="@error('password') is-invalid @enderror">
                    <small class="field-help">Use at least 10 characters.</small>
                    @error('password')<small class="field-error">{{ $message }}</small>@enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm new password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
                </div>
            </div>
        </section>

        <div class="form-actions">
            <button type="submit" class="button button-primary">
                @include('admin.partials.icon', ['name' => 'check', 'size' => 18])
                Save Profile
            </button>
        </div>
    </div>
</form>
@endsection
