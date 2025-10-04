<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Evenement;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PublicController extends Controller
{
    /**
     * Page d'accueil publique
     */
    public function home(): View
    {
        $projets_featured = Projet::where('statut', 'en_cours')
            ->with('evenements')
            ->latest()
            ->take(3)
            ->get();

        $evenements_a_venir = Evenement::with('projet')
            ->where('date_debut', '>', now())
            ->orderBy('date_debut')
            ->take(4)
            ->get();

        $stats = [
            'total_projets' => Projet::count(),
            'projets_actifs' => Projet::whereIn('statut', ['en_cours', 'planifie'])->count(),
            'total_evenements' => Evenement::count(),
            'participants_total' => Inscription::where('statut', 'confirmee')->count(),
        ];

        return view('public.home', compact('projets_featured', 'evenements_a_venir', 'stats'));
    }

    /**
     * Liste des projets publique
     */
    public function projets(): View
    {
        $projets = Projet::with(['evenements' => function($query) {
                $query->where('date_debut', '>', now());
            }])
            ->whereIn('statut', ['planifie', 'en_cours', 'termine'])
            ->latest()
            ->paginate(9);

        return view('public.projets.index', compact('projets'));
    }

    /**
     * Détail d'un projet
     */
    public function projetShow(Projet $projet): View
    {
        $projet->load(['evenements' => function($query) {
            $query->orderBy('date_debut');
        }]);

        $evenements_a_venir = $projet->evenements()
            ->where('date_debut', '>', now())
            ->orderBy('date_debut')
            ->get();

        return view('public.projets.show', compact('projet', 'evenements_a_venir'));
    }

    /**
     * Liste des événements publique
     */
    public function evenements(): View
    {
        $evenements = Evenement::with(['projet', 'inscriptions'])
            ->where('date_debut', '>', now())
            ->orderBy('date_debut')
            ->paginate(12);

        return view('public.evenements.index', compact('evenements'));
    }

    /**
     * Détail d'un événement
     */
    public function evenementShow(Evenement $evenement): View
    {
        $evenement->load(['projet', 'inscriptions.user']);

        $user_inscription = null;
        if (auth()->check()) {
            $user_inscription = $evenement->inscriptions()
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('public.evenements.show', compact('evenement', 'user_inscription'));
    }

    /**
     * S'inscrire à un événement
     */
    public function inscrireEvenement(Request $request, Evenement $evenement): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour vous inscrire.');
        }

        // Vérifier si l'événement est complet
        if ($evenement->isComplet()) {
            return back()->with('error', 'Cet événement est complet.');
        }

        // Vérifier si l'utilisateur est déjà inscrit
        if ($evenement->userIsInscrit(auth()->user())) {
            return back()->with('error', 'Vous êtes déjà inscrit à cet événement.');
        }

        $validated = $request->validate([
            'commentaire' => 'nullable|string|max:500'
        ]);

        Inscription::create([
            'user_id' => auth()->id(),
            'evenement_id' => $evenement->id,
            'statut' => 'en_attente',
            'commentaire' => $validated['commentaire'] ?? null,
            'date_inscription' => now(),
        ]);

        return back()->with('success', 'Votre inscription a été enregistrée avec succès !');
    }

    /**
     * Annuler une inscription
     */
    public function annulerInscription(Evenement $evenement): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $inscription = Inscription::where('user_id', auth()->id())
            ->where('evenement_id', $evenement->id)
            ->first();

        if (!$inscription) {
            return back()->with('error', 'Aucune inscription trouvée.');
        }

        $inscription->update(['statut' => 'annulee']);

        return back()->with('success', 'Votre inscription a été annulée.');
    }

    /**
     * Page À propos
     */
    public function about(): View
    {
        return view('public.about');
    }

    /**
     * Page Contact
     */
    public function contact(): View
    {
        return view('public.contact');
    }
}
