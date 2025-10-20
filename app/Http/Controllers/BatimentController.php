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

            $batiments = $query->paginate(10)->appends($request->query());
            return view('admin_dashboard.batiment', compact('batiments'));
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
            'zone_id' => 'required|exists:zone_urbaines,id',
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

        return redirect()->route('backoffice.indexbatiment')->with('success', 'Bâtiment créé avec succès.');
    }
public function update(Request $request, Batiment $batiment)
{
    // For multipart/form-data, use $_POST
    $inputData = [
        'type_batiment' => $_POST['type_batiment'] ?? null,
        'adresse' => $_POST['adresse'] ?? null,
        'zone_id' => $_POST['zone_id'] ?? null,
        'type_zone_urbaine' => $_POST['type_zone_urbaine'] ?? null,
    ];

    $validator = \Validator::make($inputData, [
        'type_batiment' => 'required|string|in:Maison,Usine',
        'adresse' => 'required|string',
        'zone_id' => 'required|integer',
        'type_zone_urbaine' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Check if zone exists
    $zone = \App\Models\ZoneUrbaine::find($inputData['zone_id']);
    if (!$zone) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Zone urbaine sélectionnée n\'existe pas',
                'errors' => ['zone_id' => ['Zone urbaine sélectionnée n\'existe pas']]
            ], 422);
        }
        return redirect()->back()->withErrors(['zone_id' => 'Zone urbaine sélectionnée n\'existe pas'])->withInput();
    }

    // Update the building
    $batiment->type_batiment = $inputData['type_batiment'];
    $batiment->adresse = $inputData['adresse'];
    $batiment->zone_id = $inputData['zone_id'];
    $batiment->type_zone_urbaine = $inputData['type_zone_urbaine'];

    // Handle type-specific fields
    if ($inputData['type_batiment'] === 'Maison') {
        $batiment->nb_habitants = $_POST['nbHabitants'] ?? null;
        $batiment->nb_employes = null;
        $batiment->type_industrie = null;
    } elseif ($inputData['type_batiment'] === 'Usine') {
        $batiment->nb_habitants = null;
        $batiment->nb_employes = $_POST['nbEmployes'] ?? null;
        $batiment->type_industrie = $_POST['typeIndustrie'] ?? null;
    }

    // Recalculate emissions
    $factors = [
        'voiture'      => 1.44,
        'moto'         => 0.96,
        'bus'          => 0.6,
        'avion'        => 1.8,
        'fumeur'       => 0.24,
        'electricite'  => 0.0048,
        'gaz'          => 0.0024,
        'clim'         => 0.0048,
        'machine'      => 0.0048,
        'camion'       => 3.6,
    ];

    $emission = 0.0;
    if (isset($_POST['emissions'])) {
        foreach ($_POST['emissions'] as $key => $data) {
            if (isset($data['check']) && $data['check'] == 1) {
                $nb = (int)($data['nb'] ?? 0);
                $emission += $nb * ($factors[$key] ?? 0);
            }
        }
    }

    $batiment->emission_c_o2 = $emission;

    // Calculate consommation énergétique (kWh/an)
    $consommationKwhAn = 0.0;
    if (isset($_POST['emissions'])) {
        $electricite = (float)($_POST['emissions']['electricite']['nb'] ?? 0);
        $gaz = (float)($_POST['emissions']['gaz']['nb'] ?? 0);
        $clim = (float)($_POST['emissions']['clim']['nb'] ?? 0);
        $machine = (float)($_POST['emissions']['machine']['nb'] ?? 0);
        $consommationKwhAn = ($electricite + $gaz + $clim + $machine) * 12;
    }

    // Calculate énergie renouvelable (kWh/an)
    $energieRenouvelableKwhAn = 0.0;
    if (isset($_POST['energies_renouvelables'])) {
        foreach ($_POST['energies_renouvelables'] as $key => $data) {
            if (isset($data['check']) && $data['check'] == 1) {
                $nb = (float)($data['nb'] ?? 0);
                if ($key === 'panneaux_solaires') {
                    $energieRenouvelableKwhAn += $nb * 24 * 30 * 12;
                } elseif ($key === 'energie_eolienne') {
                    $energieRenouvelableKwhAn += $nb * 1000 * 24 * 30 * 12;
                } elseif ($key === 'energie_hydroelectrique') {
                    $energieRenouvelableKwhAn += $nb * 1000000;
                } elseif ($key === 'voitures_electriques') {
                    $energieRenouvelableKwhAn += $nb * 0.15 * 12;
                } elseif ($key === 'camions_electriques') {
                    $energieRenouvelableKwhAn += $nb * 1 * 12;
                }
            }
        }
    }

    // Calculate pourcentage renouvelable
    $pourcentageRenouvelable = 0.0;
    if ($consommationKwhAn > 0) {
        $pourcentageRenouvelable = min(($energieRenouvelableKwhAn / $consommationKwhAn) * 100, 100.0);
    }
    $batiment->pourcentage_renouvelable = $pourcentageRenouvelable;

    // Calculate emission reelle
    $batiment->emission_reelle = $emission * (1 - $pourcentageRenouvelable / 100);

    // Handle recyclage data
    $recyclage_data = [];
    if (isset($_POST['recyclage'])) {
        $recyclage_data = $_POST['recyclage'];
    }
    $batiment->recyclage_data = $recyclage_data;

    // Handle energies renouvelables data
    $energies_renouvelables_data = [];
    if (isset($_POST['energies_renouvelables'])) {
        $energies_renouvelables_data = $_POST['energies_renouvelables'];
    }
    $batiment->energies_renouvelables_data = $energies_renouvelables_data;

    $batiment->save();

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Bâtiment mis à jour avec succès'
        ]);
    }

    return redirect()->route('client.batiments.index')->with('success', 'Bâtiment mis à jour avec succès');
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
            // Debug temporaire - décommenter pour voir les données reçues
            // dd($request->recyclage);

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

   public function edit($id)
{
    $batiment = Batiment::with('zone')->findOrFail($id);
    $zones = ZoneUrbaine::all();
    return view('admin_dashboard.batiment_edit', compact('batiment', 'zones'));
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
                'emissions_data' => $batiment->emissions_data ?? [],
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

    public function updateAdmin(Request $request, $id)
    {
        $batiment = Batiment::findOrFail($id);

        $request->validate([
            'type_batiment' => 'required|in:Maison,Usine',
            'adresse' => 'required|string|max:255',
            'zone_id' => 'required|exists:zone_urbaines,id',
            'nb_habitants' => 'nullable|integer|min:1',
            'nb_employes' => 'nullable|integer|min:0',
            'type_industrie' => 'nullable|string|max:255',
        ]);

        // Mise à jour des champs de base
        $batiment->update($request->only(['type_batiment', 'adresse', 'zone_id']));

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

        return redirect()->route('backoffice.indexbatiment')->with('success', 'Bâtiment mis à jour avec succès.');
    }

    public function destroyAdmin($id)
    {
        $batiment = Batiment::findOrFail($id);
        $batiment->delete();

        return redirect()->route('backoffice.indexbatiment')->with('success', 'Bâtiment supprimé avec succès.');
    }
}
