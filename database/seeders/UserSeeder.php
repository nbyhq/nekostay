<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@nekostay.com'],
            ['name' => 'Sarah Jenkins', 'password' => bcrypt('password')]
        );
        $admin->assignRole('admin');

        $staff = User::firstOrCreate(
            ['email' => 'staff@nekostay.com'],
            ['name' => 'Marcus Thorne', 'password' => bcrypt('password')]
        );
        $staff->assignRole('staff');
    }
}
