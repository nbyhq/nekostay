<?php

use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalRecordController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('cats', CatController::class)->except(['destroy', 'show']);

    Route::resource('adoptions', AdoptionController::class)->except(['destroy', 'show']);
    Route::patch('/adoptions/{adoption}/status', [AdoptionController::class, 'updateStatus'])
        ->name('adoptions.updateStatus');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::delete('/cats/{cat}', [CatController::class, 'destroy'])->name('cats.destroy');
    Route::delete('/adoptions/{adoption}', [AdoptionController::class, 'destroy'])->name('adoptions.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::resource('medical-records', MedicalRecordController::class)
        ->only([
            'index',
            'store',
            'update',
            'destroy',
        ]);

});

require __DIR__.'/auth.php';
