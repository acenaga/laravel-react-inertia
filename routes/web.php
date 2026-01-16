<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PuppyController;

Route::get('/', [PuppyController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::patch('puppies/puppy/{puppy}/like', [PuppyController::class, 'like'])
        ->name('puppies.like');
    Route::post('puppies/puppy', [PuppyController::class, 'store'])
        ->name('puppies.store');
    Route::delete('puppies/puppy/{puppy}', [PuppyController::class, 'destroy'])
        ->name('puppies.destroy');
    Route::put('puppies/puppy/{puppy}', [PuppyController::class, 'update'])
        ->name('puppies.update');

    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
