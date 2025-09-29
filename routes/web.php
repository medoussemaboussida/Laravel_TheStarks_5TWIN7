<?php

use App\Http\Controllers\BatimentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ZoneUrbaineController;

// Route accueil
Route::get('/', function () {
    return view('home');
})->name('home');

// Route admin
Route::get('/backOffice', [AdminController::class, 'dashboard'])->name('admin.dashboard');

use Doctrine\ORM\EntityManagerInterface;

Route::get('/backoffice/indexbatiment', function () {
    $em = app(EntityManagerInterface::class);
    $batiments = $em->getRepository(\App\Entities\Batiment::class)->findAll();
    return view('admin.batiments.index', compact('batiments'));
})->name('backoffice.indexbatiment');

Route::get('/backoffice/createbatiment', function () {
    $em = app(EntityManagerInterface::class);
    $zones = $em->getRepository(\App\Entities\ZoneUrbaine::class)->findAll();
    return view('admin.batiments.create', compact('zones'));
})->name('backoffice.createbatiment');

Route::get('/backoffice/editbatiment/{id}', function ($id) {
    $em = app(EntityManagerInterface::class);
    $batiment = $em->getRepository(\App\Entities\Batiment::class)->find($id);
    $zones = $em->getRepository(\App\Entities\ZoneUrbaine::class)->findAll();
    return view('admin.batiments.edit', compact('batiment', 'zones'));
})->name('backoffice.editbatiment');

Route::middleware('web')->group(function () {
    Route::resource('batiments', BatimentController::class)->except(['destroy']);
    Route::delete('/admin/batiments/{id}/delete', [BatimentController::class, 'destroyBackoffice'])->name('batiments.destroyBackoffice');
    Route::delete('/batiments/{id}/delete', [BatimentController::class, 'destroyFrontoffice'])->name('batiments.destroyFrontoffice');
});

// Route index zones urbaines pour la sidebar
Route::get('/admin/zones', [ZoneUrbaineController::class, 'index'])->name('zones.index');