<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class AdminActivity
{
    public static function record(
        string $action,
        ?string $module = null,
        ?int $recordId = null,
        ?string $description = null,
        array $metadata = []
    ): void {
        try {
            if (!Schema::hasTable('admin_activity_logs')) {
                return;
            }

            DB::table('admin_activity_logs')->insert([
                'user_id' => session('admin_user_id'),
                'action' => $action,
                'module' => $module,
                'record_id' => $recordId,
                'description' => $description,
                'ip_address' => request()->ip(),
                'user_agent' => substr((string) request()->userAgent(), 0, 1000),
                'metadata' => $metadata ? json_encode($metadata) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (Throwable) {
            // Activity logging must never interrupt the requested admin action.
        }
    }
}
