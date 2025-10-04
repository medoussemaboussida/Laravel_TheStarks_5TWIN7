<?php

namespace Database\Seeders;

use App\Models\Projet;
use App\Models\Evenement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjetEvenementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 10 projets avec des événements associés
        Projet::factory(10)->create()->each(function ($projet) {
            // Chaque projet aura entre 1 et 5 événements
            Evenement::factory(rand(1, 5))->create([
                'projet_id' => $projet->id
            ]);
        });

        // Créer quelques projets spécifiques pour UrbanGreen
        $projetsSpecifiques = [
            [
                'nom' => 'Jardin Communautaire Centre-Ville',
                'description' => 'Création d\'un jardin communautaire au cœur de la ville pour sensibiliser les citoyens à l\'agriculture urbaine et créer un espace de convivialité.',
                'date_debut' => now()->subMonths(2),
                'date_fin' => now()->addMonths(4),
                'statut' => 'en_cours',
                'budget' => 15000.00,
                'localisation' => 'Place de la République, Centre-ville'
            ],
            [
                'nom' => 'Toitures Végétalisées Écoles',
                'description' => 'Installation de toitures végétalisées dans 5 écoles primaires pour améliorer l\'isolation thermique et créer des espaces pédagogiques.',
                'date_debut' => now()->addMonth(),
                'date_fin' => now()->addMonths(8),
                'statut' => 'planifie',
                'budget' => 45000.00,
                'localisation' => 'Quartier des Écoles'
            ],
            [
                'nom' => 'Murs Végétaux Gare',
                'description' => 'Création de murs végétaux dans la gare principale pour améliorer la qualité de l\'air et l\'esthétique du lieu.',
                'date_debut' => now()->subMonths(6),
                'date_fin' => now()->subMonth(),
                'statut' => 'termine',
                'budget' => 25000.00,
                'localisation' => 'Gare Centrale'
            ]
        ];

        foreach ($projetsSpecifiques as $projetData) {
            $projet = Projet::create($projetData);

            // Créer des événements spécifiques pour chaque projet
            $evenements = [
                [
                    'nom' => 'Réunion de lancement',
                    'description' => 'Première réunion avec les parties prenantes pour définir les objectifs et la planification.',
                    'date_debut' => $projet->date_debut,
                    'date_fin' => $projet->date_debut->copy()->addHours(2),
                    'lieu' => 'Mairie - Salle de conférence',
                    'nombre_participants_max' => 30,
                    'statut' => 'termine'
                ],
                [
                    'nom' => 'Atelier participatif',
                    'description' => 'Atelier avec les citoyens pour recueillir leurs idées et besoins.',
                    'date_debut' => $projet->date_debut->copy()->addWeeks(2),
                    'date_fin' => $projet->date_debut->copy()->addWeeks(2)->addHours(3),
                    'lieu' => $projet->localisation,
                    'nombre_participants_max' => 50,
                    'statut' => $projet->statut === 'termine' ? 'termine' : 'planifie'
                ]
            ];

            foreach ($evenements as $evenementData) {
                $evenementData['projet_id'] = $projet->id;
                Evenement::create($evenementData);
            }
        }
    }
}
