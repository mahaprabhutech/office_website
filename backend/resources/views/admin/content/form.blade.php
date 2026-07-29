@extends('admin.layouts.app')

@php($editing = (bool) $record)
@section('title', ($editing ? 'Edit ' : 'Add ').$definition['singular'])
@section('page-title', ($editing ? 'Edit ' : 'Add ').$definition['singular'])

@section('content')
<div class="page-heading">
    <div>
        <a href="{{ route('admin.content.index', $module) }}" class="back-link">
            @include('admin.partials.icon', ['name' => 'arrow-left', 'size' => 17])
            Back to {{ $definition['label'] }}
        </a>
        <h2>{{ $editing ? 'Edit' : 'Create' }} {{ $definition['singular'] }}</h2>
        <p>{{ $editing ? 'Update the information below and save your changes.' : 'Complete the fields below to add website content.' }}</p>
    </div>
    @if($editing)
        <a href="{{ route('admin.content.show', [$module, $record->id]) }}" class="button button-outline">
            @include('admin.partials.icon', ['name' => 'eye', 'size' => 18])
            Preview Record
        </a>
    @endif
</div>

<form
    method="POST"
    action="{{ $editing ? route('admin.content.update', [$module, $record->id]) : route('admin.content.store', $module) }}"
    enctype="multipart/form-data"
    class="editor-layout"
>
    @csrf
    @if($editing) @method('PUT') @endif

    <section class="panel editor-main">
        <div class="panel-header">
            <div>
                <span class="section-kicker">Content details</span>
                <h3>{{ $definition['singular'] }} information</h3>
            </div>
            <span class="required-note"><i>*</i> Required fields</span>
        </div>

        <div class="form-grid">
            @foreach($definition['fields'] as $field)
                @php
                    $column = $field['column'];
                    $type = $field['type'] ?? 'text';
                    $readonly = (bool) ($field['readonly'] ?? false);
                    $value = old($column, $record->{$column} ?? '');
                    if ($type === 'datetime-local' && $value) {
                        try { $value = \Illuminate\Support\Carbon::parse($value)->format('Y-m-d\TH:i'); } catch (\Throwable $e) {}
                    } elseif ($type === 'date' && $value) {
                        try { $value = \Illuminate\Support\Carbon::parse($value)->format('Y-m-d'); } catch (\Throwable $e) {}
                    }
                @endphp

                <div class="form-group {{ ($field['span'] ?? 1) === 2 ? 'span-2' : '' }}">
                    <label for="field-{{ $column }}">
                        {{ $field['label'] }}
                        @if(($field['required'] ?? false) && !$readonly)<i>*</i>@endif
                    </label>

                    @if($type === 'textarea' || $type === 'richtext')
                        <textarea
                            id="field-{{ $column }}"
                            name="{{ $column }}"
                            rows="{{ $type === 'richtext' ? 12 : 5 }}"
                            class="{{ $type === 'richtext' ? 'rich-editor' : '' }} @error($column) is-invalid @enderror"
                            placeholder="Enter {{ strtolower($field['label']) }}"
                            @readonly($readonly)
                        >{{ $value }}</textarea>
                    @elseif($type === 'select')
                        <select id="field-{{ $column }}" name="{{ $column }}" class="@error($column) is-invalid @enderror" @disabled($readonly)>
                            <option value="">Select {{ strtolower($field['label']) }}</option>
                            @foreach($field['options'] ?? [] as $optionValue => $optionLabel)
                                <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                            @endforeach
                        </select>
                    @elseif($type === 'boolean')
                        <label class="switch-control">
                            <input type="hidden" name="{{ $column }}" value="0">
                            <input id="field-{{ $column }}" type="checkbox" name="{{ $column }}" value="1" @checked((bool) $value) @disabled($readonly)>
                            <span class="switch-track"><span></span></span>
                            <span>Enabled</span>
                        </label>
                    @elseif($type === 'image')
                        <div class="upload-field">
                            @if($value)
                                @php($src = \Illuminate\Support\Str::startsWith((string) $value, ['http://', 'https://']) ? $value : asset('storage/'.ltrim((string) $value, '/')))
                                <img src="{{ $src }}" alt="" class="upload-preview" data-image-preview>
                            @else
                                <div class="upload-placeholder" data-upload-placeholder>
                                    @include('admin.partials.icon', ['name' => 'upload', 'size' => 25])
                                    <span>Choose an image</span>
                                    <small>JPG, PNG, WEBP or GIF · maximum 5 MB</small>
                                </div>
                            @endif
                            @unless($readonly)
                                <input id="field-{{ $column }}" type="file" name="{{ $column }}" accept="image/*" data-image-input class="@error($column) is-invalid @enderror">
                            @endunless
                        </div>
                    @elseif($type === 'file')
                        @if($value)
                            @php($fileUrl = \Illuminate\Support\Str::startsWith((string) $value, ['http://', 'https://']) ? $value : asset('storage/'.ltrim((string) $value, '/')))
                            <a href="{{ $fileUrl }}" target="_blank" rel="noopener" class="file-link">
                                @include('admin.partials.icon', ['name' => 'file-text', 'size' => 18])
                                Open uploaded file
                            </a>
                        @endif
                        @unless($readonly)
                            <input id="field-{{ $column }}" type="file" name="{{ $column }}" class="@error($column) is-invalid @enderror">
                        @endunless
                    @else
                        <input
                            id="field-{{ $column }}"
                            type="{{ $type }}"
                            name="{{ $column }}"
                            value="{{ $value }}"
                            placeholder="Enter {{ strtolower($field['label']) }}"
                            @if(isset($field['min'])) min="{{ $field['min'] }}" @endif
                            @if(isset($field['max'])) max="{{ $field['max'] }}" @endif
                            @readonly($readonly)
                            class="@error($column) is-invalid @enderror"
                        >
                    @endif

                    @if(!empty($field['help']))
                        <small class="field-help">{{ $field['help'] }}</small>
                    @endif
                    @error($column)<small class="field-error">{{ $message }}</small>@enderror
                </div>
            @endforeach
        </div>
    </section>

    <aside class="editor-sidebar">
        <section class="panel publish-card">
            <div class="panel-header compact">
                <h3>{{ $editing ? 'Update' : 'Publish' }}</h3>
            </div>
            <p>Review the information before saving. Website changes are available to the frontend API immediately.</p>
            <button type="submit" class="button button-primary button-full">
                @include('admin.partials.icon', ['name' => 'check', 'size' => 18])
                {{ $editing ? 'Save Changes' : 'Create '.$definition['singular'] }}
            </button>
            <a href="{{ route('admin.content.index', $module) }}" class="button button-soft button-full">Cancel</a>
        </section>

        @if($editing)
            <section class="panel record-meta">
                <h3>Record information</h3>
                <dl>
                    <div><dt>Record ID</dt><dd>#{{ $record->id }}</dd></div>
                    @if(isset($record->created_at) && $record->created_at)
                        <div><dt>Created</dt><dd>{{ \Illuminate\Support\Carbon::parse($record->created_at)->format('d M Y, h:i A') }}</dd></div>
                    @endif
                    @if(isset($record->updated_at) && $record->updated_at)
                        <div><dt>Last updated</dt><dd>{{ \Illuminate\Support\Carbon::parse($record->updated_at)->diffForHumans() }}</dd></div>
                    @endif
                </dl>
            </section>
        @endif
    </aside>
