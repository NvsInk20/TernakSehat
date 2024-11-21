<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\SolusiController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\AturanPenyakitController;

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
    // User Pages
    Route::view('/User/Dashboard', 'pages.UserPages.dashboard')->name('user.dashboard');
    Route::view('/User/Diagnosa', 'pages.UserPages.diagnosa')->name('user.diagnosa');
    // Route::view('/User/Diagnosa', 'pages.UserPages.diagnosa')->name('diagnosa');
    Route::view('/User/Riwayat', 'pages.UserPages.riwayat')->name('riwayat');

    // Profile Routes
    Route::get('/profile', [AuthController::class, 'editProfile'])->name('profile.settings');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Admin Pages
    Route::view('/Admin/Dashboard', 'pages.AdminPages.dashboard')->name('admin.dashboard');
    Route::view('/Admin/akunPengguna', 'pages.AdminPages.tabelUser')->name('admin.akunPengguna');
    Route::view('/Admin/penyakit', 'pages.AdminPages.tabelPenyakit')->name('admin.penyakit');
    Route::view('/Admin/Riwayat', 'pages.AdminPages.tabelRiwayat')->name('admin.riwayat');
    
    // Penyakit Pages 
    Route::get('/Admin/penyakit', [PenyakitController::class, 'index'])->name('Admin.penyakit');
    Route::get('/dashboard', [PenyakitController::class, 'dashboard'])->name('dashboard');
    Route::get('/penyakit/add', [PenyakitController::class, 'create'])->name('penyakit.create');
    Route::post('/penyakit/add', [PenyakitController::class, 'store'])->name('penyakit.addItems');
    Route::get('/penyakit/{kode_penyakit}/edit', [PenyakitController::class, 'edit'])->name('penyakit.edit');
    Route::put('/penyakit/{kode_penyakit}', [PenyakitController::class, 'update'])->name('penyakit.update');
    Route::delete('/penyakit/{kode_penyakit}', [PenyakitController::class, 'destroy'])->name('penyakit.destroy');
   
    // Gejala Pages 
    Route::get('/Admin/gejala', [GejalaController::class, 'index'])->name('Admin.gejala');
    Route::get('/dashboard', [GejalaController::class, 'dashboard'])->name('dashboard');
    Route::get('/gejala/add', [GejalaController::class, 'create'])->name('gejala.create');
    Route::post('/gejala/add', [GejalaController::class, 'store'])->name('gejala.addItems');
    Route::get('/gejala/{kode_gejala}/edit', [GejalaController::class, 'edit'])->name('gejala.edit');
    Route::put('/gejala/{kode_gejala}', [GejalaController::class, 'update'])->name('gejala.update');
    Route::delete('/gejala/{kode_gejala}', [GejalaController::class, 'destroy'])->name('gejala.destroy');
    
    // Solusi Pages 
    Route::get('/Admin/solusi', [SolusiController::class, 'index'])->name('Admin.solusi');
    Route::get('/dashboard', [SolusiController::class, 'dashboard'])->name('dashboard');
    Route::get('/solusi/add', [SolusiController::class, 'create'])->name('solusi.create');
    Route::post('/solusi/add', [SolusiController::class, 'store'])->name('solusi.addItems');
    Route::get('/solusi/{kode_solusi}/edit', [SolusiController::class, 'edit'])->name('solusi.edit');
    Route::put('/solusi/{kode_solusi}', [SolusiController::class, 'update'])->name('solusi.update');
    Route::delete('/solusi/{kode_solusi}', [SolusiController::class, 'destroy'])->name('solusi.destroy');
    
    // AturanPenyakit Pages 
    Route::get('/Admin/aturanPenyakit', [AturanPenyakitController::class, 'index'])->name('Admin.aturanPenyakit');
    Route::get('/dashboard', [AturanPenyakitController::class, 'dashboard'])->name('dashboard');
    Route::get('/aturanPenyakit/add', [AturanPenyakitController::class, 'create'])->name('aturanPenyakit.create');
    Route::post('/aturanPenyakit/add', [AturanPenyakitController::class, 'store'])->name('aturanPenyakit.addItems');
    Route::get('/aturanPenyakit/{kode_relasi}/edit', [AturanPenyakitController::class, 'edit'])->name('aturanPenyakit.edit');
    Route::put('/aturanPenyakit/{kode_relasi}', [AturanPenyakitController::class, 'update'])->name('aturanPenyakit.update');
    Route::delete('/aturanPenyakit/{kode_relasi}', [AturanPenyakitController::class, 'destroy'])->name('aturanPenyakit.destroy');


   // Route Diagnosa
    // Route Diagnosa
    Route::prefix('diagnosa')->group(function () {
        // Menampilkan pertanyaan pertama
        Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa.index');
        
        // Menyimpan jawaban pengguna
        Route::post('/diagnosa/answer', [DiagnosaController::class, 'answerQuestion'])->name('diagnosa.answer');
        
        // Menampilkan hasil diagnosa
        Route::get('/diagnosa/result', [DiagnosaController::class, 'showResult'])->name('diagnosa.result');
        
        // Mereset sesi diagnosa
        Route::get('/diagnosa/reset', [DiagnosaController::class, 'resetDiagnosa'])->name('diagnosa.reset');
    });

});
