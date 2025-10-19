<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batiment;
use App\Models\ZoneUrbaine;

class BatimentSeeder extends Seeder
{
    public function run(): void
    {
        // Créer des zones si elles n'existent pas
        $zones = [
            ['nom' => 'Zone Industrielle', 'population' => 5000, 'surface' => 150.5, 'niveau_pollution' => 7.2, 'nb_arbres_exist' => 200, 'superficie' => 150.5],
            ['nom' => 'Quartier Résidentiel', 'population' => 8000, 'surface' => 200.0, 'niveau_pollution' => 3.1, 'nb_arbres_exist' => 500, 'superficie' => 200.0],
            ['nom' => 'Centre Ville', 'population' => 12000, 'surface' => 80.0, 'niveau_pollution' => 8.5, 'nb_arbres_exist' => 150, 'superficie' => 80.0],
        ];

        foreach ($zones as $zone) {
            ZoneUrbaine::firstOrCreate($zone);
        }

        // Créer des bâtiments de test avec différents types et états
        $batiments = [
            [
                'type_batiment' => 'Maison',
                'adresse' => '123 Rue de Tunis',
                'emission_c_o2' => 2.5,
                'nb_habitants' => 4,
                'pourcentage_renouvelable' => 30.0,
                'emission_reelle' => 1.75,
                'zone_id' => 1,
                'etat' => 'tunis',
                'type_zone_urbaine' => 'zone_industrielle',
                'recyclage_data' => ['produit_recycle' => ['papier', 'plastique'], 'quantites' => ['papier' => 50, 'plastique' => 30]],
                'energies_renouvelables_data' => ['panneaux_solaires' => ['check' => true, 'nb' => 10]],
            ],
            [
                'type_batiment' => 'Usine',
                'adresse' => '456 Avenue Industrielle',
                'emission_c_o2' => 15.0,
                'nb_employes' => 150,
                'type_industrie' => 'Textile',
                'pourcentage_renouvelable' => 20.0,
                'emission_reelle' => 12.0,
                'zone_id' => 1,
                'etat' => 'ariana',
                'type_zone_urbaine' => 'zone_industrielle',
                'recyclage_data' => ['produit_recycle' => ['metal', 'plastique'], 'quantites' => ['metal' => 200, 'plastique' => 100]],
                'energies_renouvelables_data' => ['voitures_electriques' => ['check' => true, 'nb' => 5]],
            ],
            [
                'type_batiment' => 'Maison',
                'adresse' => '789 Boulevard du Lac',
                'emission_c_o2' => 3.2,
                'nb_habitants' => 6,
                'pourcentage_renouvelable' => 45.0,
                'emission_reelle' => 1.76,
                'zone_id' => 2,
                'etat' => 'ben_arous',
                'type_zone_urbaine' => 'quartier_residentiel',
                'recyclage_data' => ['produit_recycle' => ['papier', 'verre'], 'quantites' => ['papier' => 25, 'verre' => 40]],
                'energies_renouvelables_data' => ['panneaux_solaires' => ['check' => true, 'nb' => 15], 'voitures_electriques' => ['check' => true, 'nb' => 2]],
            ],
            [
                'type_batiment' => 'Usine',
                'adresse' => '321 Route de Sousse',
                'emissionCO2' => 8.5,
                'nbEmployes' => 75,
                'typeIndustrie' => 'Alimentaire',
                'pourcentageRenouvelable' => 60.0,
                'emissionReelle' => 3.4,
                'zone_id' => 2,
                'etat' => 'sousse',
                'type_zone_urbaine' => 'quartier_residentiel',
                'recyclage_data' => ['produit_recycle' => ['organique', 'plastique'], 'quantites' => ['organique' => 300, 'plastique' => 80]],
                'energies_renouvelables_data' => ['energie_eolienne' => ['check' => true, 'nb' => 3]],
            ],
            [
                'type_batiment' => 'Maison',
                'adresse' => '654 Avenue Habib Bourguiba',
                'emissionCO2' => 1.8,
                'nbHabitants' => 3,
                'pourcentageRenouvelable' => 25.0,
                'emissionReelle' => 1.35,
                'zone_id' => 3,
                'etat' => 'sfax',
                'type_zone_urbaine' => 'centre_ville',
                'recyclage_data' => ['produit_recycle' => ['papier'], 'quantites' => ['papier' => 20]],
                'energies_renouvelables_data' => [],
            ],
        ];

        foreach ($batiments as $batiment) {
            Batiment::create($batiment);
        }
    }
}