<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas para Fiscales
Route::resource('prosecutors', App\Http\Controllers\ProsecutorController::class);

// Rutas para Tarifas
Route::resource('rates', App\Http\Controllers\RateController::class);
