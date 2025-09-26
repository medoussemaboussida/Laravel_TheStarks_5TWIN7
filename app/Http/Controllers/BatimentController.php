<?php

namespace App\Http\Controllers;

use App\Entities\Batiment;
use App\Entities\ZoneUrbaine;
use Doctrine\ORM\EntityManagerInterface;
use App\Http\Requests\BatimentRequest;

class BatimentController extends Controller
{
    public function __construct(private EntityManagerInterface $em) {}

    public function index()
    {
        $batiments = $this->em->getRepository(Batiment::class)->findAll();
        return view('batiments.index', compact('batiments'));
    }

public function create()
{
    $zones = $this->em->getRepository(ZoneUrbaine::class)->findAll();
    return view('batiments.create', compact('zones'));
}

    public function store(BatimentRequest $request)
{
    $b = new Batiment();

    $b->setTypeBatiment($request->type_batiment);
    $b->setAdresse($request->adresse);
    $b->setEmissionCO2((float)$request->emissionCO2);
    $b->setPourcentageRenouvelable((float)$request->pourcentageRenouvelable);
  // Associer la zone choisie
    if ($request->zone_id) {
        $zone = $this->em->getRepository(ZoneUrbaine::class)->find($request->zone_id);
        if ($zone) {
            $b->setZone($zone);
        }
    }
    if ($request->type_batiment === 'Maison') {
        $b->setNbHabitants($request->nbHabitants);
        $b->setNbEmployes(null);
        $b->setTypeIndustrie(null);
    } elseif ($request->type_batiment === 'Usine') {
        $b->setNbHabitants(null);
        $b->setNbEmployes($request->nbEmployes);
        $b->setTypeIndustrie($request->typeIndustrie);
    }

    $this->em->persist($b);
    $this->em->flush();

    return redirect()->route('batiments.index')
                     ->with('success', 'Bâtiment ajouté avec succès.');
}


    // edit, update, destroy: voir code complet déjà fourni dans la conversation
}
