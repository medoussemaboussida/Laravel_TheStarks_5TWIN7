<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Evenement;
use App\Models\Inscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $citoyens = User::where('role', 'citoyen')->get();
        $evenements = Evenement::all();

        $commentaires = [
            'Très motivé(e) pour participer à ce projet !',
            'J\'aimerais apprendre les techniques de jardinage urbain.',
            'Passionné(e) d\'écologie, je souhaite contribuer.',
            'Première participation, j\'ai hâte de découvrir !',
            'Je veux aider à verdir ma ville.',
            'Expérience en jardinage, prêt(e) à partager mes connaissances.',
            'Sensible aux enjeux environnementaux.',
            null, // Pas de commentaire
            'Disponible tout le week-end si besoin.',
            'J\'amène mes propres outils de jardinage.',
        ];

        foreach ($evenements as $evenement) {
            // Inscrire entre 2 et 8 citoyens par événement
            $nombreInscriptions = rand(2, min(8, $citoyens->count()));
            $citoyensInscrits = $citoyens->random($nombreInscriptions);

            foreach ($citoyensInscrits as $citoyen) {
                $statut = ['confirmee', 'en_attente', 'confirmee', 'confirmee'][rand(0, 3)]; // Plus de confirmées

                Inscription::create([
                    'user_id' => $citoyen->id,
                    'evenement_id' => $evenement->id,
                    'statut' => $statut,
                    'commentaire' => $commentaires[array_rand($commentaires)],
                    'date_inscription' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
