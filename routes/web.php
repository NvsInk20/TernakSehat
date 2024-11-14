<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/LandingPage', function () {
    return view('pages.LandingPages.LandingPage');
})->name('landingpage');

// Register routes
Route::get('/Register', [AuthController::class, 'indexRegister'])->name('Register');
Route::post('/Register', [AuthController::class, 'register']);

// Login routes
Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard route
    Route::get('/User/Dashboard', function () {
        return view('pages.UserPages.dashboard');
    })->name('dashboard');

    // Diagnosa route
    Route::get('/User/Diagnosa', function () {
        return view('pages.UserPages.diagnosa');
    })->name('diagnosa');

    // Riwayat route
    Route::get('/User/Riwayat', function () {
        return view('pages.UserPages.riwayat');
    })->name('riwayat');

    // Edit profile route
Route::get('/settings/{id}/edit', [AuthController::class, 'editProfile'])->name('profile.settings');

// Update profile route (using PUT method)
Route::put('/settings/{id}', [AuthController::class, 'updateProfile'])->name('profile.update');


});
