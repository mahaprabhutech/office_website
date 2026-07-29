<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('users')) {
            $this->command?->error('The users table does not exist. Run the main project migrations first.');
            return;
        }

        $email = env('ADMIN_EMAIL', 'admin@mahaprabhutech.online');
        $password = env('ADMIN_PASSWORD', 'ChangeMe@2026!');
        $name = env('ADMIN_NAME', 'Website Administrator');

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ];

        if (Schema::hasColumn('users', 'role')) {
            $data['role'] = 'super_admin';
        }
        if (Schema::hasColumn('users', 'status')) {
            $data['status'] = 'active';
        }
        if (Schema::hasColumn('users', 'email_verified_at')) {
            $data['email_verified_at'] = now();
        }
        if (Schema::hasColumn('users', 'updated_at')) {
            $data['updated_at'] = now();
        }

        $existing = DB::table('users')->where('email', $email)->first();

        if ($existing) {
            DB::table('users')->where('id', $existing->id)->update($data);
        } else {
            if (Schema::hasColumn('users', 'created_at')) {
                $data['created_at'] = now();
            }
            DB::table('users')->insert($data);
        }

        $this->command?->info("Admin user ready: {$email}");
    }
}
