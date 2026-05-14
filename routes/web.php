<?php

use App\Http\Controllers\ConceptController;
use App\Http\Controllers\ConceptStatusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\GeneratedQuestionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('domains', DomainController::class);
    Route::resource('domains.concepts', ConceptController::class);
    Route::patch('concepts/{concept}/status', ConceptStatusController::class)->name('concepts.status.update');
    Route::post('concepts/{concept}/generated-questions', [GeneratedQuestionController::class, 'store'])
        ->name('concepts.generated-questions.store');
    Route::delete('generated-questions/{generatedQuestion}', [GeneratedQuestionController::class, 'destroy'])
        ->name('generated-questions.destroy');
});


require __DIR__.'/auth.php';
