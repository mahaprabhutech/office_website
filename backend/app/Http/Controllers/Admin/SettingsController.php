<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        [$keyColumn, $valueColumn] = $this->columns();

        $values = [];
        if ($keyColumn && $valueColumn) {
            $values = DB::table('site_settings')
                ->pluck($valueColumn, $keyColumn)
                ->map(fn ($value) => (string) $value)
                ->all();
        }

        $settings = config('site_admin.settings', []);
        $groups = collect($settings)->groupBy('group');

        return view('admin.settings.index', compact(
            'settings',
            'groups',
            'values',
            'keyColumn',
            'valueColumn'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        [$keyColumn, $valueColumn] = $this->columns();
        abort_unless($keyColumn && $valueColumn, 422, 'Unsupported site_settings table structure.');

        $definitions = config('site_admin.settings', []);
        $rules = [];

        foreach ($definitions as $key => $definition) {
            $rules[$key] = [
                'nullable',
                match ($definition['type'] ?? 'text') {
                    'email' => 'email',
                    'url' => 'url',
                    default => 'string',
                },
                'max:10000',
            ];
        }

        $validated = $request->validate($rules);
        $columns = Schema::getColumnListing('site_settings');

        DB::transaction(function () use ($validated, $keyColumn, $valueColumn, $columns, $definitions): void {
            foreach ($validated as $key => $value) {
                $existing = DB::table('site_settings')->where($keyColumn, $key)->first();
                $definition = $definitions[$key] ?? [];

                $data = [$valueColumn => $value];
                if (in_array('updated_at', $columns, true)) {
                    $data['updated_at'] = now();
                }

                if ($existing) {
                    DB::table('site_settings')->where($keyColumn, $key)->update($data);
                    continue;
                }

                $data[$keyColumn] = $key;

                foreach (['type', 'setting_type', 'input_type'] as $typeColumn) {
                    if (in_array($typeColumn, $columns, true)) {
                        $data[$typeColumn] = $definition['type'] ?? 'text';
                        break;
                    }
                }

                foreach (['group', 'setting_group', 'category'] as $groupColumn) {
                    if (in_array($groupColumn, $columns, true)) {
                        $data[$groupColumn] = $definition['group'] ?? 'General';
                        break;
                    }
                }

                if (in_array('label', $columns, true)) {
                    $data['label'] = $definition['label'] ?? \Illuminate\Support\Str::headline($key);
                }
                if (in_array('is_active', $columns, true)) {
                    $data['is_active'] = 1;
                }
                if (in_array('created_at', $columns, true)) {
                    $data['created_at'] = now();
                }
                DB::table('site_settings')->insert($data);
            }
        });

        AdminActivity::record('update', 'site-settings', null, 'Updated website settings.');

        return back()->with('success', 'Website settings saved successfully.');
    }

    private function columns(): array
    {
        if (!Schema::hasTable('site_settings')) {
            return [null, null];
        }

        $columns = Schema::getColumnListing('site_settings');
        $keyColumn = collect(['key', 'setting_key', 'setting_name', 'name'])->first(fn ($column) => in_array($column, $columns, true));
        $valueColumn = collect(['value', 'setting_value', 'content'])->first(fn ($column) => in_array($column, $columns, true));

        return [$keyColumn, $valueColumn];
    }
}
