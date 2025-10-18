<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Batiment;
use App\Models\ZoneUrbaine;
class BatimentController extends Controller
{
    public function __construct()
    {
        // No constructor needed for Eloquent
    }

    // Affiche la vue frontoffice pour /batiments
    public function index()
    {
        if (request()->is('backoffice/indexbatiment')) {
            $batiments = Batiment::all();
            $zones = ZoneUrbaine::all();
            return view('admin.batiments.index', compact('batiments', 'zones'));
        } else {
            $batiments = Batiment::all();
            return view('batiments.index', compact('batiments'));
        }
    }

    // Mise à jour depuis le backoffice (modal admin)
    public function updateBackoffice(Request $request, $id)
    {
        $b = Batiment::find($id);

        if (!$b) {
            return redirect()->route('backoffice.indexbatiment')->with('error', 'Bâtiment introuvable.');
        }

        // --- Zone associée ---
        if ($request->zone_id) {
            $zone = ZoneUrbaine::find($request->zone_id);
            if ($zone) {
                $b->zone()->associate($zone);
            }
        }

        // --- Type de bâtiment ---
        $b->type_batiment = $request->type_batiment;
        $b->adresse = $request->adresse;

        if ($request->type_batiment === 'Maison') {
            $b->nbHabitants = $request->nbHabitants;
            $b->nbEmployes = null;
            $b->typeIndustrie = null;
        } elseif ($request->type_batiment === 'Usine') {
            $b->nbHabitants = null;
            $b->nbEmployes = $request->nbEmployes;
            $b->typeIndustrie = $request->typeIndustrie;
        }

        // --- FACTEURS CO2 ---
        $factors = [
            'voiture'      => 2.3,
            'moto'         => 0.5,
            'bus'          => 10.0,
            'avion'        => 0.5,
            'fumeur'       => 0.15,
            'electricite'  => 1.5,
            'gaz'          => 1.2,
            'clim'         => 1.0,
            'machine'      => 3.0,
            'camion'       => 3.5,
        ];

        $emission = 0.0;
        if ($request->has('emissions')) {
            foreach ($request->emissions as $key => $data) {
                if (isset($data['check']) && $data['check'] == 1) {
                    $nb = (int)($data['nb'] ?? 0);
                    $emission += $nb * ($factors[$key] ?? 0);
                }
            }
        }

        $b->emissionCO2 = $emission;

        // --- Calcul pourcentage renouvelable ---
        $pourcentageRenouvelable = 0.0;
        $renewableFactors = [
            'panneaux_solaires' => 15.0,      // % de réduction par panneau solaire
            'voitures_electriques' => 8.0,    // % de réduction par voiture électrique
            'camions_electriques' => 12.0,    // % de réduction par camion électrique
            'energie_eolienne' => 25.0,       // % de réduction par éolienne
            'energie_hydroelectrique' => 20.0, // % de réduction par installation hydro
        ];

        if ($request->has('energies_renouvelables')) {
            foreach ($request->energies_renouvelables as $key => $data) {
                if (isset($data['check']) && $data['check'] == 1) {
                    $nb = (int)($data['nb'] ?? 0);
                    $pourcentageRenouvelable += $nb * ($renewableFactors[$key] ?? 0);
                }
            }
        }

        // Limiter le pourcentage à 100%
        $pourcentageRenouvelable = min($pourcentageRenouvelable, 100.0);
        $b->pourcentageRenouvelable = $pourcentageRenouvelable;

        // --- Traitement des données de recyclage ---
        $recyclageData = null;
        if ($request->has('recyclage') && isset($request->recyclage['existe']) && $request->recyclage['existe'] == 1) {
            $recyclageData = [
                'existe' => true,
                'produit_recycle' => $request->recyclage['produit_recycle'] ?? [],
                'quantites' => $request->recyclage['quantites'] ?? []
            ];
        }

        $b->recyclage_data = $recyclageData ? json_encode($recyclageData) : null;

        $b->save();

        return redirect()->route('backoffice.indexbatiment')
                         ->with('success', 'Bâtiment mis à jour avec succès.');
    }

    public function create()
    {
        $zones = ZoneUrbaine::all();
        return view('batiments.create', compact('zones'));
    }

