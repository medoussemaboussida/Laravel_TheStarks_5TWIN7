<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvisorController extends Controller
{
    public function show(Request $request)
    {
        $age = $request->query('age');
        $interet = $request->query('interet', 'général'); // optionnel avec valeur par défaut

        return view('show', compact('age', 'interet'));
    }
}
