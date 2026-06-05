<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\AdminAccount;

class AdminAccountSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Create a default admin account for local/dev testing
        AdminAccount::create([
            'email' => 'info@hanahubuki.jp',
            'password' => Hash::make('password'),
            'name' => 'Administrator',
            'admin_note' => 'Seeded admin account',
            'account_status_master_id' => 200,
            'is_email_verified' => 1,
            'password_changed_at' => $now->format('Y-m-d H:i:s'),
            'password_expires_at' => $now->copy()->addYear()->format('Y-m-d H:i:s'),
            'created_at' => $now->format('Y-m-d H:i:s'),
            'modified_at' => $now->format('Y-m-d H:i:s'),
        ]);
    }
}
