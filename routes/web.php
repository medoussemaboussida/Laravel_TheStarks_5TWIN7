<?php
use App\Http\Controllers\PublicationController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspaceVertController;
use App\Http\Controllers\BatimentController;
use App\Http\Controllers\RapportBesoinController;

Route::get('/', function () {
    $publications = \App\Models\Publication::latest()->get();
    return view('layouts.front', [
        'publications' => $publications
    ]);
})->name('home');

Route::get('/adminpublication', function () {
    $publications = \App\Models\Publication::latest()->get();
    return view('adminpublication', [
        'publications' => $publications
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});
Route::resource('espace', EspaceVertController::class);
Route::resource('rapport-besoins', RapportBesoinController::class);
Route::get('/client', [EspaceVertController::class, 'displayClient'])->name('client.index');
// Front-office batiment routes (create / update / delete from client page)
Route::post('/batiments', [BatimentController::class, 'store'])->name('batiments.store');
Route::patch('/batiments/{batiment}', [BatimentController::class, 'update'])->name('batiments.update');
Route::delete('/batiments/{id}', [BatimentController::class, 'destroyFrontoffice'])->name('batiments.destroy');
Route::get('/rapports/{id}', [RapportBesoinController::class, 'indexByEspace'])->name('rapport-besoins.index-by-espace');
// Route pour modifier un commentaire
Route::patch('/commentaires/{comment}', [PublicationController::class, 'updateComment'])->name('commentaires.update');
// Route pour supprimer un commentaire
Route::delete('/commentaires/{comment}', [PublicationController::class, 'destroyComment'])->name('commentaires.destroy');

// Route pour afficher les détails d'une publication
Route::get('/publications/{publication}', [PublicationController::class, 'show'])->name('publications.show');
// Route pour ajouter un commentaire
Route::post('/publications/{publication}/comment', [PublicationController::class, 'addComment'])->name('publications.comment');
// Route pour l'ajout de publication
Route::post('/publications', [PublicationController::class, 'store'])->name('publications.store');
// Route de modification de publication
Route::patch('/publications/{publication}', [PublicationController::class, 'update'])->name('publications.update');
// Route de suppression de publication
Route::delete('/publications/{publication}', [PublicationController::class, 'destroy'])->name('publications.destroy');

require __DIR__.'/auth.php';
