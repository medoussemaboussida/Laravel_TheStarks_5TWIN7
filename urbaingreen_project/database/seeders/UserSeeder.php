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
        // Créer un administrateur
        User::create([
            'name' => 'Admin UrbanGreen',
            'email' => 'admin@urbangreen.fr',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'telephone' => '+33 1 23 45 67 89',
            'adresse' => '123 Rue de la Végétalisation, 75001 Paris',
            'email_verified_at' => now(),
        ]);

        // Créer un chef de projet
        User::create([
            'name' => 'Marie Dubois',
            'email' => 'marie.dubois@urbangreen.fr',
            'password' => Hash::make('password'),
            'role' => 'chef_projet',
            'telephone' => '+33 1 23 45 67 90',
            'adresse' => '456 Avenue des Jardins, 75002 Paris',
            'email_verified_at' => now(),
        ]);

        // Créer un autre chef de projet
        User::create([
            'name' => 'Pierre Martin',
            'email' => 'pierre.martin@urbangreen.fr',
            'password' => Hash::make('password'),
            'role' => 'chef_projet',
            'telephone' => '+33 1 23 45 67 91',
            'adresse' => '789 Boulevard Vert, 75003 Paris',
            'email_verified_at' => now(),
        ]);

        // Créer des citoyens
        $citoyens = [
            [
                'name' => 'Sophie Leroy',
                'email' => 'sophie.leroy@example.com',
                'telephone' => '+33 6 12 34 56 78',
                'adresse' => '12 Rue des Fleurs, 75004 Paris',
            ],
            [
                'name' => 'Thomas Rousseau',
                'email' => 'thomas.rousseau@example.com',
                'telephone' => '+33 6 12 34 56 79',
                'adresse' => '34 Avenue de la Nature, 75005 Paris',
            ],
            [
                'name' => 'Julie Moreau',
                'email' => 'julie.moreau@example.com',
                'telephone' => '+33 6 12 34 56 80',
                'adresse' => '56 Place de l\'Écologie, 75006 Paris',
            ],
            [
                'name' => 'Antoine Durand',
                'email' => 'antoine.durand@example.com',
                'telephone' => '+33 6 12 34 56 81',
                'adresse' => '78 Rue du Développement Durable, 75007 Paris',
            ],
            [
                'name' => 'Camille Bernard',
                'email' => 'camille.bernard@example.com',
                'telephone' => '+33 6 12 34 56 82',
                'adresse' => '90 Boulevard de la Biodiversité, 75008 Paris',
            ],
        ];

        foreach ($citoyens as $citoyen) {
            User::create([
                'name' => $citoyen['name'],
                'email' => $citoyen['email'],
                'password' => Hash::make('password'),
                'role' => 'citoyen',
                'telephone' => $citoyen['telephone'],
                'adresse' => $citoyen['adresse'],
                'email_verified_at' => now(),
            ]);
        }
    }
}
