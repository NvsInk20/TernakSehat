<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Landing Page
Route::get('/LandingPage', function () {
    return view('pages.LandingPages.LandingPage');
})->name('landingpage');

// Registrasi Akun Pengguna ahli pakar
Route::get('/RegistrasiAhliPakar', function () {
    return view('pages.LandingPages.RegistrasiAhliPakar.index');
})->name('registrasiAhliPakar');

// Registrasi Akun Pengguna user (peternak)
Route::get('/RegistrasiUser', function () {
    return view('pages.LandingPages.RegistrasiUser.index');
})->name('registrasiUser');

// Auth Routes
Route::get('/Register', [AuthController::class, 'indexRegister'])->name('Register');
Route::post('/Register', [AuthController::class, 'Register']);
Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Pages (with auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::view('/User/Dashboard', 'pages.UserPages.dashboard')->name('dashboard');
    Route::view('/User/Diagnosa', 'pages.UserPages.diagnosa')->name('diagnosa');
    Route::view('/User/Riwayat', 'pages.UserPages.riwayat')->name('riwayat');

    // Profile Routes
    Route::get('/settings/edit', [AuthController::class, 'editProfile'])->name('profile.settings');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
});
