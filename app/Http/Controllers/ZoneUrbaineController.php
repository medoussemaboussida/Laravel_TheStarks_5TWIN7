<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class ZoneUrbaineController extends Controller
{
    public function index()
    {
        $em = app(EntityManagerInterface::class);
        $zones = $em->getRepository(\App\Entities\ZoneUrbaine::class)->findAll();
        return view('admin.zones.index', compact('zones'));
    }
}
