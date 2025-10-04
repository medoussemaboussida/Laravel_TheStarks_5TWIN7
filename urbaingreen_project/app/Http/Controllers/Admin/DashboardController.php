<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Evenement;
use App\Models\Inscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord administrateur
     */
    public function index(): View
    {
        // Statistiques générales
        $stats = [
            'total_projets' => Projet::count(),
            'projets_en_cours' => Projet::where('statut', 'en_cours')->count(),
            'total_evenements' => Evenement::count(),
            'evenements_a_venir' => Evenement::where('date_debut', '>', now())->count(),
            'total_inscriptions' => Inscription::count(),
            'inscriptions_confirmees' => Inscription::where('statut', 'confirmee')->count(),
            'total_utilisateurs' => User::count(),
            'nouveaux_utilisateurs_mois' => User::whereMonth('created_at', now()->month)->count(),
        ];

        // Projets récents
        $projets_recents = Projet::with('evenements')
            ->latest()
            ->take(5)
            ->get();

        // Événements à venir
        $evenements_a_venir = Evenement::with(['projet', 'inscriptions'])
            ->where('date_debut', '>', now())
            ->orderBy('date_debut')
            ->take(5)
            ->get();

        // Inscriptions récentes
        $inscriptions_recentes = Inscription::with(['user', 'evenement'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'projets_recents',
            'evenements_a_venir',
            'inscriptions_recentes'
        ));
    }
}
