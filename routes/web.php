<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\TownshipController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware(['auth', 'verified']);


Route::post('/user/register', [UserController::class, 'register'])->name('user.register');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //for users
    Route::get('/user', [UserController::class, 'index'])->name('user');

    //for patients
    Route::get('/patient', [PatientController::class, 'index'])->name('patient');

    //for districts
    Route::get('/basic-data/district', [DistrictController::class, 'index'])->name('district');
    Route::post('/basic-data/district', [DistrictController::class, 'store'])->name('district.create');
  
    //for regions
    Route::get('/basic-data/region', [RegionController::class, 'index'])->name('region');

    //for townships
    Route::get('/basic-data/township', [TownshipController::class, 'index'])->name('township');

    //for user profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
