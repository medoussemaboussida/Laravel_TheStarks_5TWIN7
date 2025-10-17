<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaceVert;
class EspaceVertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'newest');
        $search = $request->input('search');

        $query = EspaceVert::query();
        match ($sort) {
            'oldest' => $query->orderBy('created_at', 'asc'),
            'superficie_asc' => $query->orderBy('superficie', 'asc'),
            'superficie_desc' => $query->orderBy('superficie', 'desc'),
            'name_asc' => $query->orderBy('nom', 'asc'),
            'name_desc' => $query->orderBy('nom', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('adresse', 'like', "%$search%")
                  ->orWhere('superficie', 'like', "%$search%")
                  ->orWhere('type', 'like', "%$search%")
                  ->orWhere('etat', 'like', "%$search%")
                  ->orWhere('besoin_specifique', 'like', "%$search%");
            });
        }

        $espacesVerts = $query->with('rapportBesoins')->get(); // Eager load rapports

        if ($request->ajax()) {
            return response()->json($espacesVerts);
        }
        return view('admin_dashboard.espaceVert', compact('espacesVerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $espacesVerts = EspaceVert::all(); // Ensure data is available
        return view('admin_dashboard.espaceVert', compact('espacesVerts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'nom' => 'required|string|max:50|min:3',
            'adresse' => 'required|string|max:25|min:5',
            'superficie' => 'required|numeric',
            'type' => 'required|in:parc,jardin,toit vert,autre',
            'etat' => 'required|in:bon,moyen,mauvais',
            'besoin_specifique' => 'nullable|string',
        ]);

        try {
            // Create a new EspaceVert record
            EspaceVert::create($validatedData);

            // Redirect with success message
            return redirect()->route('espace.create')->with('success', 'Espace Vert créé avec succès !');
        } catch (\Exception $e) {
            // Redirect with error message if creation fails
            return redirect()->route('espace.create')->with('error', '"Échec de la création de l’Espace Vert. Veuillez réessayer. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $espaceVert = EspaceVert::findOrFail($id);
        $espacesVerts = EspaceVert::all(); // Keep this for the table
        return view('admin_dashboard.create', compact('espaceVert', 'espacesVerts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'superficie' => 'required|numeric',
            'type' => 'required|in:parc,jardin,toit vert,autre',
            'etat' => 'required|in:bon,moyen,mauvais',
            'besoin_specifique' => 'nullable|string',
        ]);

        try {
            $espaceVert = EspaceVert::findOrFail($id);
            $espaceVert->update($validatedData);
            return redirect()->route('espace.index')->with('success', 'Mise à jour effectuée avec succès !');
        } catch (\Exception $e) {
            return redirect()->route('espace.index')->with('error', 'Échec de la mise à jour de l’Espace Vert. Veuillez réessayer. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $espaceVert = EspaceVert::findOrFail($id);
            $espaceVert->delete();
            return redirect()->route('espace.index')->with('success', 'Espace Vert supprimé avec succès !');
        } catch (\Exception $e) {
            return redirect()->route('espace.index')->with('error', 'Échec de la suppression. Veuillez réessayer. Error: ' . $e->getMessage());
        }
    }
       /**
     * Display client page with Espace Vert data.
     */
    public function displayClient(Request $request)
    {
        $espacesVerts = EspaceVert::orderBy('created_at', 'desc')->get();
        $publications = \App\Models\Publication::with('user')->orderBy('created_at', 'desc')->get();

        // Recherche et filtrage des bâtiments
        $searchBatiment = $request->input('search_batiment');
        $queryBatiments = \App\Models\Batiment::with('zone');

        if ($searchBatiment) {
            $queryBatiments->where(function ($q) use ($searchBatiment) {
                $q->where('type_batiment', 'like', "%$searchBatiment%")
                  ->orWhere('adresse', 'like', "%$searchBatiment%")
                  ->orWhereHas('zone', function ($zoneQuery) use ($searchBatiment) {
                      $zoneQuery->where('nom', 'like', "%$searchBatiment%");
                  });
            });
        }

        $batiments = $queryBatiments->orderBy('created_at', 'desc')->get();
        $zones = \App\Models\ZoneUrbaine::all();

        // Si c'est une requête AJAX pour les bâtiments
        if ($request->ajax() && $request->has('search_batiment')) {
            return response()->json($batiments->map(function ($batiment) {
                return [
                    'id' => $batiment->id,
                    'type_batiment' => $batiment->type_batiment,
                    'adresse' => $batiment->adresse,
                    'emissionCO2' => $batiment->emission_c_o2,
                    'emissionReelle' => $batiment->emission_reelle,
                    'pourcentageRenouvelable' => $batiment->pourcentage_renouvelable,
                    'nbArbresBesoin' => $batiment->nbArbresBesoin,
                    'zone' => $batiment->zone ? $batiment->zone->nom : null,
                    'nbHabitants' => $batiment->nb_habitants,
                    'nbEmployes' => $batiment->nb_employes,
                    'typeIndustrie' => $batiment->type_industrie,
                ];
            }));
        }

        return view('client_page.client', compact('espacesVerts', 'publications', 'batiments', 'zones'));
    }
}
