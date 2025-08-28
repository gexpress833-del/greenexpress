<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Green Express',
            'email' => 'admin@greenexpress.fr',
            'phone' => '+33 1 23 45 67 89',
            'address' => '123 Rue de la Paix, 75001 Paris',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Clients
        User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@email.com',
            'phone' => '+33 6 12 34 56 78',
            'address' => '456 Avenue des Champs, 75008 Paris',
            'role' => 'client',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Marie Martin',
            'email' => 'marie.martin@email.com',
            'phone' => '+33 6 98 76 54 32',
            'address' => '789 Boulevard Saint-Germain, 75006 Paris',
            'role' => 'client',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Pierre Durand',
            'email' => 'pierre.durand@email.com',
            'phone' => '+33 6 11 22 33 44',
            'address' => '321 Rue de Rivoli, 75001 Paris',
            'role' => 'client',
            'password' => Hash::make('password'),
        ]);

        // Drivers
        User::create([
            'name' => 'Lucas Bernard',
            'email' => 'lucas.bernard@greenexpress.fr',
            'phone' => '+33 6 55 66 77 88',
            'address' => '654 Rue de la République, 75011 Paris',
            'role' => 'driver',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Thomas Moreau',
            'email' => 'thomas.moreau@greenexpress.fr',
            'phone' => '+33 6 99 88 77 66',
            'address' => '987 Avenue de la Nation, 75012 Paris',
            'role' => 'driver',
            'password' => Hash::make('password'),
        ]);

        // Créer des utilisateurs supplémentaires
        User::factory(10)->create();
    }
}
