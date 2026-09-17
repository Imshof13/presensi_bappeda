<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'imshof',
            'username' => 'imshof',
            'password' => 'password123',
            'role' => 'user',
        ]);

        User::create([
            'name' => 'yuslis',
            'username' => 'yuslih',
            'password' => 'password123',
            'role' => 'user',
        ]);

        User::create([
            'name' => 'rahmat',
            'username' => 'rahmat',
            'password' => 'password123',
            'role' => 'user',
        ]);
    }
}