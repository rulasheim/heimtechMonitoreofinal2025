<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Evitar duplicados
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Administrador del Sistema',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('yo123456'), // 🔥 Cambia si quieres
                'role' => 'administrador',
                'is_active' => true,
            ]);
        }
    }
}
