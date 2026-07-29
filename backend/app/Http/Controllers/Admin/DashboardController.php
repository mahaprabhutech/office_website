<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminModuleRegistry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Throwable;

class DashboardController extends Controller
{
    public function __construct(private readonly AdminModuleRegistry $registry)
    {
    }

    public function index(): View
    {
        $modules = $this->registry->all();
        $cards = [];
        $attention = 0;

        foreach ($modules as $key => $module) {
            try {
                $count = DB::table($module['table'])->count();
                $cards[] = [
                    'key' => $key,
                    'label' => $module['label'],
                    'description' => $module['description'] ?? '',
                    'icon' => $module['icon'] ?? 'folder',
                    'count' => $count,
                ];

                if (in_array($key, ['enquiries', 'job-applications', 'quotations'], true)) {
                    $columns = Schema::getColumnListing($module['table']);
                    if (in_array('status', $columns, true)) {
                        $attention += DB::table($module['table'])
                            ->whereRaw('LOWER(status) IN (?, ?)', ['new', 'pending'])
                            ->count();
                    }
                }
            } catch (Throwable) {
                // One unavailable module must not break the whole dashboard.
            }
        }

        $recentItems = $this->recentItems($modules);
        $activities = $this->recentActivities();

        return view('admin.dashboard.index', [
            'cards' => $cards,
            'attention' => $attention,
            'recentItems' => $recentItems,
            'activities' => $activities,
            'availableModules' => $modules,
        ]);
    }

    private function recentItems(array $modules): array
    {
        $items = [];

        foreach ($modules as $key => $module) {
            try {
                $resolved = $this->registry->get($key);
                $dateColumn = $this->registry->dateColumn($resolved);
                $titleColumn = $this->registry->titleColumn($resolved);

                if (!$dateColumn) {
                    continue;
                }

                $rows = DB::table($resolved['table'])
                    ->select(array_values(array_unique(array_filter(['id', $titleColumn, $dateColumn]))))
                    ->orderByDesc($dateColumn)
                    ->limit(3)
                    ->get();

                foreach ($rows as $row) {
                    $items[] = [
                        'module' => $key,
                        'module_label' => $module['label'],
                        'id' => $row->id,
                        'title' => (string) ($row->{$titleColumn} ?? '#'.$row->id),
                        'date' => $row->{$dateColumn} ?? null,
                    ];
                }
            } catch (Throwable) {
                continue;
            }
        }

        usort($items, fn (array $a, array $b): int => strtotime((string) $b['date']) <=> strtotime((string) $a['date']));

        return array_slice($items, 0, 8);
    }

    private function recentActivities(): array
    {
        if (!Schema::hasTable('admin_activity_logs')) {
            return [];
        }

        try {
            $query = DB::table('admin_activity_logs as logs')
                ->select(['logs.*']);

            if (Schema::hasTable('users')) {
                $query->leftJoin('users', 'users.id', '=', 'logs.user_id')
                    ->addSelect('users.name as user_name');
            }

            return $query->orderByDesc('logs.id')->limit(8)->get()->all();
        } catch (Throwable) {
            return [];
        }
    }
}
