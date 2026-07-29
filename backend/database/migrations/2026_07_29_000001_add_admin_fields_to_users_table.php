<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        $addRole = !Schema::hasColumn('users', 'role');
        $addStatus = !Schema::hasColumn('users', 'status');
        $addLastLogin = !Schema::hasColumn('users', 'last_login_at');

        Schema::table('users', function (Blueprint $table) use ($addRole, $addStatus, $addLastLogin): void {
            if ($addRole) {
                $table->string('role', 30)->default('user')->index();
            }
            if ($addStatus) {
                $table->string('status', 20)->default('active')->index();
            }
            if ($addLastLogin) {
                $table->timestamp('last_login_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        $drop = [];
        foreach (['role', 'status', 'last_login_at'] as $column) {
            if (Schema::hasColumn('users', $column)) {
                $drop[] = $column;
            }
        }

        if ($drop) {
            Schema::table('users', fn (Blueprint $table) => $table->dropColumn($drop));
        }
    }
};
