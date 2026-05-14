<?php

use App\Http\Controllers\ArchivedConceptController;
use App\Http\Controllers\ConceptController;
use App\Http\Controllers\ConceptStatusController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('domains', DomainController::class);
    Route::resource('domains.concepts', ConceptController::class);
    Route::patch('concepts/{concept}/status', ConceptStatusController::class)->name('concepts.status.update');
    Route::get('archived-concepts', [ArchivedConceptController::class, 'index'])->name('archived-concepts.index');
    Route::patch('archived-concepts/{concept}/restore', [ArchivedConceptController::class, 'restore'])->name('archived-concepts.restore');
});


require __DIR__.'/auth.php';
