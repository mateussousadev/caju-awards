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

        // Criar usuários normais
        $users = [
            ['name' => 'João Silva', 'email' => 'joao.silva@example.com'],
            ['name' => 'Maria Santos', 'email' => 'maria.santos@example.com'],
            ['name' => 'Pedro Oliveira', 'email' => 'pedro.oliveira@example.com'],
            ['name' => 'Ana Costa', 'email' => 'ana.costa@example.com'],
            ['name' => 'Carlos Souza', 'email' => 'carlos.souza@example.com'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]);
        }
    }
}
