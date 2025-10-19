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
    return redirect('/login');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/adminpublication', [PublicationController::class, 'index'])->name('admin.publications.index');

    // Gestion des bâtiments - Admin
    Route::get('/adminbatiment', [BatimentController::class, 'index'])->name('backoffice.indexbatiment');
    Route::get('/adminbatiment/create', [BatimentController::class, 'create'])->name('backoffice.createbatiment');
    Route::post('/adminbatiment', [BatimentController::class, 'storeAdmin'])->name('backoffice.storebatiment');
    Route::get('/adminbatiment/{batiment}', [BatimentController::class, 'show'])->name('backoffice.showbatiment');
    Route::get('/adminbatiment/{batiment}/edit', [BatimentController::class, 'edit'])->name('backoffice.editbatiment');
    Route::put('/adminbatiment/{batiment}', [BatimentController::class, 'updateAdmin'])->name('backoffice.updatebatiment');
    Route::delete('/adminbatiment/{batiment}', [BatimentController::class, 'destroyAdmin'])->name('backoffice.destroybatiment');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});
Route::resource('espace', EspaceVertController::class)->middleware('admin');
Route::resource('rapport-besoins', RapportBesoinController::class);
// Chatbot route
Route::get('/chatbot', [EspaceVertController::class, 'chatbotPage'])->name('chatbot');
Route::post('/api/chat', [EspaceVertController::class, 'chat'])->name('espace.chat');
Route::get('/client', [EspaceVertController::class, 'displayClient'])->name('client.index');
Route::get('/client/batiment/{id}', [BatimentController::class, 'getBatimentData'])->name('client.batiment.data');
// Front-office batiment routes (create / update / delete from client page)
Route::post('/batiments', [BatimentController::class, 'store'])->name('batiments.store');
Route::post('/batiments/{batiment}', [BatimentController::class, 'update'])->name('batiments.update');
Route::delete('/batiments/{id}', [BatimentController::class, 'destroyFrontoffice'])->name('batiments.destroy');
Route::get('/rapports/{id}', [RapportBesoinController::class, 'indexByEspace'])->name('rapport-besoins.index-by-espace');
// Route pour modifier un commentaire
Route::patch('/commentaires/{comment}', [PublicationController::class, 'updateComment'])->name('commentaires.update');
// Route pour supprimer un commentaire
Route::delete('/commentaires/{comment}', [PublicationController::class, 'destroyComment'])->name('commentaires.destroy');

// Route pour afficher la liste des publications avec recherche
Route::get('/publications', [PublicationController::class, 'index'])->name('publications.index');
// Route pour afficher les détails d'une publication
Route::get('/publications/{publication}', [PublicationController::class, 'show'])->name('publications.show');
// Route pour ajouter un commentaire
Route::post('/publications/{publication}/comment', [PublicationController::class, 'addComment'])->name('publications.comment');
// Route pour like une publication
Route::post('/publications/{publication}/like', [PublicationController::class, 'like'])->name('publications.like');
// Route pour dislike une publication
Route::post('/publications/{publication}/dislike', [PublicationController::class, 'dislike'])->name('publications.dislike');
// Route pour l'ajout de publication
Route::post('/publications', [PublicationController::class, 'store'])->name('publications.store');
// Route de modification de publication
Route::patch('/publications/{publication}', [PublicationController::class, 'update'])->name('publications.update');
// Route de suppression de publication
Route::delete('/publications/{publication}', [PublicationController::class, 'destroy'])->name('publications.destroy');

require __DIR__.'/auth.php';
