<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Créer l'administrateur
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@datacenter.com',
            'password' => Hash::make('password'), // Mot de passe: password
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Créer un invité pour tester
        User::create([
            'name' => 'Invité Test',
            'email' => 'guest@test.com',
            'password' => Hash::make('password'),
            'role' => 'guest',
            'is_active' => true,
        ]);
    }
}
