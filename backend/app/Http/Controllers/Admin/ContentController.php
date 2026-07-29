<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminActivity;
use App\Support\AdminModuleRegistry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class ContentController extends Controller
{
    public function __construct(private readonly AdminModuleRegistry $registry)
    {
    }

    public function index(Request $request, string $module): View
    {
        $definition = $this->registry->get($module);
        $table = $definition['table'];
        $query = DB::table($table);

        $search = trim((string) $request->query('search'));
        if ($search !== '') {
            $searchColumns = array_values(array_intersect(
                $definition['search'] ?? [],
                $definition['columns']
            ));

            if ($searchColumns) {
                $query->where(function ($inner) use ($searchColumns, $search): void {
                    foreach ($searchColumns as $index => $column) {
                        $method = $index === 0 ? 'where' : 'orWhere';
                        $inner->{$method}($column, 'like', '%'.$search.'%');
                    }
                });
            }
        }

        $statusColumn = $this->registry->statusColumn($definition);
        $status = trim((string) $request->query('status'));
        if ($statusColumn && $status !== '') {
            $query->where($statusColumn, $this->normalizeFilterValue($status));
        }

        $sortColumn = $this->registry->dateColumn($definition) ?: 'id';
        $records = $query->orderByDesc($sortColumn)
            ->paginate(15)
            ->withQueryString();

        $displayFields = collect($definition['fields'])
            ->filter(fn (array $field): bool => !in_array($field['type'] ?? 'text', ['richtext', 'textarea', 'file'], true))
            ->take(4)
            ->values()
            ->all();

        return view('admin.content.index', compact(
            'definition',
            'module',
            'records',
            'displayFields',
            'statusColumn'
        ));
    }

    public function create(string $module): View
    {
        $definition = $this->registry->get($module);
        $this->registry->assertWritable($definition, 'create');

        return view('admin.content.form', [
            'definition' => $definition,
            'module' => $module,
            'record' => null,
            'gallery' => [],
        ]);
    }

    public function store(Request $request, string $module): RedirectResponse
    {
        $definition = $this->registry->get($module);
        $this->registry->assertWritable($definition, 'create');

        $validated = $request->validate($this->rules($definition, null));
        $data = $this->payload($request, $definition, $validated, null);

        if (in_array('created_at', $definition['columns'], true)) {
            $data['created_at'] = now();
        }
        if (in_array('updated_at', $definition['columns'], true)) {
            $data['updated_at'] = now();
        }

        $id = DB::table($definition['table'])->insertGetId($data);

        AdminActivity::record(
            'create',
            $module,
            (int) $id,
            "Created {$definition['singular']} #{$id}."
        );

        return redirect()
            ->route('admin.content.edit', [$module, $id])
            ->with('success', "{$definition['singular']} created successfully.");
    }

    public function show(string $module, int $id): View
    {
        $definition = $this->registry->get($module);
        $record = $this->findRecord($definition, $id);

        return view('admin.content.show', [
            'definition' => $definition,
            'module' => $module,
            'record' => $record,
            'gallery' => $this->gallery($definition, $id),
        ]);
    }

    public function edit(string $module, int $id): View
    {
        $definition = $this->registry->get($module);
        $record = $this->findRecord($definition, $id);

        return view('admin.content.form', [
            'definition' => $definition,
            'module' => $module,
            'record' => $record,
            'gallery' => $this->gallery($definition, $id),
        ]);
    }

    public function update(Request $request, string $module, int $id): RedirectResponse
    {
        $definition = $this->registry->get($module);
        $record = $this->findRecord($definition, $id);

        $validated = $request->validate($this->rules($definition, $id));
        $data = $this->payload($request, $definition, $validated, $record);

        if (in_array('updated_at', $definition['columns'], true)) {
            $data['updated_at'] = now();
        }

        if ($data) {
            DB::table($definition['table'])->where('id', $id)->update($data);
        }

        AdminActivity::record(
            'update',
            $module,
            $id,
            "Updated {$definition['singular']} #{$id}."
        );

        return redirect()
            ->route('admin.content.edit', [$module, $id])
            ->with('success', "{$definition['singular']} updated successfully.");
    }

    public function destroy(string $module, int $id): RedirectResponse
    {
        $definition = $this->registry->get($module);
        $this->registry->assertWritable($definition, 'delete');
        $record = $this->findRecord($definition, $id);

        foreach ($definition['fields'] as $field) {
            if (($field['type'] ?? null) !== 'image') {
                continue;
            }

            $path = $record->{$field['column']} ?? null;
            if ($path && !Str::startsWith((string) $path, ['http://', 'https://'])) {
                Storage::disk('public')->delete($this->storagePath((string) $path));
            }
        }

        DB::transaction(function () use ($definition, $id): void {
            $galleryTable = $definition['gallery_table'] ?? null;
            if ($galleryTable && Schema::hasTable($galleryTable)) {
                $foreignKey = $this->galleryForeignKey($galleryTable);
                if ($foreignKey) {
                    $images = DB::table($galleryTable)->where($foreignKey, $id)->get();
                    foreach ($images as $image) {
                        foreach (['image', 'image_path', 'path', 'image_url'] as $column) {
                            if (isset($image->{$column}) && $image->{$column}) {
                                Storage::disk('public')->delete($this->storagePath((string) $image->{$column}));
                                break;
                            }
                        }
                    }
                    DB::table($galleryTable)->where($foreignKey, $id)->delete();
                }
            }

            DB::table($definition['table'])->where('id', $id)->delete();
        });

        AdminActivity::record(
            'delete',
            $module,
            $id,
            "Deleted {$definition['singular']} #{$id}."
        );

        return redirect()
            ->route('admin.content.index', $module)
            ->with('success', "{$definition['singular']} deleted successfully.");
    }

    private function rules(array $definition, ?int $id): array
    {
        $rules = [];

        foreach ($definition['fields'] as $field) {
            $column = $field['column'];
            $type = $field['type'] ?? 'text';
            $isFile = in_array($type, ['image', 'file'], true);
            $required = (bool) ($field['required'] ?? false) && !$isFile;

            $fieldRules = [$required ? 'required' : 'nullable'];

            $fieldRules[] = match ($type) {
                'email' => 'email',
                'url' => 'url',
                'number' => 'numeric',
                'boolean' => 'boolean',
                'date' => 'date',
                'datetime-local' => 'date',
                'image' => 'image',
                'file' => 'file',
                default => 'string',
            };

            if ($type === 'image') {
                $fieldRules[] = 'max:5120';
                $fieldRules[] = 'mimes:jpg,jpeg,png,webp,gif';
            } elseif ($type === 'file') {
                $fieldRules[] = 'max:10240';
                $fieldRules[] = 'mimes:pdf,doc,docx';
            } elseif ($type === 'number') {
                if (isset($field['min'])) {
                    $fieldRules[] = 'min:'.$field['min'];
                }
                if (isset($field['max'])) {
                    $fieldRules[] = 'max:'.$field['max'];
                }
            } elseif ($type === 'select' && !empty($field['options'])) {
                $fieldRules[] = Rule::in(array_keys($field['options']));
            } else {
                $fieldRules[] = in_array($type, ['textarea', 'richtext'], true) ? 'max:100000' : 'max:2000';
            }

            $rules[$column] = $fieldRules;
        }

        return $rules;
    }

    private function payload(
        Request $request,
        array $definition,
        array $validated,
        ?object $existing
    ): array {
        $data = [];

        foreach ($definition['fields'] as $field) {
            $column = $field['column'];
            $type = $field['type'] ?? 'text';

            if (($field['readonly'] ?? false) === true) {
                continue;
            }

            if ($type === 'boolean') {
                $data[$column] = $request->boolean($column);
                continue;
            }

            if (in_array($type, ['image', 'file'], true)) {
                if (!$request->hasFile($column)) {
                    continue;
                }

                $oldPath = $existing?->{$column} ?? null;
                if ($oldPath && !Str::startsWith((string) $oldPath, ['http://', 'https://'])) {
                    Storage::disk('public')->delete($this->storagePath((string) $oldPath));
                }

                $data[$column] = $request->file($column)->store(
                    $this->registry->uploadDirectory($definition['key'], $column),
                    'public'
                );
                continue;
            }

            if (array_key_exists($column, $validated)) {
                $value = $validated[$column];

                if (is_string($value)) {
                    $value = trim($value);
                }

                $data[$column] = $value === '' ? null : $value;
            }
        }

        if (in_array('slug', $definition['columns'], true) && empty($data['slug'])) {
            $titleColumn = $this->registry->titleColumn($definition);
            $source = $data[$titleColumn] ?? ($existing?->{$titleColumn} ?? null);
            if ($source) {
                $data['slug'] = $this->uniqueSlug($definition['table'], Str::slug((string) $source), $existing?->id);
            }
        }

        return $data;
    }

    private function uniqueSlug(string $table, string $slug, ?int $ignoreId = null): string
    {
        $slug = $slug ?: Str::random(8);
        $candidate = $slug;
        $counter = 2;

        while (true) {
            $query = DB::table($table)->where('slug', $candidate);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }

            if (!$query->exists()) {
                return $candidate;
            }

            $candidate = $slug.'-'.$counter++;
        }
    }

    private function findRecord(array $definition, int $id): object
    {
        $record = DB::table($definition['table'])->where('id', $id)->first();
        abort_if(!$record, 404, "{$definition['singular']} not found.");

        return $record;
    }

    private function gallery(array $definition, int $id): array
    {
        $table = $definition['gallery_table'] ?? null;
        if (!$table || !Schema::hasTable($table)) {
            return [];
        }

        $foreignKey = $this->galleryForeignKey($table);
        if (!$foreignKey) {
            return [];
        }

        try {
            return DB::table($table)->where($foreignKey, $id)->orderBy('id')->get()->all();
        } catch (Throwable) {
            return [];
        }
    }

    private function galleryForeignKey(string $table): ?string
    {
        $columns = Schema::getColumnListing($table);
        foreach (['project_id', 'projectId'] as $column) {
            if (in_array($column, $columns, true)) {
                return $column;
            }
        }

        return null;
    }

    private function normalizeFilterValue(string $value): mixed
    {
        return match (strtolower($value)) {
            '1', 'true', 'active', 'yes' => $value === '1' ? 1 : $value,
            '0', 'false', 'inactive', 'no' => $value === '0' ? 0 : $value,
            default => $value,
        };
    }

    private function storagePath(string $path): string
    {
        $clean = ltrim($path, '/');

        return Str::startsWith($clean, 'storage/')
            ? Str::after($clean, 'storage/')
            : $clean;
    }
}
