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
    public function index(Request $request)
    {
        if (request()->routeIs('backoffice.indexbatiment')) {
            $query = Batiment::with(['zone', 'user']);

            // Recherche par adresse
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('adresse', 'LIKE', '%' . $search . '%');
            }

            // Filtre par type de bâtiment
            if ($request->filled('type')) {
                $query->where('type_batiment', $request->type);
            }

            // Tri par émissions CO2
            if ($request->filled('sort_co2') && $request->sort_co2 !== '') {
                if ($request->sort_co2 === 'desc') {
                    $query->orderBy('emission_c_o2', 'desc'); // Plus polluant d'abord
                } elseif ($request->sort_co2 === 'asc') {
                    $query->orderBy('emission_c_o2', 'asc'); // Moins polluant d'abord
                }
            } else {
                // Tri par défaut : plus récent d'abord
                $query->orderBy('id', 'desc');
            }

            $batiments = $query->paginate(10)->appends($request->query());

            // Calculer les statistiques
            $allBatiments = Batiment::all();
            $stats = [
                'total_batiments' => $allBatiments->count(),
                'total_maisons' => $allBatiments->where('type_batiment', 'Maison')->count(),
                'total_usines' => $allBatiments->where('type_batiment', 'Usine')->count(),
                'total_emissions_co2' => $allBatiments->sum('emission_c_o2'),
                'moyenne_energie_renouvelable' => $allBatiments->avg('pourcentage_renouvelable'),
                'total_arbres_besoin' => $allBatiments->sum('nbArbresBesoin'),
            ];

            return view('admin_dashboard.batiment', compact('batiments', 'stats'));
        } elseif (request()->is('backoffice/indexbatiment')) {
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

        $b->emission_c_o2 = $emission;

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
        $b->pourcentage_renouvelable = $pourcentageRenouvelable;

        // --- Traitement des données de recyclage ---
        $recyclageData = null;
        if ($request->has('recyclage') && isset($request->recyclage['existe']) && $request->recyclage['existe'] == 1) {
            $recyclageData = [
                'existe' => true,
                'produit_recycle' => $request->recyclage['produit_recycle'] ?? [],
                'quantites' => $request->recyclage['quantites'] ?? []
            ];
        }

        $b->recyclage_data = $recyclageData;

        $b->save();

        return redirect()->route('backoffice.indexbatiment')
                         ->with('success', 'Bâtiment mis à jour avec succès.');
    }

    public function create()
    {
        $zones = ZoneUrbaine::all();
        $typesZoneUrbaine = [
            'zone_industrielle' => 'Zone Industrielle',
            'quartier_residentiel' => 'Quartier Résidentiel',
            'centre_ville' => 'Centre Ville'
        ];
        return view('admin_dashboard.batiment_create', compact('zones', 'typesZoneUrbaine'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'type_batiment' => 'required|in:Maison,Usine',
            'adresse' => 'required|string|max:255',
            'zone_id' => 'required|exists:zones_urbaines,id',
            'type_zone_urbaine' => 'nullable|in:zone_industrielle,quartier_residentiel,centre_ville',
            'use_ai_prediction' => 'nullable|boolean',
        ]);

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
            $b->nb_habitants = $request->nbHabitants;
            $b->nb_employes = null;
            $b->type_industrie = null;
        } elseif ($request->type_batiment === 'Usine') {
            $b->nb_habitants = null;
            $b->nb_employes = $request->nbEmployes;
            $b->type_industrie = $request->typeIndustrie;
        }

        // --- Traitement des données d'émissions, recyclage et énergies renouvelables ---
        $emissionData = [];
        if ($request->has('emissions')) {
            foreach ($request->emissions as $key => $data) {
                if (isset($data['check']) && $data['check'] == 1) {
                    $emissionData[$key] = [
                        'check' => true,
                        'nb' => (float)($data['nb'] ?? 0)
                    ];
                }
            }
        }

        $recyclageData = null;
        if ($request->has('recyclage') && isset($request->recyclage['existe']) && $request->recyclage['existe'] == 1) {
            $quantites = [];
            $produitsRecycles = $request->recyclage['produit_recycle'] ?? [];
            foreach ($produitsRecycles as $produit) {
                $quantites[$produit] = isset($request->recyclage['quantites'][$produit]) ? (float)$request->recyclage['quantites'][$produit] : 0;
            }

            $recyclageData = [
                'existe' => true,
                'produit_recycle' => $produitsRecycles,
                'quantites' => $quantites
            ];
        }

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

        // --- Utiliser l'IA pour prédire les émissions si demandé ---
        if ($request->boolean('use_ai_prediction')) {
            try {
                $aiPredictions = Batiment::predictEmissionsWithAI([
                    'type_batiment' => $request->type_batiment,
                    'emission_data' => $emissionData,
                    'energies_renouvelables_data' => $energiesRenouvelablesData,
                    'recyclage_data' => $recyclageData,
                    'type_industrie' => $request->typeIndustrie,
                ]);

                $b->emission_c_o2 = $aiPredictions['emission_c_o2'];
                $b->pourcentage_renouvelable = $aiPredictions['pourcentage_renouvelable'];
                $b->emission_reelle = $aiPredictions['emission_reelle'];

                \Log::info('Prédiction IA utilisée pour le bâtiment', [
                    'predictions' => $aiPredictions,
                    'type_batiment' => $request->type_batiment
                ]);

            } catch (\Exception $e) {
                \Log::error('Erreur lors de la prédiction IA, utilisation des calculs manuels', [
                    'error' => $e->getMessage(),
                    'type_batiment' => $request->type_batiment
                ]);

                // Fallback vers les calculs manuels
                $this->calculateManualEmissions($b, $emissionData, $energiesRenouvelablesData);
            }
        } else {
            // Calculs manuels traditionnels
            $this->calculateManualEmissions($b, $emissionData, $energiesRenouvelablesData);
        }

        // --- Stocker les données brutes ---
        $b->emission_data = !empty($emissionData) ? json_encode($emissionData) : null;
        $b->recyclage_data = $recyclageData;
        $b->energies_renouvelables_data = !empty($energiesRenouvelablesData) ? json_encode($energiesRenouvelablesData) : null;

        // Assigner l'utilisateur connecté comme propriétaire du bâtiment
        $b->user_id = auth()->id();

        $b->save();

        $message = $request->boolean('use_ai_prediction')
            ? 'Bâtiment ajouté avec succès (prédiction IA utilisée).'
            : 'Bâtiment ajouté avec succès (calculs manuels).';

        return redirect()->route('backoffice.indexbatiment')
                         ->with('success', $message);
    }

    /**
     * Calcul manuel des émissions (méthode traditionnelle)
     */
    private function calculateManualEmissions(Batiment $b, array $emissionData, array $energiesRenouvelablesData)
    {
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
        foreach ($emissionData as $key => $data) {
            if (isset($data['check']) && $data['check'] === true) {
                $nb = (float)($data['nb'] ?? 0);
                $emission += $nb * ($factors[$key] ?? 0);
            }
        }

        $b->emission_c_o2 = $emission;

        // --- Calcul consommation énergétique (kWh/an) ---
        $consommationKwhAn = 0.0;
        $electricite = (float)($emissionData['electricite']['nb'] ?? 0);
        $gaz = (float)($emissionData['gaz']['nb'] ?? 0);
        $clim = (float)($emissionData['clim']['nb'] ?? 0);
        $machine = (float)($emissionData['machine']['nb'] ?? 0);
        $consommationKwhAn = ($electricite + $gaz + $clim + $machine) * 12;

        // --- Calcul énergie renouvelable (kWh/an) ---
        $energieRenouvelableKwhAn = 0.0;
        foreach ($energiesRenouvelablesData as $key => $data) {
            if (isset($data['check']) && $data['check'] === true) {
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

        // --- Calcul pourcentage renouvelable ---
        $pourcentageRenouvelable = 0.0;
        if ($consommationKwhAn > 0) {
            $pourcentageRenouvelable = min(($energieRenouvelableKwhAn / $consommationKwhAn) * 100, 100.0);
        }
        $b->pourcentage_renouvelable = $pourcentageRenouvelable;

        // --- Calcul émission réelle ---
        $b->emission_reelle = $emission * (1 - $pourcentageRenouvelable / 100);
    }

    // Création depuis le frontoffice (client)
    public function store(Request $request)
    {
        $request->validate([
            'type_batiment' => 'required|in:Maison,Usine',
            'adresse' => 'required|string|max:255',
            'zone_id' => 'required|exists:zones_urbaines,id',
            'type_zone_urbaine' => 'nullable|in:zone_industrielle,quartier_residentiel,centre_ville',
        ]);

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
            $b->nb_habitants = $request->nbHabitants;
            $b->nb_employes = null;
            $b->type_industrie = null;
        } elseif ($request->type_batiment === 'Usine') {
            $b->nb_habitants = null;
            $b->nb_employes = $request->nbEmployes;
            $b->type_industrie = $request->typeIndustrie;
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

        $b->emission_c_o2 = $emission;

        // --- Stocker les données d'émissions brutes ---
        $emissionData = [];
        if ($request->has('emissions')) {
            foreach ($request->emissions as $key => $data) {
                if (isset($data['check']) && $data['check'] == 1) {
                    $emissionData[$key] = [
                        'check' => true,
                        'nb' => (float)($data['nb'] ?? 0)
                    ];
                }
            }
        }

        $b->emission_data = !empty($emissionData) ? json_encode($emissionData) : null;

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
        $b->pourcentage_renouvelable = $pourcentageRenouvelable;

        // --- Traitement des données de recyclage ---
        $recyclageData = null;
        if ($request->has('recyclage') && isset($request->recyclage['existe']) && $request->recyclage['existe'] == 1) {
            // Initialiser les quantités avec 0 pour tous les produits recyclés
            $quantites = [];
            $produitsRecycles = $request->recyclage['produit_recycle'] ?? [];
            foreach ($produitsRecycles as $produit) {
                $quantites[$produit] = isset($request->recyclage['quantites'][$produit]) ? (float)$request->recyclage['quantites'][$produit] : 0;
            }

            $recyclageData = [
                'existe' => true,
                'produit_recycle' => $produitsRecycles,
                'quantites' => $quantites
            ];
        }

        $b->recyclage_data = $recyclageData;

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

        $b->energies_renouvelables_data = !empty($energiesRenouvelablesData) ? json_encode($energiesRenouvelablesData) : null;

        // Assigner l'utilisateur connecté comme propriétaire du bâtiment
        $b->user_id = auth()->id();

        $b->save();

        return redirect()->route('client.index')
                         ->with('success', 'Bâtiment ajouté avec succès.')
                         ->withFragment('batiments');
    }

    // Suppression depuis le backoffice
    public function destroyBackoffice($id)
    {
        $batiment = Batiment::find($id);
        if (!$batiment) {
            return redirect()->route('backoffice.indexbatiment')
                             ->with('error', 'Bâtiment introuvable.');
        }

        // Vérifier que l'utilisateur connecté est le propriétaire du bâtiment
        if ($batiment->user_id !== auth()->id()) {
            return redirect()->route('backoffice.indexbatiment')
                             ->with('error', 'Vous n\'avez pas l\'autorisation de supprimer ce bâtiment.');
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

        // Vérifier que l'utilisateur connecté est le propriétaire du bâtiment
        if ($batiment->user_id !== auth()->id()) {
            return redirect()->route('client.index')
                             ->with('error', 'Vous n\'avez pas l\'autorisation de supprimer ce bâtiment.')
                             ->withFragment('batiments');
        }

        $batiment->delete();
        return redirect()->route('client.index')
                         ->with('success', 'Bâtiment supprimé avec succès.')
                         ->withFragment('batiments');
    }

    /**
     * Get batiment data for editing modal and admin details modal
     */
    public function getBatimentData($id)
    {
        $batiment = Batiment::with(['zone', 'user'])->findOrFail($id);

        // Pour l'admin, pas de vérification d'autorisation
        if (!auth()->user()->isAdmin()) {
            // Vérifier que l'utilisateur connecté est le propriétaire du bâtiment
            if ($batiment->user_id !== auth()->id()) {
                return response()->json(['error' => 'Vous n\'avez pas l\'autorisation d\'accéder à ce bâtiment.'], 403);
            }
        }

        return response()->json([
            'batiment' => [
                'id' => $batiment->id,
                'type_batiment' => $batiment->type_batiment,
                'adresse' => $batiment->adresse,
                'zone' => $batiment->zone,
                'user' => $batiment->user,
                'zone_id' => $batiment->zone_id,
                'type_zone_urbaine' => $batiment->type_zone_urbaine,
                'nb_habitants' => $batiment->nb_habitants,
                'nb_employes' => $batiment->nb_employes,
                'type_industrie' => $batiment->type_industrie,
                'emission_c_o2' => $batiment->emission_c_o2,
                'emission_reelle' => $batiment->emission_reelle,
                'pourcentage_renouvelable' => $batiment->pourcentage_renouvelable,
                'nbArbresBesoin' => $batiment->nbArbresBesoin,
                'emission_data' => $batiment->emission_data ?? [],
                'energies_renouvelables_data' => $batiment->energies_renouvelables_data ?? [],
                'recyclage_data' => $batiment->recyclage_data ?? [],
                'created_at' => $batiment->created_at,
                'updated_at' => $batiment->updated_at,
            ]
        ]);
    }

    /**
     * Get zones data for API
     */
    public function getZones()
    {
        $zones = ZoneUrbaine::select('id', 'nom')->get();

        return response()->json([
            'zones' => $zones
        ]);
    }

    // Admin methods
    public function show($id)
    {
        $batiment = Batiment::with(['zone', 'user'])->findOrFail($id);
        return view('admin_dashboard.batiment_show', compact('batiment'));
    }

    public function edit($id)
    {
        $batiment = Batiment::with(['zone', 'user'])->findOrFail($id);
        $zones = ZoneUrbaine::select('id', 'nom')->get();
        return view('admin_dashboard.batiment_create', compact('batiment', 'zones'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $batiment = Batiment::findOrFail($id);

        $request->validate([
            'type_batiment' => 'required|in:Maison,Usine',
            'adresse' => 'required|string|max:255',
            'zone_id' => 'required|exists:zones_urbaines,id',
            'nb_habitants' => 'nullable|integer|min:1',
            'nb_employes' => 'nullable|integer|min:0',
            'type_industrie' => 'nullable|string|max:255',
        ]);

        // Mise à jour des champs de base
        $batiment->update($request->only(['type_batiment', 'adresse', 'zone_id', 'type_zone_urbaine']));

        // Mise à jour des champs spécifiques selon le type
        if ($request->type_batiment === 'Maison') {
            $batiment->update([
                'nb_habitants' => $request->nb_habitants,
                'nb_employes' => null,
                'type_industrie' => null,
            ]);
        } elseif ($request->type_batiment === 'Usine') {
            $batiment->update([
                'nb_habitants' => null,
                'nb_employes' => $request->nb_employes,
                'type_industrie' => $request->type_industrie,
            ]);
        }

        // Traitement des données d'émissions
        $emissionData = [];
        if ($request->has('emissions')) {
            foreach ($request->emissions as $type => $data) {
                if (isset($data['check']) && $data['check'] == '1') {
                    $emissionData[$type] = [
                        'nb' => $data['nb'] ?? 0
                    ];
                }
            }
        }
        $batiment->emission_data = $emissionData;

        // Traitement des données d'énergies renouvelables
        $energiesData = [];
        if ($request->has('energies_renouvelables')) {
            foreach ($request->energies_renouvelables as $type => $data) {
                if (isset($data['check']) && $data['check'] == '1') {
                    $energiesData[$type] = [
                        'nb' => $data['nb'] ?? 0
                    ];
                }
            }
        }
        $batiment->energies_renouvelables_data = $energiesData;

        // Traitement des données de recyclage
        $recyclageData = [];
        if ($request->has('recyclage.existe') && $request->input('recyclage.existe') == '1') {
            $recyclageData['existe'] = true;

            // Produits recyclés
            $produitsRecycles = [];
            if ($request->has('recyclage.produit_recycle')) {
                $produitsRecycles = $request->input('recyclage.produit_recycle');
            }
            $recyclageData['produit_recycle'] = $produitsRecycles;

            // Quantités
            $quantites = [];
            if ($request->has('recyclage.quantites')) {
                $quantites = $request->input('recyclage.quantites');
            }
            $recyclageData['quantites'] = $quantites;
        } else {
            $recyclageData['existe'] = false;
        }
        $batiment->recyclage_data = $recyclageData;

        // Calcul des émissions et autres métriques
        $this->calculateEmissionsAndMetrics($batiment);

        $batiment->save();

        // Vérifier si c'est une requête AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Bâtiment mis à jour avec succès.',
                'batiment' => $batiment->load('zone')
            ]);
        }

        return redirect()->route('backoffice.indexbatiment')->with('success', 'Bâtiment mis à jour avec succès.');
    }

    public function destroyAdmin($id)
    {
        $batiment = Batiment::findOrFail($id);
        $batiment->delete();

        return redirect()->route('backoffice.indexbatiment')->with('success', 'Bâtiment supprimé avec succès.');
    }

    /**
     * Calculate emissions and metrics for a building
     */
    private function calculateEmissionsAndMetrics(Batiment $batiment)
    {
        // --- FACTEURS CO2 (t/an par unité mensuelle) ---
        $factors = [
            'voiture'      => 1.44,  // t/an per km/mois (0.12 kg/km * 12)
            'moto'         => 0.96,  // t/an per km/mois (0.08 kg/km * 12)
            'bus'          => 0.6,   // t/an per km/mois (0.05 kg/km * 12)
            'avion'        => 1.8,   // t/an per km/mois (0.15 kg/km * 12)
            'fumeur'       => 0.24,  // t/an per pack/mois (0.02 t/an per pack * 12)
            'electricite'  => 0.0048, // t/an per kWh/mois (0.0004 t/kWh * 12)
            'gaz'          => 0.0048, // t/an per kWh/mois (0.0002 t/kWh * 12)
            'clim'         => 0.0048, // t/an per kWh/mois
            'machine'      => 0.0048, // assume kWh/mois
            'camion'       => 3.6,   // t/an per km/mois (0.3 kg/km * 12)
        ];

        // --- Calcul émission CO2 ---
        $emission = 0.0;
        $emissionData = $batiment->emission_data ?? [];
        if (!empty($emissionData) && is_array($emissionData)) {
            foreach ($emissionData as $key => $data) {
                if (isset($data['quantite']) && $data['quantite'] > 0) {
                    $emission += $data['quantite'] * ($factors[$key] ?? 0);
                }
            }
        }
        $batiment->emission_c_o2 = $emission;

        // --- Calcul consommation énergétique (kWh/an) ---
        $consommationKwhAn = 0.0;
        if (!empty($emissionData) && is_array($emissionData)) {
            $electricite = (float)($emissionData['electricite']['quantite'] ?? 0);
            $gaz = (float)($emissionData['gaz']['quantite'] ?? 0);
            $clim = (float)($emissionData['clim']['quantite'] ?? 0);
            $machine = (float)($emissionData['machine']['quantite'] ?? 0);
            $consommationKwhAn = ($electricite + $gaz + $clim + $machine) * 12;
        }

        // --- Calcul énergie renouvelable (kWh/an) ---
        $energieRenouvelableKwhAn = 0.0;
        $energiesData = $batiment->energies_renouvelables_data ?? [];
        if (!empty($energiesData)) {
            foreach ($energiesData as $key => $data) {
                if (isset($data['nb']) && $data['nb'] > 0) {
                    $nb = (float)$data['nb'];
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
        $batiment->pourcentage_renouvelable = $pourcentageRenouvelable;

        // --- Calcul nombre d'arbres nécessaires ---
        // Assuming 1 tree absorbs ~0.05 tons CO2 per year
        $batiment->nbArbresBesoin = $emission > 0 ? ceil($emission / 0.05) : 0;
    }

    /**
     * Update building from client side (AJAX)
     */
    public function update(Request $request, $id)
    {
        $batiment = Batiment::findOrFail($id);

        // Vérifier que l'utilisateur connecté est le propriétaire du bâtiment
        if ($batiment->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Vous n\'avez pas l\'autorisation de modifier ce bâtiment.'], 403);
        }

        $request->validate([
            'type_batiment' => 'required|in:Maison,Bureau,Industrie',
            'adresse' => 'required|string|max:255',
            'zone_id' => 'required|exists:zones_urbaines,id',
            'type_zone_urbaine' => 'nullable|in:zone_industrielle,quartier_residentiel,centre_ville',
            'nb_habitants' => 'nullable|integer|min:1',
            'nb_employes' => 'nullable|integer|min:0',
            'type_industrie' => 'nullable|string|max:255',
        ]);

        // Mise à jour des champs de base
        $batiment->update($request->only(['type_batiment', 'adresse', 'zone_id', 'type_zone_urbaine']));

        // Mise à jour des champs spécifiques selon le type
        if ($request->type_batiment === 'Maison') {
            $batiment->update([
                'nb_habitants' => $request->input('nbHabitants', 0),
                'nb_employes' => null,
                'type_industrie' => null,
            ]);
        } elseif ($request->type_batiment === 'Bureau') {
            $batiment->update([
                'nb_employes' => $request->input('nbEmployes', 0),
                'nb_habitants' => null,
                'type_industrie' => null,
            ]);
        } elseif ($request->type_batiment === 'Industrie') {
            $batiment->update([
                'type_industrie' => $request->input('typeIndustrie'),
                'nb_habitants' => null,
                'nb_employes' => null,
            ]);
        }

        // Traitement des données d'émissions
        $emissionsData = [];
        if ($request->has('emissions')) {
            foreach ($request->input('emissions') as $type => $data) {
                if (isset($data['nb']) && $data['nb'] > 0) {
                    $emissionsData[$type] = [
                        'type' => $type,
                        'quantite' => (float)$data['nb'],
                        'unite' => $this->getUniteForEmissionType($type),
                    ];
                }
            }
        }
        $batiment->emission_data = !empty($emissionsData) ? json_encode($emissionsData) : null;

        // Traitement des données d'énergies renouvelables
        $energiesRenouvelablesData = [];
        if ($request->input('energies_renouvelables.existe') == '1') {
            foreach (['panneaux_solaires', 'energie_eolienne', 'energie_hydroelectrique', 'voitures_electriques', 'camions_electriques'] as $type) {
                $data = $request->input("energies_renouvelables.{$type}");
                if (isset($data['check']) && $data['check'] == '1' && isset($data['nb']) && $data['nb'] > 0) {
                    $energiesRenouvelablesData[$type] = [
                        'type' => $type,
                        'nb' => (float)$data['nb'],
                    ];
                }
            }
        }
        $batiment->energies_renouvelables_data = !empty($energiesRenouvelablesData) ? json_encode($energiesRenouvelablesData) : null;

        // Traitement des données de recyclage
        $recyclageData = [];
        if ($request->input('recyclage.existe') == '1') {
            $recyclageData['existe'] = true;

            // Produits recyclés
            $produitsRecycles = [];
            if ($request->has('recyclage.produit_recycle')) {
                $produitsRecycles = $request->input('recyclage.produit_recycle');
            }
            $recyclageData['produit_recycle'] = $produitsRecycles;

            // Quantités
            $quantites = [];
            if ($request->has('recyclage.quantites')) {
                $quantites = $request->input('recyclage.quantites');
            }
            $recyclageData['quantites'] = $quantites;
        }
        $batiment->recyclage_data = !empty($recyclageData) ? json_encode($recyclageData) : null;

        // Calculer les émissions et métriques
        $this->calculateEmissionsAndMetrics($batiment);

        $batiment->save();

        return response()->json([
            'success' => true,
            'message' => 'Bâtiment mis à jour avec succès.',
            'batiment' => $batiment->load('zone')
        ]);
    }

    /**
     * Get unit for emission type
     */
    private function getUniteForEmissionType($type)
    {
        $unites = [
            'voiture' => 'km/mois',
            'moto' => 'km/mois',
            'bus' => 'km/mois',
            'avion' => 'km/mois',
            'fumeur' => 'paquets/mois',
            'electricite' => 'kWh/mois',
            'gaz' => 'm³/mois',
            'camion' => 'km/mois',
        ];

        return $unites[$type] ?? '';
    }

    /**
     * Générer un rapport PDF pour tous les bâtiments
     */
    public function generatePdfReport()
    {
        $batiments = Batiment::with(['zone', 'user'])->get();

        // Calculer les statistiques globales
        $stats = [
            'total_batiments' => $batiments->count(),
            'total_emissions' => $batiments->sum('emission_c_o2'),
            'moyenne_emissions' => $batiments->avg('emission_c_o2'),
            'total_employes' => $batiments->sum('nb_employes'),
            'total_habitants' => $batiments->sum('nb_habitants'),
            'moyenne_renouvelable' => $batiments->avg('pourcentage_renouvelable'),
            'types_batiment' => $batiments->groupBy('type_batiment')->map->count(),
            'zones' => $batiments->groupBy('type_zone_urbaine')->map->count(),
        ];

        // Générer les recommandations pour chaque bâtiment
        $batimentsAvecRecommandations = $batiments->map(function ($batiment) {
            try {
                $recommandations = $batiment->generateNatureProtectionRecommendations();
                $batiment->recommandations = $recommandations;
            } catch (\Exception $e) {
                $batiment->recommandations = ['Erreur lors de la génération des recommandations'];
            }
            return $batiment;
        });

        $pdf = \PDF::loadView('admin_dashboard.batiments_report_pdf', compact('batimentsAvecRecommandations', 'stats'));

        $nomFichier = 'rapport_batiments_' . date('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($nomFichier);
    }
}
