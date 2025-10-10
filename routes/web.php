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

// Rutas para el Sistema de Estacionamiento
Route::prefix('parking')->name('parking.')->group(function () {
    // Listado de vehículos estacionados
    Route::get('/', [App\Http\Controllers\ParkingController::class, 'index'])->name('index');
    // Entrada de vehículos
    Route::get('/entry', [App\Http\Controllers\ParkingController::class, 'createEntry'])->name('entry.create');
    Route::post('/entry', [App\Http\Controllers\ParkingController::class, 'storeEntry'])->name('entry.store');
    
    // Ticket de estacionamiento
    Route::get('/ticket/{id}', [App\Http\Controllers\ParkingController::class, 'showTicket'])->name('ticket');
    
    // Salida de vehículos
    Route::get('/exit', [App\Http\Controllers\ParkingController::class, 'createExit'])->name('exit.create');
    Route::post('/exit/preview', [App\Http\Controllers\ParkingController::class, 'showExitPreview'])->name('exit.preview');
    Route::post('/exit/{id}/process', [App\Http\Controllers\ParkingController::class, 'processExit'])->name('exit.process');
    
    // Proceso de pago
    Route::get('/payment/{id}', [App\Http\Controllers\ParkingController::class, 'showPayment'])->name('payment');
    Route::post('/payment/{id}/process', [App\Http\Controllers\ParkingController::class, 'processPayment'])->name('payment.process');
});
