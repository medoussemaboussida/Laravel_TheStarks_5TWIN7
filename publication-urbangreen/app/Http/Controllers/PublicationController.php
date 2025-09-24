<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PublicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        // Upload image dans storage/app/public/publications
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('publications', 'public');
        } else {
            $path = null;
        }

        // Enregistrement
        $publication = \App\Models\Publication::create([
            'titre' => $validated['titre'],
            'image' => $path, // stocke le chemin relatif
            'description' => $validated['description'],
        ]);

        return redirect()->back()->with('success', 'Publication ajoutée avec succès!');
    }

    // Modification d'une publication
    public function update(Request $request, $id)
    {
        $publication = \App\Models\Publication::findOrFail($id);
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        // Si une nouvelle image est uploadée, remplacer l'ancienne
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($publication->image && \Storage::disk('public')->exists($publication->image)) {
                \Storage::disk('public')->delete($publication->image);
            }
            $path = $request->file('image')->store('publications', 'public');
            $publication->image = $path;
        }

        $publication->titre = $validated['titre'];
        $publication->description = $validated['description'];
        $publication->save();

        return redirect()->back()->with('success', 'Publication modifiée avec succès!');
    }

    // Suppression d'une publication
    public function destroy($id)
    {
        $publication = \App\Models\Publication::findOrFail($id);
        // Supprimer l'image du disque si elle existe
        if ($publication->image && \Storage::disk('public')->exists($publication->image)) {
            \Storage::disk('public')->delete($publication->image);
        }
        $publication->delete();
        return redirect()->back()->with('success', 'Publication supprimée avec succès!');
    }
}
