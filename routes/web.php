<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransportadoraController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource('/dashboard', TransportadoraController::class)->middleware(['auth', 'verified'])->names([
    'index' => 'dashboard',
    'create' => 'transportadora.create',
    'store' => 'transportadora.store',
    'destroy' => 'transportadora.destroy',
    'edit' => 'transportadora.edit',
    'update' => 'transportadora.update',
]);
Route::post('/transportadoras/export', [TransportadoraController::class, 'export'])->middleware(['auth', 'verified'])->name('transportadora.export');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
