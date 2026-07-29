@extends('admin.layouts.app')

@php($editing = (bool) $user)
@section('title', $editing ? 'Edit Administrator' : 'Add Administrator')
@section('page-title', $editing ? 'Edit Administrator' : 'Add Administrator')

@section('content')
<div class="page-heading">
    <div>
        <a href="{{ route('admin.users.index') }}" class="back-link">
            @include('admin.partials.icon', ['name' => 'arrow-left', 'size' => 17])
            Back to Administrators
        </a>
        <h2>{{ $editing ? 'Edit Administrator' : 'Create Administrator' }}</h2>
        <p>Set account details, access level and account status.</p>
    </div>
</div>

<form method="POST" action="{{ $editing ? route('admin.users.update', $user->id) : route('admin.users.store') }}" class="editor-layout">
    @csrf
    @if($editing) @method('PUT') @endif

    <section class="panel editor-main">
        <div class="panel-header">
            <div>
                <span class="section-kicker">Account details</span>
                <h3>Administrator information</h3>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="name">Full name <i>*</i></label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required class="@error('name') is-invalid @enderror">
                @error('name')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="email">Email address <i>*</i></label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required class="@error('email') is-invalid @enderror">
                @error('email')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="role">Access role <i>*</i></label>
                <select id="role" name="role" required class="@error('role') is-invalid @enderror">
                    <option value="admin" @selected(old('role', $user->role ?? 'admin') === 'admin')>Administrator</option>
                    <option value="super_admin" @selected(old('role', $user->role ?? '') === 'super_admin')>Super Administrator</option>
                </select>
                <small class="field-help">Super administrators can manage other administrator accounts.</small>
                @error('role')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="status">Account status <i>*</i></label>
                <select id="status" name="status" required class="@error('status') is-invalid @enderror">
                    <option value="active" @selected(old('status', $user->status ?? 'active') === 'active')>Active</option>
                    <option value="inactive" @selected(old('status', $user->status ?? '') === 'inactive')>Inactive</option>
                </select>
                @error('status')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="password">Password {{ $editing ? '' : '*' }}</label>
                <input id="password" type="password" name="password" autocomplete="new-password" {{ $editing ? '' : 'required' }} class="@error('password') is-invalid @enderror">
                <small class="field-help">{{ $editing ? 'Leave blank to keep the current password.' : 'Use at least 10 characters.' }}</small>
                @error('password')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm password {{ $editing ? '' : '*' }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" {{ $editing ? '' : 'required' }}>
            </div>
        </div>
    </section>

    <aside class="editor-sidebar">
        <section class="panel publish-card">
            <div class="panel-header compact"><h3>Save account</h3></div>
            <p>Only provide access to trusted company staff. Each administrator should use a separate account.</p>
            <button type="submit" class="button button-primary button-full">
                @include('admin.partials.icon', ['name' => 'check', 'size' => 18])
                {{ $editing ? 'Save Changes' : 'Create Administrator' }}
            </button>
            <a href="{{ route('admin.users.index') }}" class="button button-soft button-full">Cancel</a>
        </section>
    </aside>
</form>
@endsection
