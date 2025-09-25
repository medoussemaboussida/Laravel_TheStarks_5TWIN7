<?php

use App\Http\Controllers\BatimentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('web')->group(function () {
    Route::resource('batiments', \App\Http\Controllers\BatimentController::class);
});


