<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\ArticleController;

use App\Models\Plant;
use App\Http\Controllers\PlantTypeController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\ClientController;
  // <--- ajouter en haut du fichier si ce n'est pas déjà fait

Route::get('/client', function () {
    $plants = Plant::with('type')->get(); // récupère les plantes avec leur type
    return view('client.home', compact('plants'));
})->name('client.home');




Route::get('/client/plants', function () {
    $plantes = Plant::with('type')->get(); // charger la relation type si besoin
    return view('client.plants_table', compact('plantes'));
})->name('client.plants');




Route::resource('plant-types', PlantTypeController::class);
Route::resource('plants', PlantController::class);

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');



// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Route pour l'exercice 2 : liste des articles
Route::get('/articles', [ArticleController::class, 'index']);

// Route pour l'exercice 1 : advisor avec middleware check.age
Route::get('/advisor', [AdvisorController::class, 'show'])->middleware('check.age');

// Route pour accès refusé si âge < 18
Route::get('/acces-refuse', function () {
    return view('acces-refuse');
});
