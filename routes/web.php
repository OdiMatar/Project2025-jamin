<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Controllers
use App\Http\Controllers\AllergeenController;
use App\Http\Controllers\MagazijnController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductDeliveryController;
use App\Http\Controllers\LeverantieInfoController;
use App\Http\Controllers\ProductAllergeenController;
use App\Http\Controllers\LeverancierController;
Route::get('/', function () {
    return view('welcome');
})->name('home');

/**
 * Allergeen CRUD
 */
Route::get('/Allergeen', [AllergeenController::class, 'index'])->name('allergeen.index');
Route::get('/Allergeen/create', [AllergeenController::class, 'create'])->name('allergeen.create');
Route::post('/Allergeen', [AllergeenController::class, 'store'])->name('allergeen.store');
Route::get('/Allergeen/{id}/edit', [AllergeenController::class, 'edit'])->name('allergeen.edit');
Route::put('/Allergeen/{id}', [AllergeenController::class, 'update'])->name('allergeen.update');
Route::delete('/Allergeen/{id}', [AllergeenController::class, 'destroy'])->name('allergeen.destroy');

/** ✅ NIEUW: details op ID */
Route::get('/Allergeen/{id}', [AllergeenController::class, 'show'])->name('allergeen.show');

/** ✅ User Story 1: Overzicht producten met allergenen */
Route::get('/overzicht-allergenen', [AllergeenController::class, 'productenOverzicht'])
    ->name('allergeen.producten.overzicht')
    ->middleware('auth');

/** ✅ User Story 1 - Scenario 2 & 3: Leverancier info pagina */
Route::get('/overzicht-allergenen/leverancier/{productId}', [AllergeenController::class, 'leverancierInfo'])
    ->name('allergeen.leverancier.info')
    ->middleware('auth');

/**
 * ✅ Magazijn
 */
Route::get('/magazijn', [MagazijnController::class, 'index'])->name('magazijn.index');

/**
 * ➕ Leverantie detailpagina
 */
Route::get('/producten/{product}/leverantie-info', [LeverantieInfoController::class, 'show'])
    ->name('leverantie.info.show');

Route::get('/magazijn/{product}/allergenen', [\App\Http\Controllers\AllergeenController::class, 'product'])
    ->name('magazijn.allergenen.show');

/**
 * ➕ Leveranciers detailpagina
 */
Route::middleware(['auth'])->group(function () {

    // Overzicht leveranciers (Wireframe-02)
    Route::get('/leveranciers', [LeverancierController::class, 'index'])
        ->name('leverancier.index');

    // Geleverde producten (BESTAAND – laten staan)
    Route::get('/leveranciers/{leverancier}/producten', [LeverancierController::class, 'show'])
        ->name('leverancier.show');

    // 🔹 Leverancier details (Wireframe-03)
    Route::get('/leveranciers/{leverancier}', [LeverancierController::class, 'details'])
        ->name('leverancier.details');

    // 🔹 Wijzigen leverancier (Wireframe-04)
    Route::get('/leveranciers/{leverancier}/wijzig', [LeverancierController::class, 'edit'])
        ->name('leverancier.edit');

    Route::put('/leveranciers/{leverancier}', [LeverancierController::class, 'update'])
        ->name('leverancier.update');

    // Userstory 2 – nieuwe levering (BESTAAND)
    Route::get(
        '/leveranciers/{leverancier}/producten/{product}/nieuwe-levering',
        [LeverancierController::class, 'createDelivery']
    )->name('leverancier.product.delivery.create');

    Route::post(
        '/leveranciers/{leverancier}/producten/{product}/nieuwe-levering',
        [LeverancierController::class, 'storeDelivery']
    )->name('leverancier.product.delivery.store');

    // Userstory 1 – Overzicht geleverde producten
    Route::get('/overzicht-geleverde-producten', [ProductDeliveryController::class, 'index'])
        ->name('leveringen.overzicht');
});


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

require __DIR__ . '/auth.php';
