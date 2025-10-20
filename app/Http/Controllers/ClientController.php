<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;

class ClientController extends Controller
{
    // Page client principale (layout + bouton)
    public function index()
    {
        $plants = Plant::with('type')->paginate(5);
        $allPlants = Plant::with('type')->get(); // Toutes les plantes pour les statistiques
        return view('client_page.client', compact('plants', 'allPlants'));
    }

    // Retourne le partial HTML contenant le tableau paginé
    public function plants(Request $request)
    {
        // pagination serveur : 5 éléments / page
        $plants = Plant::with('type')->paginate(5);

        // si requête AJAX, renvoyer le partial (HTML fragment)
        return view('client_page.partials.plants_table', compact('plants'));
    }
}
