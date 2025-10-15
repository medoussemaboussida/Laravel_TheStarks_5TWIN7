<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspaceVertController;
use App\Http\Controllers\RapportBesoinController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});
Route::resource('espace', EspaceVertController::class);
Route::resource('rapport-besoins', RapportBesoinController::class);
Route::get('/client', [EspaceVertController::class, 'displayClient'])->name('client.index');
Route::get('/rapports/{id}', [RapportBesoinController::class, 'indexByEspace'])->name('rapport-besoins.index-by-espace');
// Chatbot route
Route::get('/chatbot', [EspaceVertController::class, 'chatbotPage'])->name('chatbot');
Route::post('/api/chat', [EspaceVertController::class, 'chat'])->name('espace.chat');
require __DIR__.'/auth.php';
