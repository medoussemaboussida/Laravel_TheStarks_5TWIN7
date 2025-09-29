<?php

namespace App\Http\Controllers;

use App\Entities\Batiment;
use App\Entities\ZoneUrbaine;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class BatimentController extends Controller
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    // Affiche la vue frontoffice pour /batiments
    // Affiche la vue frontoffice pour /batiments
    public function index()
    {
        if (request()->is('backoffice/indexbatiment')) {
            $batiments = $this->em->getRepository(Batiment::class)->findAll();
            $zones = $this->em->getRepository(ZoneUrbaine::class)->findAll();
            return view('admin.batiments.index', compact('batiments', 'zones'));
        } else {
            $batiments = $this->em->getRepository(Batiment::class)->findAll();
            return view('batiments.index', compact('batiments'));
        }
    }
    // Mise à jour depuis le backoffice (modal admin)
    public function updateBackoffice(Request $request, $id)
    {
        $b = $this->em->getRepository(Batiment::class)->find($id);

        if (!$b) {
            return redirect()->route('backoffice.indexbatiment')->with('error', 'Bâtiment introuvable.');
        }

        // --- Zone associée ---
        if ($request->zone_id) {
            $zone = $this->em->getRepository(ZoneUrbaine::class)->find($request->zone_id);
            if ($zone) {
                $b->setZone($zone);
            }
        }

        // --- Type de bâtiment ---
        $b->setTypeBatiment($request->type_batiment);
        $b->setAdresse($request->adresse);

        if ($request->type_batiment === 'Maison') {
            $b->setNbHabitants($request->nbHabitants);
            $b->setNbEmployes(null);
            $b->setTypeIndustrie(null);
        } elseif ($request->type_batiment === 'Usine') {
            $b->setNbHabitants(null);
            $b->setNbEmployes($request->nbEmployes);
            $b->setTypeIndustrie($request->typeIndustrie);
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

        $b->setEmissionCO2($emission);

        $this->em->persist($b);
        $this->em->flush();

        return redirect()->route('backoffice.indexbatiment')
                         ->with('success', 'Bâtiment mis à jour avec succès.');
    }

public function create()
{
    $zones = $this->em->getRepository(ZoneUrbaine::class)->findAll();
    return view('batiments.create', compact('zones'));
}
public function update(Request $request, $id)
{
    $b = $this->em->getRepository(Batiment::class)->find($id);

    if (!$b) {
        return redirect()->route('batiments.index')->with('error', 'Bâtiment introuvable.');
    }

    // --- Zone associée ---
    if ($request->zone_id) {
        $zone = $this->em->getRepository(ZoneUrbaine::class)->find($request->zone_id);
        if ($zone) {
            $b->setZone($zone);
        }
    }

    // --- Type de bâtiment ---
    $b->setTypeBatiment($request->type_batiment);
    $b->setAdresse($request->adresse);

    if ($request->type_batiment === 'Maison') {
        $b->setNbHabitants($request->nbHabitants);
        $b->setNbEmployes(null);
        $b->setTypeIndustrie(null);
    } elseif ($request->type_batiment === 'Usine') {
        $b->setNbHabitants(null);
        $b->setNbEmployes($request->nbEmployes);
        $b->setTypeIndustrie($request->typeIndustrie);
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

    $b->setEmissionCO2($emission);

    $this->em->persist($b);
    $this->em->flush();

    return redirect()->route('batiments.index')
                     ->with('success', 'Bâtiment mis à jour avec succès.');
}

  public function store(Request $request)
    {
        $b = new Batiment();

        // --- Associer la zone choisie ---
        if ($request->zone_id) {
            $zone = $this->em->getRepository(ZoneUrbaine::class)->find($request->zone_id);
            if ($zone) {
                $b->setZone($zone);
            }
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
            $b->setPourcentageRenouvelable($pctRenouvelable);

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
        $b->setEmissionCO2($emission);

        $this->em->persist($b);
        $this->em->flush();

        return redirect()->route('batiments.index')
                         ->with('success', 'Bâtiment ajouté avec succès.');
    }

    public function edit($id)
    {
        $batiment = $this->em->getRepository(Batiment::class)->find($id);
        if (!$batiment) {
            abort(404);
        }
        $zones = $this->em->getRepository(ZoneUrbaine::class)->findAll();
        return view('batiments.edit', compact('batiment', 'zones'));
    }
    // Suppression depuis le backoffice
    public function destroyBackoffice($id)
    {
        $batiment = $this->em->getRepository(Batiment::class)->find($id);
        if (!$batiment) {
            return redirect()->route('backoffice.indexbatiment')
                             ->with('error', 'Bâtiment introuvable.');
        }
        $this->em->remove($batiment);
        $this->em->flush();
        return redirect()->route('backoffice.indexbatiment')
                         ->with('success', 'Bâtiment supprimé avec succès.');
    }

    // Suppression depuis le frontoffice
    public function destroyFrontoffice($id)
    {
        $batiment = $this->em->getRepository(Batiment::class)->find($id);
        if (!$batiment) {
            return redirect()->route('batiments.index')
                             ->with('error', 'Bâtiment introuvable.');
        }
        $this->em->remove($batiment);
        $this->em->flush();
        return redirect()->route('batiments.index')
                         ->with('success', 'Bâtiment supprimé avec succès.');
    }
    // ...existing code...
}
