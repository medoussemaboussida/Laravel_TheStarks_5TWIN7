<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ZoneUrbaine;

class ZoneUrbaineController extends Controller
{
    public function __construct()
    {
        // No constructor needed for Eloquent
    }

    /**
     * Afficher la liste des zones urbaines
     */
    public function index(Request $request)
    {
        $query = ZoneUrbaine::query();

        // Recherche par nom
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nom', 'LIKE', '%' . $search . '%');
        }

        // Tri par défaut : nom ascendant
        $query->orderBy('nom', 'asc');

        $zones = $query->paginate(10)->appends($request->query());

        // Calculer les statistiques
        $stats = [
            'total_zones' => ZoneUrbaine::count(),
        ];

        return view('admin_dashboard.zones_index', compact('zones', 'stats'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin_dashboard.zones_create');
    }

    /**
     * Enregistrer une nouvelle zone urbaine
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:zones_urbaines,nom',
            'surface' => 'nullable|numeric|min:0',
        ]);

        ZoneUrbaine::create([
            'nom' => $request->nom,
            'surface' => $request->surface,
        ]);

        return redirect()->route('admin.zones.index')->with('success', 'Zone urbaine créée avec succès.');
    }

    /**
     * Afficher les détails d'une zone urbaine
     */
    public function show(ZoneUrbaine $zone)
    {
        // Récupérer les bâtiments associés à cette zone
        $batiments = $zone->batiments()->with('user')->get();

        // Calculer les statistiques pour cette zone
        $stats = [
            'total_batiments' => $batiments->count(),
            'total_emissions' => $batiments->sum('emission_c_o2'),
            'total_employes' => $batiments->sum('nb_employes'),
            'total_habitants' => $batiments->sum('nb_habitants'),
            'moyenne_renouvelable' => $batiments->avg('pourcentage_renouvelable'),
        ];

        return view('admin_dashboard.zones_show', compact('zone', 'batiments', 'stats'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(ZoneUrbaine $zone)
    {
        return view('admin_dashboard.zones_edit', compact('zone'));
    }

    /**
     * Mettre à jour une zone urbaine
     */
    public function update(Request $request, ZoneUrbaine $zone)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:zones_urbaines,nom,' . $zone->id,
            'surface' => 'nullable|numeric|min:0',
        ]);

        $zone->update([
            'nom' => $request->nom,
            'surface' => $request->surface,
        ]);

        return redirect()->route('admin.zones.index')->with('success', 'Zone urbaine mise à jour avec succès.');
    }

    /**
     * Supprimer une zone urbaine
     */
    public function destroy(ZoneUrbaine $zone)
    {
        // Vérifier si la zone a des bâtiments associés
        if ($zone->batiments()->count() > 0) {
            return redirect()->route('admin.zones.index')->with('error', 'Impossible de supprimer cette zone car elle contient des bâtiments.');
        }

        $zone->delete();

        return redirect()->route('admin.zones.index')->with('success', 'Zone urbaine supprimée avec succès.');
    }

    /**
     * API: Récupérer les zones pour les selects
     */
    public function getZones()
    {
        $zones = ZoneUrbaine::select('id', 'nom')->orderBy('nom')->get();
        return response()->json($zones);
    }
}