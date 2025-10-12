<?php

namespace App\Http\Controllers;

use App\Models\RapportBesoin;
use App\Models\EspaceVert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RapportBesoinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RapportBesoin::with('espaceVert');

        // Handle search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', '%' . $request->search . '%')
                  ->orWhereDate('date_rapport', 'like', '%' . $request->search . '%');
            });
        }

        // Handle sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'date_rapport_asc':
                $query->orderBy('date_rapport', 'asc');
                break;
            case 'date_rapport_desc':
                $query->orderBy('date_rapport', 'desc');
                break;
            case 'priorite_asc':
                $query->orderBy('priorite', 'asc');
                break;
            case 'priorite_desc':
                $query->orderBy('priorite', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $rapportBesoins = $query->get();
        $espaceVerts = EspaceVert::all();

        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json($rapportBesoins->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date_rapport' => $item->date_rapport,
                    'description' => $item->description,
                    'priorite' => $item->priorite,
                    'cout_estime' => $item->cout_estime,
                    'statut' => $item->statut,
                    'espace_vert_id' => $item->espace_vert_id,
                    'espace_vert_nom' => $item->espaceVert->nom ?? 'N/A',
                ];
            }));
        }

        return view('admin_dashboard.rapportBesoin', compact('rapportBesoins', 'espaceVerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rapportBesoins = RapportBesoin::all(); // Keep for table if needed
        $espaceVerts = EspaceVert::all(); // For dropdown in form
        return view('admin_dashboard.rapportBesoin', compact('rapportBesoins', 'espaceVerts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date_rapport' => 'required|date|after_or_equal:today',
            'description' => 'required|string|max:1000',
            'priorite' => 'required|in:faible,moyenne,élevée',
            'cout_estime' => 'required|numeric|min:0',
            'statut' => 'required|in:en attente,en cours,réalisé',
            'espace_vert_id' => 'required|exists:espace_verts,id|integer',
        ], [
            'date_rapport.required' => 'La date du rapport est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'priorite.required' => 'La priorité est obligatoire.',
            'cout_estime.required' => 'Le coût estimé est obligatoire.',
            'statut.required' => 'Le statut est obligatoire.',
            'espace_vert_id.required' => 'L\'espace vert est obligatoire.',
        ]);

        try {
            RapportBesoin::create($validatedData);
            return redirect()->route('rapport-besoins.index')->with('success', 'Rapport Besoin créé avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur création RapportBesoin: ' . $e->getMessage());
            return redirect()->route('rapport-besoins.index')->with('error', 'Échec de la création du Rapport Besoin. Veuillez réessayer.');
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
        $rapportBesoins = RapportBesoin::all(); // Keep for table
        $espaceVerts = EspaceVert::all(); // For dropdown in form
        return view('admin_dashboard.rapportBesoin', compact('rapportBesoin', 'rapportBesoins', 'espaceVerts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'date_rapport' => 'required|date|after_or_equal:today',
            'description' => 'required|string|max:1000',
            'priorite' => 'required|in:faible,moyenne,élevée',
            'cout_estime' => 'required|numeric|min:0',
            'statut' => 'required|in:en attente,en cours,réalisé',
            'espace_vert_id' => 'required|exists:espace_verts,id|integer',
        ], [
            'date_rapport.required' => 'La date du rapport est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'priorite.required' => 'La priorité est obligatoire.',
            'cout_estime.required' => 'Le coût estimé est obligatoire.',
            'statut.required' => 'Le statut est obligatoire.',
            'espace_vert_id.required' => 'L\'espace vert est obligatoire.',
        ]);

        try {
            $rapportBesoin = RapportBesoin::findOrFail($id);
            $rapportBesoin->update($validatedData);
            return redirect()->route('rapport-besoins.index')->with('success', 'Mise à jour effectuée avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour RapportBesoin ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('rapport-besoins.index')->with('error', 'Échec de la mise à jour du Rapport Besoin. Veuillez réessayer.');
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
            return redirect()->route('rapport-besoins.index')->with('success', 'Rapport Besoin supprimé avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur suppression RapportBesoin ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('rapport-besoins.index')->with('error', 'Échec de la suppression. Veuillez réessayer.');
        }
    }

    /**
     * Get rapports by espace vert ID (API endpoint).
     */
    public function indexByEspace($espaceId)
    {
        try {
            $rapports = RapportBesoin::where('espace_vert_id', $espaceId)
                ->select(['id', 'date_rapport', 'description', 'priorite', 'cout_estime', 'statut'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            if ($rapports->isEmpty()) {
                Log::info("No rapports found for espace_vert_id: $espaceId");
                return response()->json([], 200);
            }
            
            Log::info("Rapports found for espace_vert_id: $espaceId", $rapports->toArray());
            return response()->json($rapports, 200);
        } catch (\Exception $e) {
            Log::error("Error loading rapports for espace_vert_id: $espaceId", ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to load rapports'], 500);
        }
    }
}