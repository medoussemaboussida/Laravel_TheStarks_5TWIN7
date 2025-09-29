<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicationController extends Controller
{
    // ...existing code...

    // Afficher le formulaire d'édition d'un commentaire (optionnel, pour inline ou modal)
    public function editComment($commentId)
    {
        $comment = \App\Models\Comment::findOrFail($commentId);
        if (auth()->id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'Vous ne pouvez modifier que vos propres commentaires.');
        }
        // Pour un modal ou inline, on peut retourner le commentaire (sinon, non utilisé)
        return response()->json($comment);
    }

    // Mettre à jour un commentaire
    public function updateComment(Request $request, $commentId)
    {
        $comment = \App\Models\Comment::findOrFail($commentId);
        if (auth()->id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'Vous ne pouvez modifier que vos propres commentaires.');
        }
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        $comment->content = $request->input('content');
        $comment->save();
        return redirect()->back()->with('success', 'Commentaire modifié avec succès!');
    }

    // Supprimer un commentaire
    public function destroyComment($commentId)
    {
        $comment = \App\Models\Comment::findOrFail($commentId);
        if (auth()->id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'Vous ne pouvez supprimer que vos propres commentaires.');
        }
        $comment->delete();
        return redirect()->back()->with('success', 'Commentaire supprimé avec succès!');
    }
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
    // Affichage des détails d'une publication
    public function show($id)
    {
        $publication = \App\Models\Publication::with(['user', 'comments.user'])->findOrFail($id);
        return view('layouts.details', compact('publication'));
    }

    // Enregistrer un commentaire
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'Vous devez être connecté pour commenter.');
        }
        $publication = \App\Models\Publication::findOrFail($id);
        $publication->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);
        return redirect()->back()->with('success', 'Commentaire ajouté avec succès!');
    }
}
