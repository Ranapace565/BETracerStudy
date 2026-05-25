<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'Rana Admin',
            'email' => 'admin@polije.ac.id',
            'password' => Hash::make('password123'), // Ganti sesuai keinginan
            'role' => 'admin',
        ]);
    }
}
