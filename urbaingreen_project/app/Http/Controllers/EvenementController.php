<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $evenements = Evenement::with('projet')->latest()->paginate(10);
        return view('evenements.index', compact('evenements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $projets = Projet::all();
        return view('evenements.create', compact('projets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'lieu' => 'nullable|string|max:255',
            'nombre_participants_max' => 'nullable|integer|min:1',
            'statut' => 'required|in:planifie,en_cours,termine,annule',
            'projet_id' => 'required|exists:projets,id'
        ]);

        Evenement::create($validated);

        return redirect()->route('evenements.index')
            ->with('success', 'Événement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evenement $evenement): View
    {
        $evenement->load('projet');
        return view('evenements.show', compact('evenement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evenement $evenement): View
    {
        $projets = Projet::all();
        return view('evenements.edit', compact('evenement', 'projets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evenement $evenement): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'lieu' => 'nullable|string|max:255',
            'nombre_participants_max' => 'nullable|integer|min:1',
            'statut' => 'required|in:planifie,en_cours,termine,annule',
            'projet_id' => 'required|exists:projets,id'
        ]);

        $evenement->update($validated);

        return redirect()->route('evenements.index')
            ->with('success', 'Événement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evenement $evenement): RedirectResponse
    {
        $evenement->delete();

        return redirect()->route('evenements.index')
            ->with('success', 'Événement supprimé avec succès.');
    }
}
