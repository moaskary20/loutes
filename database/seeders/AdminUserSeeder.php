<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'admin@loutes.test'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
            ],
        );
    }
}

