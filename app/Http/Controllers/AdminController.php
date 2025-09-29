<?php

namespace App\Http\Controllers;

use App\Entities\Batiment;
use Doctrine\ORM\EntityManagerInterface;

class AdminController extends Controller
{
    public function __construct(private EntityManagerInterface $em) {}

    public function dashboard()
    {
        $nbBatiments = count($this->em->getRepository(Batiment::class)->findAll());

        return view('admin.dashboard', compact('nbBatiments'));
    }
}
