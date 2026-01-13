<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\User::updateOrCreate(
        ['email' => 'admin.utama@rsudbhakti.com'],
        [
            'name' => 'Admin Utama',
            'password' => Hash::make('password123'),
            'role' => 'admin_utama',
        ]
    );
}
}