</form>

@if($editing && $module === 'projects' && \Illuminate\Support\Facades\Schema::hasTable('project_images'))
<section class="panel gallery-panel">
    <div class="panel-header">
        <div>
            <span class="section-kicker">Project media</span>
            <h3>Image gallery</h3>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.projects.images.store', $record->id) }}" enctype="multipart/form-data" class="gallery-upload">
        @csrf
        <label class="gallery-dropzone">
            @include('admin.partials.icon', ['name' => 'upload', 'size' => 26])
            <span>Select gallery images</span>
            <small>You can select up to 12 images at one time.</small>
            <input type="file" name="gallery_images[]" accept="image/*" multiple required>
        </label>
        <button type="submit" class="button button-dark">Upload Images</button>
    </form>

    <div class="gallery-grid">
        @forelse($gallery as $image)
            @php
                $imagePath = $image->image ?? $image->image_path ?? $image->path ?? $image->image_url ?? null;
                $imageSrc = $imagePath && \Illuminate\Support\Str::startsWith((string) $imagePath, ['http://', 'https://'])
                    ? $imagePath
                    : ($imagePath ? asset('storage/'.ltrim((string) $imagePath, '/')) : null);
            @endphp
            @if($imageSrc)
                <figure class="gallery-item">
                    <img src="{{ $imageSrc }}" alt="">
                    <form method="POST" action="{{ route('admin.projects.images.destroy', [$record->id, $image->id]) }}" data-confirm="Remove this gallery image?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" aria-label="Remove image">×</button>
                    </form>
                </figure>
            @endif
        @empty
            <p class="mini-empty">No gallery images have been uploaded.</p>
        @endforelse
    </div>
</section>
@endif
@endsection
