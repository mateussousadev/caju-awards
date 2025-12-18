<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@cajuawards.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}
