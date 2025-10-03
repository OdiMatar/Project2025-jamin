<?php

use livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllergeenController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/Allergeen', [AllergeenController::class, 'index'])->name('allergeen.index');
Route::get('/Allergeen/create', [AllergeenController::class, 'create'])->name('allergeen.create');
Route::post('/Allergeen', [AllergeenController::class, 'store'])->name('allergeen.store');
Route::delete('/Allergeen/{id}', [AllergeenController::class, 'destroy'])->name('allergeen.destroy');
Route::get('/Allergeen/{id}/edit', [AllergeenController::class, 'edit'])->name('allergeen.edit');
Route::put('/Allergeen/{id}', [AllergeenController::class, 'update'])->name('allergeen.update');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';