@extends('admin.layouts.app')

@section('title', $definition['singular'].' Details')
@section('page-title', $definition['singular'].' Details')

@section('content')
<div class="page-heading">
    <div>
        <a href="{{ route('admin.content.index', $module) }}" class="back-link">
            @include('admin.partials.icon', ['name' => 'arrow-left', 'size' => 17])
            Back to {{ $definition['label'] }}
        </a>
        <h2>{{ $definition['singular'] }} #{{ $record->id }}</h2>
        <p>Review the stored information for this record.</p>
    </div>
    <a href="{{ route('admin.content.edit', [$module, $record->id]) }}" class="button button-primary">
        @include('admin.partials.icon', ['name' => 'edit', 'size' => 18])
        Edit {{ $definition['singular'] }}
    </a>
</div>

<section class="panel detail-panel">
    <div class="detail-grid">
        @foreach($definition['fields'] as $field)
            @php
                $value = $record->{$field['column']} ?? null;
                $type = $field['type'] ?? 'text';
            @endphp
            <div class="detail-field {{ ($field['span'] ?? 1) === 2 || in_array($type, ['textarea', 'richtext'], true) ? 'span-2' : '' }}">
                <dt>{{ $field['label'] }}</dt>
                <dd>
                    @if($type === 'image')
                        @if($value)
                            @php($src = \Illuminate\Support\Str::startsWith((string) $value, ['http://', 'https://']) ? $value : asset('storage/'.ltrim((string) $value, '/')))
                            <img src="{{ $src }}" alt="" class="detail-image">
                        @else
                            <span class="muted-value">No image uploaded</span>
                        @endif
                    @elseif($type === 'file')
                        @if($value)
                            @php($fileUrl = \Illuminate\Support\Str::startsWith((string) $value, ['http://', 'https://']) ? $value : asset('storage/'.ltrim((string) $value, '/')))
                            <a href="{{ $fileUrl }}" target="_blank" rel="noopener" class="file-link">
                                @include('admin.partials.icon', ['name' => 'file-text', 'size' => 18])
                                Open uploaded file
                            </a>
                        @else
                            <span class="muted-value">No file uploaded</span>
                        @endif
                    @elseif($type === 'boolean')
                        <span class="status-badge {{ $value ? 'status-active' : 'status-inactive' }}">{{ $value ? 'Active' : 'Inactive' }}</span>
                    @elseif($type === 'select')
                        <span class="status-badge status-{{ \Illuminate\Support\Str::slug((string) $value) }}">{{ $field['options'][$value] ?? ucfirst((string) ($value ?: 'Not set')) }}</span>
                    @elseif($type === 'richtext')
                        <div class="rich-content">{!! $value ?: '<span class="muted-value">Not provided</span>' !!}</div>
                    @elseif($type === 'url' && $value)
                        <a href="{{ $value }}" target="_blank" rel="noopener" class="text-link">{{ $value }}</a>
                    @elseif($type === 'email' && $value)
                        <a href="mailto:{{ $value }}" class="text-link">{{ $value }}</a>
                    @else
                        <span class="preserve-lines">{{ $value !== null && $value !== '' ? $value : '—' }}</span>
                    @endif
                </dd>
            </div>
        @endforeach
    </div>

    <div class="detail-meta">
        <span>Record ID: #{{ $record->id }}</span>
        @if(isset($record->created_at) && $record->created_at)
            <span>Created: {{ \Illuminate\Support\Carbon::parse($record->created_at)->format('d M Y, h:i A') }}</span>
        @endif
        @if(isset($record->updated_at) && $record->updated_at)
            <span>Updated: {{ \Illuminate\Support\Carbon::parse($record->updated_at)->format('d M Y, h:i A') }}</span>
        @endif
    </div>
</section>

@if($gallery)
<section class="panel gallery-panel">
    <div class="panel-header"><h3>Project gallery</h3></div>
    <div class="gallery-grid">
        @foreach($gallery as $image)
            @php
                $imagePath = $image->image ?? $image->image_path ?? $image->path ?? $image->image_url ?? null;
                $imageSrc = $imagePath && \Illuminate\Support\Str::startsWith((string) $imagePath, ['http://', 'https://'])
                    ? $imagePath
                    : ($imagePath ? asset('storage/'.ltrim((string) $imagePath, '/')) : null);
            @endphp
            @if($imageSrc)<figure class="gallery-item"><img src="{{ $imageSrc }}" alt=""></figure>@endif
        @endforeach
    </div>
</section>
@endif
@endsection
