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
        'canRegister' => Route::has('register')
    ]);
})->middleware(['auth', 'verified']);


Route::post('/user/register', [UserController::class, 'register'])->name('user.register');
Route::post('/user/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');
Route::delete('/user/destroy/{id}',[UserController::class,'destroy'])->name('user.destroy');

Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //for users
    Route::get('/user', [UserController::class, 'index'])->name('user');

    //for patients
    Route::get('/patient', [PatientController::class, 'index'])->name('patient');
    Route::post('/patient', [PatientController::class, 'store'])->name('patient.create');
    Route::get('/patient/edit/{id}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::put('/patient/update/{id}', [PatientController::class, 'update'])->name('patient.update');
    Route::delete('/patient/destroy/{id}',[PatientController::class,'destroy'])->name('patient.destroy');

    //for districts
    Route::get('/basic-data/district', [DistrictController::class, 'index'])->name('district');
    Route::get('/basic-data/district/edit/{id}', [DistrictController::class, 'edit'])->name('district.edit');
    Route::put('/basic-data/district/update/{id}', [DistrictController::class, 'update'])->name('district.update');
    Route::post('/basic-data/district', [DistrictController::class, 'store'])->name('district.create');
    Route::delete('/basic-data/district/destroy/{id}',[DistrictController::class,'destroy'])->name('district.destroy');

     //for regions
    Route::get('/basic-data/region', [RegionController::class, 'index'])->name('region');
    Route::get('/basic-data/region/edit/{id}', [RegionController::class, 'edit'])->name('region.edit');
    Route::put('/basic-data/region/update/{id}', [RegionController::class, 'update'])->name('region.update');
    Route::post('/basic-data/region', [RegionController::class, 'store'])->name('region.create');
    Route::delete('/basic-data/region/destroy/{id}',[RegionController::class,'destroy'])->name('region.destroy');

    //for townships
    Route::get('/basic-data/township', [TownshipController::class, 'index'])->name('township');
    Route::get('/basic-data/township/edit/{id}', [TownshipController::class, 'edit'])->name('township.edit');
    Route::put('/basic-data/township/update/{id}', [TownshipController::class, 'update'])->name('township.update');
    Route::post('/basic-data/township', [TownshipController::class, 'store'])->name('township.create');
    Route::delete('/basic-data/township/destroy/{id}',[TownshipController::class,'destroy'])->name('township.destroy');
    
    //for user profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //for export user
    Route::get('/export-users',[UserController::class,'exportUsers'])->name('export-users');

});

require __DIR__.'/auth.php';
