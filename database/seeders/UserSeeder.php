<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        $users = [
            ['name' => 'imshof', 'username' => 'imshof'],
            ['name' => 'yuslih', 'username' => 'yuslih'],
            ['name' => 'rahmat', 'username' => 'rahmat'],
        ];

        for ($i = 1; $i <= 46; $i++) {
            $number = str_pad((string) $i, 2, '0', STR_PAD_LEFT);

            $users[] = [
                'name' => 'Pegawai ' . $number,
                'username' => 'pegawai' . $number,
            ];
        }

        foreach ($users as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password'),
                    'role' => 'user',
                ]
            );
        }
    }
}
