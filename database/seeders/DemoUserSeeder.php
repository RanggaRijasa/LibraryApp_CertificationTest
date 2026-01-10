<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'staff@test.com'],
            ['name' => 'Petugas', 'password' => Hash::make('password'), 'role' => 'staff']
        );

        User::updateOrCreate(
            ['email' => 'member@test.com'],
            ['name' => 'Anggota', 'password' => Hash::make('password'), 'role' => 'member', 'member_no' => 'M-0001']
        );
    }
}
