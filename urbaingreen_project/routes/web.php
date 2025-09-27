<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\Public\PublicController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProjetController;
use App\Http\Controllers\Admin\AdminEvenementController;
use App\Http\Controllers\Admin\InscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirection vers l'interface publique
Route::get('/', [PublicController::class, 'home'])->name('public.home');

// Routes publiques (interface citoyens)
Route::prefix('')->name('public.')->group(function () {
    Route::get('/projets', [PublicController::class, 'projets'])->name('projets.index');
    Route::get('/projets/{projet}', [PublicController::class, 'projetShow'])->name('projets.show');
    Route::get('/evenements', [PublicController::class, 'evenements'])->name('evenements.index');
    Route::get('/evenements/{evenement}', [PublicController::class, 'evenementShow'])->name('evenements.show');
    Route::get('/a-propos', [PublicController::class, 'about'])->name('about');
    Route::get('/contact', [PublicController::class, 'contact'])->name('contact');

    // Routes nécessitant une authentification
    Route::middleware('auth')->group(function () {
        Route::post('/evenements/{evenement}/inscrire', [PublicController::class, 'inscrireEvenement'])->name('evenements.inscrire');
        Route::delete('/evenements/{evenement}/annuler', [PublicController::class, 'annulerInscription'])->name('evenements.annuler');
        Route::get('/profil', [PublicController::class, 'profile'])->name('profile');
        Route::get('/mes-inscriptions', [PublicController::class, 'mesInscriptions'])->name('mes-inscriptions');
    });
});

// Routes d'administration
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestion des projets
    Route::resource('projets', AdminProjetController::class);

    // Gestion des événements
    Route::resource('evenements', AdminEvenementController::class);

    // Gestion des inscriptions
    Route::resource('inscriptions', InscriptionController::class);

    // Routes additionnelles
    Route::get('/profile', function() { return view('admin.profile'); })->name('profile');
    Route::get('/settings', function() { return view('admin.settings'); })->name('settings');
});

// Routes anciennes (pour compatibilité)
Route::prefix('old')->group(function () {
    Route::resource('projets', ProjetController::class);
    Route::resource('evenements', EvenementController::class);
});

// Routes Breeze par défaut
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
