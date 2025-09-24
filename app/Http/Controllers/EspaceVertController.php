<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaceVert;
class EspaceVertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $espacesVerts = EspaceVert::all();
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
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'superficie' => 'required|numeric',
            'type' => 'required|in:parc,jardin,toit vert,autre',
            'etat' => 'required|in:bon,moyen,mauvais',
            'besoin_specifique' => 'nullable|string',
        ]);

        try {
            // Create a new EspaceVert record
            EspaceVert::create($validatedData);

            // Redirect with success message
            return redirect()->route('espace.create')->with('success', 'Espace Vert created successfully!');
        } catch (\Exception $e) {
            // Redirect with error message if creation fails
            return redirect()->route('espace.create')->with('error', 'Failed to create Espace Vert. Please try again. Error: ' . $e->getMessage());
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
            return redirect()->route('espace.index')->with('success', 'Espace Vert updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('espace.index')->with('error', 'Failed to update Espace Vert. Please try again. Error: ' . $e->getMessage());
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
            return redirect()->route('espace.index')->with('success', 'Espace Vert deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('espace.index')->with('error', 'Failed to delete Espace Vert. Please try again. Error: ' . $e->getMessage());
        }
    }
}
