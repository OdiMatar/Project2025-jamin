<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Controllers
use App\Http\Controllers\AllergeenController;
use App\Http\Controllers\MagazijnController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductDeliveryController;

// ➕ NIEUW: deze regel toevoegen
use App\Http\Controllers\LeverantieInfoController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/**
 * Allergeen CRUD
 */
Route::get('/Allergeen', [AllergeenController::class, 'index'])->name('allergeen.index');
Route::get('/Allergeen/create', [AllergeenController::class, 'create'])->name('allergeen.create');
Route::post('/Allergeen', [AllergeenController::class, 'store'])->name('allergeen.store');
Route::delete('/Allergeen/{id}', [AllergeenController::class, 'destroy'])->name('allergeen.destroy');
Route::get('/Allergeen/{id}/edit', [AllergeenController::class, 'edit'])->name('allergeen.edit');
Route::put('/Allergeen/{id}', [AllergeenController::class, 'update'])->name('allergeen.update');

/**
 * ✅ Magazijn
 */
Route::get('/magazijn', [MagazijnController::class, 'index'])->name('magazijn.index');

/**
 * ➕ NIEUW: route naar de leverantie-detailpagina
 * (laat je Product model ongewijzigd; Laravel bindt {product} automatisch)
 */
Route::get('/producten/{product}/leverantie-info', [LeverantieInfoController::class, 'show'])
    ->name('leverantie.info.show');

/**
 * Dashboard
 */
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/**
 * Instellingen via Volt
 */
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
