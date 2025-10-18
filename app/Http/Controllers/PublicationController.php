<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPublicationNotification;
use App\Models\User;

class PublicationController extends Controller
{
    // Afficher la liste des publications avec recherche
    public function index(Request $request)
    {
        $query = $request->input('search');
        $sort = $request->input('sort', 'desc'); // 'desc' (nouveaux) ou 'asc' (anciens)
        $publications = \App\Models\Publication::with('user')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('titre', 'like', "%$query%")
                         ->orWhere('description', 'like', "%$query%") ;
                });
            })
            ->orderBy('created_at', $sort)
            ->get();

        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            // Retourner uniquement le fragment HTML de la liste des publications
            return response()->view('client_page.partials.publications_list', compact('publications'))->header('Vary', 'Accept');
        }
        return view('adminpublication', compact('publications'));
    }

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
            'user_id' => auth()->id(), // Ajout de l'ID de l'utilisateur authentifié (admin)
        ]);

        // Envoyer un email à tous les utilisateurs (sauf admin)
        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new NewPublicationNotification($publication));
        }

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

    // Like a publication
    public function like(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Vous devez être connecté pour liker.'], 401);
        }

        $publication = \App\Models\Publication::findOrFail($id);
        $userId = auth()->id();

        // Check if user already disliked, remove it
        $existingDislike = \App\Models\PublicationLike::where('user_id', $userId)
            ->where('publication_id', $id)
            ->where('type', 'dislike')
            ->first();
        if ($existingDislike) {
            $existingDislike->delete();
        }

        // Check if user already liked, remove it (toggle off)
        $existingLike = \App\Models\PublicationLike::where('user_id', $userId)
            ->where('publication_id', $id)
            ->where('type', 'like')
            ->first();
        if ($existingLike) {
            $existingLike->delete();
        } else {
            // Create new like
            \App\Models\PublicationLike::create([
                'user_id' => $userId,
                'publication_id' => $id,
                'type' => 'like',
            ]);
        }

        return response()->json([
            'likes_count' => $publication->getLikesCount(),
            'dislikes_count' => $publication->getDislikesCount(),
            'user_liked' => $publication->hasUserLiked($userId),
            'user_disliked' => $publication->hasUserDisliked($userId),
        ]);
    }

    // Dislike a publication
    public function dislike(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Vous devez être connecté pour disliker.'], 401);
        }

        $publication = \App\Models\Publication::findOrFail($id);
        $userId = auth()->id();

        // Check if user already liked, remove it
        $existingLike = \App\Models\PublicationLike::where('user_id', $userId)
            ->where('publication_id', $id)
            ->where('type', 'like')
            ->first();
        if ($existingLike) {
            $existingLike->delete();
        }

        // Check if user already disliked, remove it (toggle off)
        $existingDislike = \App\Models\PublicationLike::where('user_id', $userId)
            ->where('publication_id', $id)
            ->where('type', 'dislike')
            ->first();
        if ($existingDislike) {
            $existingDislike->delete();
        } else {
            // Create new dislike
            \App\Models\PublicationLike::create([
                'user_id' => $userId,
                'publication_id' => $id,
                'type' => 'dislike',
            ]);
        }

        return response()->json([
            'likes_count' => $publication->getLikesCount(),
            'dislikes_count' => $publication->getDislikesCount(),
            'user_liked' => $publication->hasUserLiked($userId),
            'user_disliked' => $publication->hasUserDisliked($userId),
        ]);
    }
}