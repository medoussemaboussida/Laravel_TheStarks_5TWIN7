<?php

namespace App\Http\Controllers;
use App\Models\RapportBesoin;
use Illuminate\Http\Request;

class RapportBesoinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $rapportBesoins = RapportBesoin::orderBy('created_at', 'desc')->get();
        return view('admin_dashboard.espaceVert', compact('rapportBesoins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $rapportBesoins = RapportBesoin::all(); // Ensure data is available
        return view('admin_dashboard.espaceVert', compact('rapportBesoins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                $validatedData = $request->validate([
            'date_rapport' => 'required|date',
            'description' => 'required|string',
            'priorite' => 'required|in:faible,moyenne,élevée',
            'cout_estime' => 'required|numeric',
            'statut' => 'required|in:en attente,en cours,réalisé',
            'espace_vert_id' => 'required|exists:espace_verts,id',
        ]);

        try {
            RapportBesoin::create($validatedData);
            return redirect()->route('espace.index')->with('success', 'Rapport Besoin créé avec succès !');
        } catch (\Exception $e) {
            return redirect()->route('espace.index')->with('error', 'Échec de la création du Rapport Besoin. Veuillez réessayer. Error: ' . $e->getMessage());
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
         $rapportBesoin = RapportBesoin::findOrFail($id);
        $rapportBesoins = RapportBesoin::all(); // Keep this for the table
        return view('admin_dashboard.espaceVert', compact('rapportBesoin', 'rapportBesoins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validatedData = $request->validate([
            'date_rapport' => 'required|date',
            'description' => 'required|string',
            'priorite' => 'required|in:faible,moyenne,élevée',
            'cout_estime' => 'required|numeric',
            'statut' => 'required|in:en attente,en cours,réalisé',
            'espace_vert_id' => 'required|exists:espace_verts,id',
        ]);

        try {
            $rapportBesoin = RapportBesoin::findOrFail($id);
            $rapportBesoin->update($validatedData);
            return redirect()->route('espace.index')->with('success', 'Mise à jour effectuée avec succès !');
        } catch (\Exception $e) {
            return redirect()->route('espace.index')->with('error', 'Échec de la mise à jour du Rapport Besoin. Veuillez réessayer. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
                try {
            $rapportBesoin = RapportBesoin::findOrFail($id);
            $rapportBesoin->delete();
            return redirect()->route('espace.index')->with('success', 'Rapport Besoin supprimé avec succès !');
        } catch (\Exception $e) {
            return redirect()->route('espace.index')->with('error', 'Échec de la suppression. Veuillez réessayer. Error: ' . $e->getMessage());
        }
    }
public function indexByEspace($espaceId)
{
    try {
        $rapports = RapportBesoin::where('espace_vert_id', $espaceId)->get(['id', 'date_rapport', 'description', 'priorite', 'cout_estime', 'statut']);
        if ($rapports->isEmpty()) {
            \Log::info("No rapports found for espace_vert_id: $espaceId");
            return response()->json([], 200); // Empty array for no records
        }
        \Log::info("Rapports found for espace_vert_id: $espaceId", $rapports->toArray());
        return response()->json($rapports, 200);
    } catch (\Exception $e) {
        \Log::error("Error loading rapports for espace_vert_id: $espaceId", ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Unable to load rapports'], 500);
    }
}
}
