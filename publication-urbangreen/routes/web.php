
<?php
use App\Http\Controllers\PublicationController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

// Route pour l'ajout de publication
Route::post('/publications', [PublicationController::class, 'store'])->name('publications.store');
// Route de modification de publication
Route::patch('/publications/{publication}', [PublicationController::class, 'update'])->name('publications.update');
// Route de suppression de publication
Route::delete('/publications/{publication}', [PublicationController::class, 'destroy'])->name('publications.destroy');

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/dashboard', function () {
    $publications = \App\Models\Publication::latest()->get();
    return view('pages.dashboard', [
        'publications' => $publications
    ]);
});

// Settings routes (Livewire)
Route::get('settings/password', Password::class)->name('settings.password');
Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

require __DIR__.'/auth.php';


// Route pour l'ajout de publication
Route::post('/publications', [PublicationController::class, 'store'])->name('publications.store');
// Route de suppression de publication
Route::delete('/publications/{publication}', [PublicationController::class, 'destroy'])->name('publications.destroy');
