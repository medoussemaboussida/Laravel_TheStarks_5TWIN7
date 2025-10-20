<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\PlantType;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index()
{
    $plants = Plant::with('type')->paginate(5); // ✅ pagination activée
    $types = PlantType::all(); // pour le <select>
    return view('plants.index', compact('plants', 'types'));
}


    public function create()
    {
        $types = PlantType::all();
        return view('plants.create', compact('types'));
    }

    public function store(Request $request)
    {
       $request->validate([
    'name' => 'required|string|regex:/^[A-Za-zÀ-ÿ\s]+$/u|max:255',
    'age' => 'required|integer|min:0|max:200',
    'location' => 'required|string|max:255',
    'plant_type_id' => 'required|exists:plant_types,id'
],

 [
            'name.required' => 'Le nom de la plante est obligatoire.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'age.integer' => 'L’âge doit être un nombre entier.',
            'age.min' => 'L’âge ne peut pas être négatif.',
            'location.max' => 'La localisation ne doit pas dépasser 255 caractères.',
            'plant_type_id.required' => 'Veuillez sélectionner un type de plante.',
            'plant_type_id.exists' => 'Le type de plante sélectionné est invalide.',
            'name.regex' => 'Le nom ne doit contenir que des lettres.',
            'age.required' => 'L’âge est obligatoire.',
            'location.required' => 'La localisation est obligatoire.'
        ]);

        Plant::create($request->all());
        return redirect()->route('plants.index')->with('success', 'Plante ajoutée avec succès');
    }

    public function edit(Plant $plant)
    {
        $types = PlantType::all();
        return view('plants.edit', compact('plant', 'types'));
    }

    public function update(Request $request, Plant $plant)
    {
        $request->validate([
    'name' => 'required|string|regex:/^[A-Za-zÀ-ÿ\s]+$/u|max:255',
    'age' => 'required|integer|min:0|max:200',
    'location' => 'required|string|max:255',
    'plant_type_id' => 'required|exists:plant_types,id'
], [
    'name.required' => 'Le nom de la plante est obligatoire.',
    'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
    'name.regex' => 'Le nom ne doit contenir que des lettres.',
    'age.required' => 'L’âge est obligatoire.',
    'age.integer' => 'L’âge doit être un nombre entier.',
    'age.min' => 'L’âge ne peut pas être négatif.',
    'age.max' => 'L’âge ne peut pas dépasser 200.',
    'location.required' => 'La localisation est obligatoire.',
    'location.max' => 'La localisation ne doit pas dépasser 255 caractères.',
    'plant_type_id.required' => 'Veuillez sélectionner un type de plante.',
    'plant_type_id.exists' => 'Le type de plante sélectionné est invalide.'
]);


        $plant->update($request->all());
        return redirect()->route('plants.index')->with('success', 'Plante mise à jour avec succès');
    }

    public function destroy(Plant $plant)
    {
        $plant->delete();
        return redirect()->route('plants.index')->with('success', 'Plante supprimée avec succès');
    }
}
