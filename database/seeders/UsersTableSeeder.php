<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
{
    DB::table('users')->insert([
        [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '1234567890',
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Participant User',
            'email' => 'participant@example.com',
            'password' => Hash::make('password'),
            'role' => 'participant',
            'phone' => '0987654321',
            'address' => 'Jalan jalan mulu',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}
}
