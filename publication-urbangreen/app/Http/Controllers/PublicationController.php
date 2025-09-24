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
}