    public function update(Request $request, $id)
    {
        $b = Batiment::find($id);

        if (!$b) {
            return redirect()->route('batiments.index')->with('error', 'Bâtiment introuvable.');
        }

        // --- Zone associée ---
        if ($request->zone_id) {
            $zone = ZoneUrbaine::find($request->zone_id);
            if ($zone) {
                $b->zone()->associate($zone);
            }
        }

        // --- Type de bâtiment ---
        $b->type_batiment = $request->type_batiment;
        $b->adresse = $request->adresse;
        $b->etat = $request->etat;
        $b->type_zone_urbaine = $request->type_zone_urbaine;

        if ($request->type_batiment === 'Maison') {
            $b->nbHabitants = $request->nbHabitants;
            $b->nbEmployes = null;
            $b->typeIndustrie = null;
        } elseif ($request->type_batiment === 'Usine') {
            $b->nbHabitants = null;
            $b->nbEmployes = $request->nbEmployes;
            $b->typeIndustrie = $request->typeIndustrie;
        }

        // --- FACTEURS CO2 ---
        $factors = [
            'voiture'      => 2.3,
            'moto'         => 0.5,
            'bus'          => 10.0,
            'avion'        => 0.5,
            'fumeur'       => 0.15,
            'electricite'  => 1.5,
            'gaz'          => 1.2,
            'clim'         => 1.0,
            'machine'      => 3.0,
            'camion'       => 3.5,
        ];

        $emission = 0.0;
        if ($request->has('emissions')) {
            foreach ($request->emissions as $key => $data) {
                if (isset($data['check']) && $data['check'] == 1) {
                    $nb = (int)($data['nb'] ?? 0);
                    $emission += $nb * ($factors[$key] ?? 0);
                }
            }
        }

        $b->emissionCO2 = $emission;

        // --- Calcul pourcentage renouvelable ---
        $pourcentageRenouvelable = 0.0;
        $renewableFactors = [
            'panneaux_solaires' => 15.0,      // % de réduction par panneau solaire
            'voitures_electriques' => 8.0,    // % de réduction par voiture électrique
            'camions_electriques' => 12.0,    // % de réduction par camion électrique
            'energie_eolienne' => 25.0,       // % de réduction par éolienne
            'energie_hydroelectrique' => 20.0, // % de réduction par installation hydro
        ];

        if ($request->has('energies_renouvelables')) {
            foreach ($request->energies_renouvelables as $key => $data) {
                if (isset($data['check']) && $data['check'] == 1) {
                    $nb = (int)($data['nb'] ?? 0);
                    $pourcentageRenouvelable += $nb * ($renewableFactors[$key] ?? 0);
                }
            }
        }

        // Limiter le pourcentage à 100%
        $pourcentageRenouvelable = min($pourcentageRenouvelable, 100.0);
        $b->pourcentageRenouvelable = $pourcentageRenouvelable;

        // --- Traitement des données de recyclage ---
        $recyclageData = null;
        if ($request->has('recyclage') && isset($request->recyclage['existe']) && $request->recyclage['existe'] == 1) {
            $recyclageData = [
                'existe' => true,
                'produit_recycle' => $request->recyclage['produit_recycle'] ?? [],
                'quantite_recyclee' => (float)($request->recyclage['quantite_recyclee'] ?? 0)
            ];
        }

        $b->recyclage_data = $recyclageData ? json_encode($recyclageData) : null;

        $b->save();

        return redirect()->route('batiments.index')
                         ->with('success', 'Bâtiment mis à jour avec succès.');
    }

