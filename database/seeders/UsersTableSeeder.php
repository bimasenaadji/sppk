<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            'name' => 'Admin K3',
            'position' => 'K3 Officer',
            'phone' => '08123456789',
            'email' => 'admink3@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Pelapor 1',
            'position' => 'Staff',
            'phone' => '08234567890',
            'email' => 'pelapor1@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
