<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUsersSeeder extends Seeder
{
    /**
     * Seed one super admin and one admin user.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@clydepixel.com'],
            [
                'name' => 'Super Admin',
                'role' => 0,
                'phone_number' => '0000000000',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@clydepixel.com'],
            [
                'name' => 'Admin',
                'role' => 1,
                'phone_number' => '0000000001',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