    public function store(Request $request)
    {
        $b = new Batiment();

        // --- Associer la zone choisie ---
        if ($request->zone_id) {
            $zone = ZoneUrbaine::find($request->zone_id);
            if ($zone) {
                $b->zone()->associate($zone);
            }
        }

        // --- Type de bâtiment ---
        $b->type_batiment = $request->type_batiment;
        $b->adresse = $request->adresse;
        $b->type_zone_urbaine = $request->type_zone_urbaine;

        if ($request->type_batiment === 'Maison') {
            $b->nbHabitants = $request->nbHabitants;
            $b->nbEmployes = null;
            $b->typeIndustrie = null;
        } elseif ($request->type_batiment === 'Usine') {
            $b->nbHabitants = null;
            $b->nbEmployes = $request->nbEmployes;
            $b->typeIndustrie = $request->typeIndustrie;
        }

        // --- FACTEURS CO2 (t/an par unité mensuelle) ---
        $factors = [
            'voiture'      => 1.44,  // t/an per km/mois (0.12 kg/km * 12)
            'moto'         => 0.96,  // t/an per km/mois (0.08 kg/km * 12)
            'bus'          => 0.6,   // t/an per km/mois (0.05 kg/km * 12)
            'avion'        => 1.8,   // t/an per km/mois (0.15 kg/km * 12)
            'fumeur'       => 0.24,  // t/an per pack/mois (0.02 t/an per pack * 12)
            'electricite'  => 0.0048, // t/an per kWh/mois (0.0004 t/kWh * 12)
            'gaz'          => 0.0024, // t/an per kWh/mois (0.0002 t/kWh * 12)
            'clim'         => 0.0048, // t/an per kWh/mois
            'machine'      => 0.0048, // assume kWh/mois
            'camion'       => 3.6,   // t/an per km/mois (0.3 kg/km * 12)
        ];

        // --- Calcul émission CO2 ---
        $emission = 0.0;
        if ($request->has('emissions')) {
            foreach ($request->emissions as $key => $data) {
                if (isset($data['check']) && $data['check'] == 1) {
                    $nb = (int)($data['nb'] ?? 0);
                    $emission += $nb * ($factors[$key] ?? 0);
                }
            }
        }

        $b->emissionCO2 = $emission;

        // --- Calcul consommation énergétique (kWh/an) ---
        $consommationKwhAn = 0.0;
        if ($request->has('emissions')) {
            $electricite = (float)($request->emissions['electricite']['nb'] ?? 0);
            $gaz = (float)($request->emissions['gaz']['nb'] ?? 0);
            $clim = (float)($request->emissions['clim']['nb'] ?? 0);
            $machine = (float)($request->emissions['machine']['nb'] ?? 0);
            $consommationKwhAn = ($electricite + $gaz + $clim + $machine) * 12;
        }

        // --- Calcul énergie renouvelable (kWh/an) ---
        $energieRenouvelableKwhAn = 0.0;
        if ($request->has('energies_renouvelables')) {
            foreach ($request->energies_renouvelables as $key => $data) {
                if (isset($data['check']) && $data['check'] == 1) {
                    $nb = (float)($data['nb'] ?? 0);
                    if ($key === 'panneaux_solaires') {
                        // nb = kW produits/mois, kWh/an = nb * 24 * 30 * 12
                        $energieRenouvelableKwhAn += $nb * 24 * 30 * 12;
                    } elseif ($key === 'energie_eolienne') {
                        // nb = MW produits/mois, kWh/an = nb * 1000 * 24 * 30 * 12
                        $energieRenouvelableKwhAn += $nb * 1000 * 24 * 30 * 12;
                    } elseif ($key === 'energie_hydroelectrique') {
                        // nb = TWh produits/an, kWh/an = nb * 1000000
                        $energieRenouvelableKwhAn += $nb * 1000000;
                    } elseif ($key === 'voitures_electriques') {
                        // nb = km/mois, assume 0.15 kWh/km, kWh/an = nb * 0.15 * 12
                        $energieRenouvelableKwhAn += $nb * 0.15 * 12;
                    } elseif ($key === 'camions_electriques') {
                        // nb = km/mois, assume 1 kWh/km, kWh/an = nb * 1 * 12
                        $energieRenouvelableKwhAn += $nb * 1 * 12;
                    }
                }
            }
        }

        // --- Calcul pourcentage renouvelable ---
        $pourcentageRenouvelable = 0.0;
        if ($consommationKwhAn > 0) {
            $pourcentageRenouvelable = min(($energieRenouvelableKwhAn / $consommationKwhAn) * 100, 100.0);
        }
        $b->pourcentageRenouvelable = $pourcentageRenouvelable;

        // --- Traitement des données de recyclage ---
        $recyclageData = null;
        if ($request->has('recyclage') && isset($request->recyclage['existe']) && $request->recyclage['existe'] == 1) {
            $recyclageData = [
                'existe' => true,
                'produit_recycle' => $request->recyclage['produit_recycle'] ?? [],
                'quantites' => $request->recyclage['quantites'] ?? []
            ];
        }

        $b->recyclage_data = $recyclageData ? json_encode($recyclageData) : null;

        // --- Traitement des données d'énergies renouvelables ---
        $energiesRenouvelablesData = [];
        if ($request->has('energies_renouvelables')) {
            foreach ($request->energies_renouvelables as $key => $data) {
                if (isset($data['check']) && $data['check'] == 1) {
                    $energiesRenouvelablesData[$key] = [
                        'check' => true,
                        'nb' => (float)($data['nb'] ?? 0)
                    ];
                }
            }
        }

        $b->energies_renouvelables_data = $energiesRenouvelablesData;

        $b->save();

        return redirect()->route('client.index')
                         ->with('success', 'Bâtiment ajouté avec succès.')
                         ->withFragment('batiments');
    }

    public function edit($id)
    {
    $batiment = Batiment::find($id);
        if (!$batiment) {
            abort(404);
        }
        $zones = $this->em->getRepository(ZoneUrbaine::class)->findAll();
        return view('batiments.edit', compact('batiment', 'zones'));
    }

    // Suppression depuis le backoffice
    public function destroyBackoffice($id)
    {
        $batiment = Batiment::find($id);
        if (!$batiment) {
            return redirect()->route('backoffice.indexbatiment')
                             ->with('error', 'Bâtiment introuvable.');
        }
        $batiment->delete();
        return redirect()->route('backoffice.indexbatiment')
                         ->with('success', 'Bâtiment supprimé avec succès.');
    }

    // Suppression depuis le frontoffice
    public function destroyFrontoffice($id)
    {
        $batiment = Batiment::find($id);
        if (!$batiment) {
            return redirect()->route('client.index')
                             ->with('error', 'Bâtiment introuvable.')
                             ->withFragment('batiments');
        }
        $batiment->delete();
        return redirect()->route('client.index')
                         ->with('success', 'Bâtiment supprimé avec succès.')
                         ->withFragment('batiments');
    }
}
