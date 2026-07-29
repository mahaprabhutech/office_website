@extends('admin.layouts.app')

@section('title', 'Website Settings')
@section('page-title', 'Website Settings')

@section('content')
<div class="page-heading">
    <div>
        <span class="page-kicker">Global configuration</span>
        <h2>Website Settings</h2>
        <p>Manage company contact information, social links and default SEO content.</p>
    </div>
</div>

@if(!$keyColumn || !$valueColumn)
    <div class="alert alert-danger">
        <span class="alert-icon">@include('admin.partials.icon', ['name' => 'alert', 'size' => 18])</span>
        <span>The <code>site_settings</code> table needs key/value columns. Supported names are key, setting_key or name and value, setting_value or content.</span>
    </div>
@else
<form method="POST" action="{{ route('admin.settings.update') }}" class="settings-layout">
    @csrf
    @method('PUT')

    <nav class="settings-nav">
        <span class="settings-nav-title">Setting groups</span>
        @foreach($groups as $group => $items)
            <a href="#settings-{{ \Illuminate\Support\Str::slug($group) }}">{{ $group }}</a>
        @endforeach
    </nav>

    <div class="settings-content">
        @foreach($groups as $group => $items)
            <section class="panel settings-group" id="settings-{{ \Illuminate\Support\Str::slug($group) }}">
                <div class="panel-header">
                    <div>
                        <span class="section-kicker">Configuration</span>
                        <h3>{{ $group }}</h3>
                    </div>
                </div>

                <div class="form-grid">
                    @foreach($items as $key => $definition)
                        <div class="form-group {{ ($definition['type'] ?? 'text') === 'textarea' ? 'span-2' : '' }}">
                            <label for="setting-{{ $key }}">{{ $definition['label'] }}</label>
                            @if(($definition['type'] ?? 'text') === 'textarea')
                                <textarea id="setting-{{ $key }}" name="{{ $key }}" rows="5" class="@error($key) is-invalid @enderror">{{ old($key, $values[$key] ?? '') }}</textarea>
                            @else
                                <input
                                    id="setting-{{ $key }}"
                                    type="{{ $definition['type'] ?? 'text' }}"
                                    name="{{ $key }}"
                                    value="{{ old($key, $values[$key] ?? '') }}"
                                    class="@error($key) is-invalid @enderror"
                                >
                            @endif
                            @error($key)<small class="field-error">{{ $message }}</small>@enderror
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <div class="sticky-save">
            <span>Save all website setting changes.</span>
            <button type="submit" class="button button-primary">
                @include('admin.partials.icon', ['name' => 'check', 'size' => 18])
                Save Settings
            </button>
        </div>
    </div>
</form>
@endif
@endsection
