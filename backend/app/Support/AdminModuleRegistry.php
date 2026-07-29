<?php

namespace App\Support;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;

class AdminModuleRegistry
{
    public function all(bool $availableOnly = true): array
    {
        $modules = config('site_admin.modules', []);

        if (!$availableOnly) {
            return $modules;
        }

        return array_filter(
            $modules,
            fn (array $module): bool => Schema::hasTable($module['table'])
        );
    }

    public function get(string $key): array
    {
        $module = config("site_admin.modules.{$key}");

        if (!$module || !isset($module['table'])) {
            abort(404, 'Admin module not found.');
        }

        if (!Schema::hasTable($module['table'])) {
            abort(404, "The {$module['table']} table does not exist.");
        }

        $module['key'] = $key;
        $module['columns'] = Schema::getColumnListing($module['table']);
        $module['fields'] = $this->resolveFields($module);

        return $module;
    }

    public function resolveFields(array $module): array
    {
        $columns = $module['columns'] ?? Schema::getColumnListing($module['table']);
        $resolved = [];

        foreach ($module['fields'] ?? [] as $field) {
            $column = collect($field['columns'] ?? [])
                ->first(fn (string $candidate): bool => in_array($candidate, $columns, true));

            if (!$column) {
                continue;
            }

            $field['column'] = $column;
            $field['name'] = $column;
            $resolved[] = $field;
        }

        /*
         * Existing deployments sometimes contain additional columns not known
         * when this package was generated. Add safe fallback fields so those
         * values remain manageable instead of silently disappearing.
         */
        $used = array_column($resolved, 'column');
        $excluded = [
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
            'password',
            'remember_token',
            'email_verified_at',
        ];

        foreach ($columns as $column) {
            if (in_array($column, $used, true) || in_array($column, $excluded, true)) {
                continue;
            }

            $type = $this->inferFieldType($column);
            $readonlyModule = ($module['create'] ?? true) === false;
            $editableWorkflowColumn = in_array($column, ['status', 'admin_notes', 'notes'], true);

            $resolved[] = [
                'columns' => [$column],
                'column' => $column,
                'name' => $column,
                'label' => Str::headline($column),
                'type' => $type,
                'readonly' => $readonlyModule && !$editableWorkflowColumn,
                'span' => in_array($type, ['textarea', 'richtext'], true) ? 2 : 1,
                'help' => 'Existing database field detected automatically.',
            ];
        }

        return $resolved;
    }

    private function inferFieldType(string $column): string
    {
        $name = strtolower($column);

        if (Str::startsWith($name, ['is_', 'has_', 'allow_', 'show_']) || in_array($name, ['active', 'published'], true)) {
            return 'boolean';
        }

        if (Str::contains($name, ['image', 'photo', 'thumbnail', 'avatar', 'logo'])) {
            return 'image';
        }

        if (Str::contains($name, ['resume', 'document', 'attachment', 'file_path'])) {
            return 'file';
        }

        if ($name === 'email' || Str::endsWith($name, '_email')) {
            return 'email';
        }

        if (Str::contains($name, ['url', 'website', 'linkedin', 'facebook', 'instagram', 'youtube'])) {
            return 'url';
        }

        if (Str::endsWith($name, '_at')) {
            return 'datetime-local';
        }

        if ($name === 'date' || Str::endsWith($name, ['_date', '_on'])) {
            return 'date';
        }

        if (Str::contains($name, ['content', 'description', 'body'])) {
            return 'richtext';
        }

        if (Str::contains($name, ['message', 'summary', 'excerpt', 'notes', 'requirements', 'address', 'bio'])) {
            return 'textarea';
        }

        if (Str::endsWith($name, ['_id', '_order', '_count', '_rating', '_amount', '_price'])) {
            return 'number';
        }

        return 'text';
    }

    public function firstColumn(array $module, array|string $candidates, ?string $fallback = null): ?string
    {
        $columns = $module['columns'] ?? Schema::getColumnListing($module['table']);

        foreach ((array) $candidates as $candidate) {
            if (in_array($candidate, $columns, true)) {
                return $candidate;
            }
        }

        return $fallback && in_array($fallback, $columns, true) ? $fallback : null;
    }

    public function titleColumn(array $module): string
    {
        return $this->firstColumn(
            $module,
            $module['title_columns'] ?? ['title', 'name'],
            'id'
        ) ?? 'id';
    }

    public function statusColumn(array $module): ?string
    {
        return $this->firstColumn($module, $module['status_columns'] ?? ['status', 'is_active']);
    }

    public function dateColumn(array $module): ?string
    {
        return $this->firstColumn($module, $module['date_columns'] ?? ['created_at', 'updated_at']);
    }

    public function uploadDirectory(string $moduleKey, string $column): string
    {
        return 'website/'.Str::slug($moduleKey).'/'.Str::slug($column);
    }

    public function assertWritable(array $module, string $action): void
    {
        if (($module[$action] ?? true) === false) {
            abort(403, ucfirst($action).' is disabled for this module.');
        }
    }
}
