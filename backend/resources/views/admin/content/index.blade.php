@extends('admin.layouts.app')

@section('title', $definition['label'])
@section('page-title', $definition['label'])

@section('content')
<div class="page-heading">
    <div>
        <span class="page-kicker">Website content</span>
        <h2>{{ $definition['label'] }}</h2>
        <p>{{ $definition['description'] ?? 'Manage this website section.' }}</p>
    </div>
    @if(($definition['create'] ?? true) !== false)
        <a href="{{ route('admin.content.create', $module) }}" class="button button-primary">
            @include('admin.partials.icon', ['name' => 'plus', 'size' => 18])
            Add {{ $definition['singular'] }}
        </a>
    @endif
</div>

<section class="panel">
    <form method="GET" class="filter-bar">
        <label class="search-field">
            @include('admin.partials.icon', ['name' => 'search', 'size' => 19])
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search {{ strtolower($definition['label']) }}...">
        </label>

        @if($statusColumn)
            <label class="select-field">
                <span>Status</span>
                <select name="status">
                    <option value="">All statuses</option>
                    @php
                        $statusField = collect($definition['fields'])->firstWhere('column', $statusColumn);
                        $statusOptions = $statusField['options'] ?? ['active' => 'Active', 'inactive' => 'Inactive', 'new' => 'New'];
                    @endphp
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected((string) request('status') === (string) $value)>{{ $label }}</option>
                    @endforeach
                    @if(in_array($statusColumn, ['is_active', 'published'], true))
                        <option value="1" @selected(request('status') === '1')>Yes / Active</option>
                        <option value="0" @selected(request('status') === '0')>No / Inactive</option>
                    @endif
                </select>
            </label>
        @endif

        <button type="submit" class="button button-dark">Apply Filter</button>
        @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('admin.content.index', $module) }}" class="button button-link">Clear</a>
        @endif
    </form>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
            <tr>
                <th class="cell-id">ID</th>
                @foreach($displayFields as $field)
                    <th>{{ $field['label'] }}</th>
                @endforeach
                <th>Updated</th>
                <th class="cell-actions">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($records as $record)
                <tr>
                    <td class="cell-id">#{{ $record->id }}</td>
                    @foreach($displayFields as $field)
                        @php
                            $value = $record->{$field['column']} ?? null;
                            $type = $field['type'] ?? 'text';
                        @endphp
                        <td>
                            @if($type === 'image')
                                @if($value)
                                    @php($src = \Illuminate\Support\Str::startsWith((string) $value, ['http://', 'https://']) ? $value : asset('storage/'.ltrim((string) $value, '/')))
                                    <img src="{{ $src }}" alt="" class="table-image">
                                @else
                                    <span class="table-image-placeholder">—</span>
                                @endif
                            @elseif($type === 'boolean')
                                <span class="status-badge {{ $value ? 'status-active' : 'status-inactive' }}">
                                    {{ $value ? 'Active' : 'Inactive' }}
                                </span>
                            @elseif($type === 'select' && $field['column'] === $statusColumn)
                                <span class="status-badge status-{{ \Illuminate\Support\Str::slug((string) $value) }}">
                                    {{ $field['options'][$value] ?? ucfirst((string) $value) }}
                                </span>
                            @else
                                <span class="{{ $loop->first ? 'primary-cell' : '' }}">
                                    {{ \Illuminate\Support\Str::limit(strip_tags((string) ($value ?? '—')), 55) }}
                                </span>
                            @endif
                        </td>
                    @endforeach
                    <td>
                        @php($date = $record->updated_at ?? $record->created_at ?? null)
                        <span class="date-cell">{{ $date ? \Illuminate\Support\Carbon::parse($date)->format('d M Y') : '—' }}</span>
                    </td>
                    <td class="cell-actions">
                        <div class="table-actions">
                            <a href="{{ route('admin.content.show', [$module, $record->id]) }}" class="action-button" title="View">
                                @include('admin.partials.icon', ['name' => 'eye', 'size' => 17])
                            </a>
                            <a href="{{ route('admin.content.edit', [$module, $record->id]) }}" class="action-button" title="Edit">
                                @include('admin.partials.icon', ['name' => 'edit', 'size' => 17])
                            </a>
                            @if(($definition['delete'] ?? true) !== false)
                                <form method="POST" action="{{ route('admin.content.destroy', [$module, $record->id]) }}" data-confirm="Delete this {{ strtolower($definition['singular']) }}? This action cannot be undone.">
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
                <tr>
                    <td colspan="{{ count($displayFields) + 3 }}">
                        <div class="empty-state table-empty">
                            <span class="empty-icon">@include('admin.partials.icon', ['name' => 'inbox', 'size' => 28])</span>
                            <h3>No {{ strtolower($definition['label']) }} found</h3>
                            <p>{{ request('search') ? 'Try a different search term.' : 'Records added to this section will appear here.' }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('admin.partials.pagination', ['paginator' => $records])
</section>
@endsection
