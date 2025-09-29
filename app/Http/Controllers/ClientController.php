<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;

class ClientController extends Controller
{
    // Page client principale (layout + bouton)
    public function index()
    {
        return view('client.home');
    }

    // Retourne le partial HTML contenant le tableau paginé
    public function plants(Request $request)
    {
        // pagination serveur : 5 éléments / page
        $plants = Plant::with('type')->paginate(5);

        // si requête AJAX, renvoyer le partial (HTML fragment)
        return view('client.partials.plants_table', compact('plants'));
    }
}
