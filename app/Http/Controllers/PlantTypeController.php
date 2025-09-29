<?php

namespace App\Http\Controllers;

use App\Models\PlantType;
use Illuminate\Http\Request;

class PlantTypeController extends Controller
{
    public function index()
{
    $types = PlantType::paginate(5); // 5 éléments par page
    return view('plant_types.index', compact('types'));
}


    public function create()
    {
        return view('plant_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|regex:/^[A-Za-zÀ-ÿ\s]+$/u|max:255',
            'description' => 'required|string|regex:/^[A-Za-zÀ-ÿ\s]+$/u|max:255'
        ], [
            'name.required' => 'Le nom du type est obligatoire.',
            'name.regex' => 'Le nom ne doit contenir que des lettres.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'description.regex' => 'Le nom ne doit contenir que des lettres.',
            'description.max' => 'La description ne doit pas dépasser 255 caractères.'
        ]);

        PlantType::create($request->all());
        return redirect()->route('plant-types.index')->with('success', 'Type ajouté avec succès');
    }

    public function edit(PlantType $plantType)
    {
        return view('plant_types.edit', compact('plantType'));
    }

    public function update(Request $request, PlantType $plantType)
    {
        $request->validate([
            'name' => 'required|string|regex:/^[A-Za-zÀ-ÿ\s]+$/u|max:255',
            'description' => 'required|string|regex:/^[A-Za-zÀ-ÿ\s]+$/u|max:255'
        ], [
            'name.required' => 'Le nom du type est obligatoire.',
            'name.regex' => 'Le nom ne doit contenir que des lettres.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'description.regex' => 'Le nom ne doit contenir que des lettres.',
            'description.max' => 'La description ne doit pas dépasser 255 caractères.'
        ]);

        $plantType->update($request->all());
        return redirect()->route('plant-types.index')->with('success', 'Type mis à jour avec succès');
    }

    public function destroy(PlantType $plantType)
    {
        $plantType->delete();
        return redirect()->route('plant-types.index')->with('success', 'Type supprimé avec succès');
    }
}
