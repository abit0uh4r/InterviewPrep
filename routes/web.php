<?php

use App\Http\Controllers\ArchivedConceptController;
use App\Http\Controllers\ConceptController;
use App\Http\Controllers\ConceptLibraryController;
use App\Http\Controllers\ConceptStatusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\GeneratedQuestionController;
use App\Http\Controllers\GeneratedQuestionLibraryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/concepts', ConceptLibraryController::class)->name('concepts.index');
    Route::get('/generated-questions', GeneratedQuestionLibraryController::class)->name('generated-questions.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('domains', DomainController::class);
    Route::resource('domains.concepts', ConceptController::class);
    Route::patch('concepts/{concept}/status', ConceptStatusController::class)->name('concepts.status.update');

    Route::get('archived-concepts', [ArchivedConceptController::class, 'index'])->name('archived-concepts.index');
    Route::patch('archived-concepts/{concept}/restore', [ArchivedConceptController::class, 'restore'])->name('archived-concepts.restore');

    Route::post('concepts/{concept}/generated-questions', [GeneratedQuestionController::class, 'store'])
        ->name('concepts.generated-questions.store');
    Route::delete('generated-questions/{generatedQuestion}', [GeneratedQuestionController::class, 'destroy'])
        ->name('generated-questions.destroy');
});


require __DIR__.'/auth.php';
