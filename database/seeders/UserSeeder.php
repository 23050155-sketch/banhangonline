<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => '123456',
                'role' => 'admin',
                'status' => 1,
                'phone' => '0900000000',
                'address' => 'Admin Address',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'password' => '123456',
                'role' => 'customer',
                'status' => 1,
                'phone' => '0911111111',
                'address' => 'User Address',
            ]
        );
    }
}
