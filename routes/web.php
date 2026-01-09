<?php

use App\Http\Resources\PuppyResource;
use App\Models\Puppy;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\PuppyController;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'puppies' => PuppyResource::collection(Puppy::all()->load(['user', 'likedBy'])),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::patch('puppies/puppy/{puppy}/like', [PuppyController::class, 'like'])->name('puppies.like');
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
