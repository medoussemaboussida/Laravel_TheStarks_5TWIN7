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

        // --- Type de bâtiment ---
        $b->setTypeBatiment($request->type_batiment);
        $b->setAdresse($request->adresse);
        $energie_evitee = 0;

            if ($request->solaire_active && $request->solaire_kw) {
                $energie_evitee += $request->solaire_kw * 0.0005; // 1000 kWh ≈ 0.5 tCO₂ évité
            }
            if ($request->voiture_active && $request->voiture_nb) {
                $energie_evitee += $request->voiture_nb * 2; // 1 EV ≈ 2 tCO₂/an évité
            }
            if ($request->biomasse_active && $request->biomasse_tonnes) {
                $energie_evitee += $request->biomasse_tonnes * 1.5;
            }
            if ($request->eolien_active && $request->eolien_kw) {
                $energie_evitee += $request->eolien_kw * 0.0004;
            }

            $pctRenouvelable = min(100, ($energie_evitee / max(1, $b->getEmissionCO2())) * 100);
            $pctRenouvelable = min(100, ($energie_evitee / max(1, $b->emissionCO2 ?? 0)) * 100);
            $b->pourcentageRenouvelable = $pctRenouvelable;

        if ($request->type_batiment === 'Maison') {
            $b->setNbHabitants($request->nbHabitants);
            $b->setNbEmployes(null);
            $b->setTypeIndustrie(null);
        } elseif ($request->type_batiment === 'Usine') {
            $b->setNbHabitants(null);
            $b->setNbEmployes($request->nbEmployes);
            $b->setTypeIndustrie($request->typeIndustrie);
        }

        // --- FACTEURS CO2 (t/an par unité) ---
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

        // Sauvegarde de l’émission calculée
    // Sauvegarde de l’émission calculée
    $b->emissionCO2 = $emission;
    $b->save();

        // If the request comes from the backoffice modal, redirect back to the backoffice index
        if ($request->input('source') === 'backoffice') {
            return redirect()->route('backoffice.indexbatiment')
                             ->with('success', 'Bâtiment ajouté avec succès.');
        }

        return redirect()->route('batiments.index')
                         ->with('success', 'Bâtiment ajouté avec succès.');
    }
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
            return redirect()->route('batiments.index')
                             ->with('error', 'Bâtiment introuvable.');
        }
        $batiment->delete();
        return redirect()->route('batiments.index')
                         ->with('success', 'Bâtiment supprimé avec succès.');
    }
}
