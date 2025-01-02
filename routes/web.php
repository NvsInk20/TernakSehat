<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PakarController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\SolusiController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\AturanPenyakitController;
use App\Http\Controllers\RiwayatDiagnosaController;

Route::get('/', function () {
    return view('welcome');
});


// Landing Page
Route::get('/LandingPage', function () {
    return view('pages.LandingPages.LandingPage');
})->name('landingpage');

// Diagnosa Guide Page
Route::get('/GuidePage-Diagnosa', function () {
    return view('pages.LandingPages.DiagnosaFitur');
})->name('DiagnosaFitur');

// Cetak Riwayat Guide Page
Route::get('/GuidePage-knowledge', function () {
    return view('pages.LandingPages.knowledgeFitur');
})->name('knowledgeFitur');

// Diagnosa Guide Page
Route::get('/GuidePage-Riwayat', function () {
    return view('pages.LandingPages.RiwayatFitur');
})->name('RiwayatFitur');

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
Route::get('/view/dokumen/{fileName}', [AuthController::class, 'viewDokumen'])->name('viewDokumen');
Route::put('/admin/approve-ahli-pakar/{kode_ahliPakar}', [PakarController::class, 'approveAhliPakar'])->name('admin.approveAhliPakar');
Route::put('/admin/pakar/{kode_ahliPakar}/toggle-status', [PakarController::class, 'toggleStatus'])->name('admin.toggleStatus');

// User Pages (with auth middleware)
Route::middleware(['auth'])->group(function () {

    Route::middleware(['auth', 'role:user'])->group(function () {
    // User Pages
    Route::view('/User/Dashboard', 'pages.UserPages.dashboard')->name('user.dashboard');
    Route::get('/User/penyakit', [AturanPenyakitController::class, 'indexUser'])->name('user.aturanPenyakit');
    Route::get('/user/riwayat-diagnosa', [RiwayatDiagnosaController::class, 'index'])->name('riwayatDiagnosa.index');
    Route::delete('/riwayat-diagnosa/{kode_riwayat}', [RiwayatDiagnosaController::class, 'destroy'])->name('riwayatDiagnosa.destroy');
    Route::get('/riwayat-diagnosa/cetak-semua-pdf', [RiwayatDiagnosaController::class, 'cetakSemuaPDFGabungan'])->name('riwayatDiagnosa.cetakSemuaPDFGabungan');
    
    Route::post('/lanjutDiagnosa', [DiagnosaController::class, 'lanjutDiagnosa'])->name('lanjutDiagnosa');
    Route::get('/getDiagnosa', [DiagnosaController::class, 'getDiagnosa'])->name('getDiagnosa');
    Route::post('/simpanHasil', [DiagnosaController::class, 'simpan'])->name('simpan');
    
    // Route Diagnosa
    Route::prefix('diagnosa')->group(function () {
        // Menampilkan pertanyaan pertama
        Route::get('/proses-diagnosa', [DiagnosaController::class, 'mulaiDiagnosa'])->name('diagnosaBaru.index');
        Route::get('/', [DiagnosaController::class, 'index'])->name('diagnosa.index');
        Route::view('/data-baru', 'pages.UserPages.diagnosa')->name('user.diagnosa');
        
        Route::post('/mulai', [DiagnosaController::class, 'mulaiDiagnosa'])->name('diagnosa.mulai');
        Route::get('/lanjut/{kode_sapi}', [DiagnosaController::class, 'lanjutDiagnosa'])->name('diagnosa.lanjut');
        Route::get('/options', [RiwayatDiagnosaController::class, 'indexDiagnosa'])->name('diagnosa.baru');
        
        // Menyimpan jawaban pengguna
        Route::post('/answer', [DiagnosaController::class, 'answerQuestion'])->name('diagnosa.answer');
        
        // Menampilkan hasil diagnosa
        Route::get('/result', [DiagnosaController::class, 'showResult'])->name('diagnosa.result');
        
        // Mereset sesi diagnosa
        Route::get('/reset', [DiagnosaController::class, 'resetDiagnosa'])->name('diagnosa.reset');
        Route::get('/hasil', [DiagnosaController::class, 'getDiagnosaHasil'])->name('diagnosa.hasil');
        Route::post('/simpan', [DiagnosaController::class, 'simpanHasil'])->name('diagnosa.simpanHasil');
    });
    
});    
    // Profile Routes
    Route::get('/profile/{kode_auth}', [AuthController::class, 'editProfile'])
    ->name('profile.settings')
    ->middleware('auth');

    Route::put('/profile/{kode_auth}/update', [AuthController::class, 'updateProfile'])
    ->name('profile.update')
    ->middleware('auth');

    Route::get('/chart-data', [RiwayatDiagnosaController::class, 'chartData'])->name('chart.data');
    Route::get('/chart-table', [RiwayatDiagnosaController::class, 'chartTable'])->name('chart.table');
    Route::get('/riwayat-diagnosa/{kode_riwayat}/pdf', [RiwayatDiagnosaController::class, 'cetakPDF'])->name('riwayatDiagnosa.pdf');
    Route::post('/hapus-semua', [RiwayatDiagnosaController::class, 'hapusSemua'])->name('riwayatDiagnosa.hapusSemua');
    
    // Admin Pages
    Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/Admin/Dashboard', 'pages.AdminPages.dashboard')->name('admin.dashboard');
    Route::view('/Admin/akunPengguna', 'pages.AdminPages.tabelUser')->name('admin.akunPengguna');
    Route::view('/Admin/penyakit', 'pages.AdminPages.tabelPenyakit')->name('admin.penyakit');
    Route::view('/Admin/Riwayat', 'pages.AdminPages.tabelRiwayat')->name('admin.riwayat');
    Route::view('/Admin/RulesPenyakit', 'pages.UserPages.tabelAturan')->name('admin.AturanPenyakit');

    Route::get('/admin/cetak-riwayat/{kode_user}', [RiwayatDiagnosaController::class, 'cetakSemuaPDFGabunganAdmin'])
    ->name('admin.cetak_riwayat');
    Route::get('/admin/users/riwayat', [RiwayatDiagnosaController::class, 'showRiwayatUsers'])->name('riwayatUser');
    Route::get('/admin/users/{kode_user}/riwayat', [RiwayatDiagnosaController::class, 'showRiwayat'])->name('riwayatDiagnosa.showRiwayat');

    Route::get('/admin/users', [PenggunaController::class, 'showUsers'])->name('admin.users')->middleware('auth');
    Route::delete('/admin/users/{kode_user}', [PenggunaController::class, 'deleteUser'])->name('admin.deleteUser')->middleware('auth');
    Route::get('/admin/users/edit/{role}/{kode}', [PenggunaController::class, 'editUser'])->name('admin.editUser');
    Route::put('/admin/users/update/{role}/{kode}', [PenggunaController::class, 'updateUser'])->name('admin.updateUser');
    
    
    Route::get('/admin/pakar', [PakarController::class, 'showPakars'])->name('admin.pakar')->middleware('auth');
    Route::delete('/admin/pakar/{kode_pakar}', [PakarController::class, 'deletePakar'])->name('admin.deletePakar')->middleware('auth');
    Route::get('/admin/pakar/edit/{role}/{kode}', [PakarController::class, 'editPakar'])->name('admin.editPakar');
    Route::put('/admin/pakar/update/{role}/{kode}', [PakarController::class, 'updatePakar'])->name('admin.updatePakar');

    // Penyakit Pages By :Admin
    Route::get('/Admin/penyakit', [PenyakitController::class, 'index'])->name('Admin.penyakit');
    Route::get('/dashboard', [PenyakitController::class, 'dashboard'])->name('dashboard');
    Route::get('/penyakit/add', [PenyakitController::class, 'create'])->name('penyakit.create');
    Route::post('/penyakit/add', [PenyakitController::class, 'store'])->name('penyakit.addItems');
    Route::get('/penyakit/{kode_penyakit}/edit', [PenyakitController::class, 'edit'])->name('penyakit.edit');
    Route::put('/penyakit/{kode_penyakit}', [PenyakitController::class, 'update'])->name('penyakit.update');
    Route::delete('/penyakit/{kode_penyakit}', [PenyakitController::class, 'destroy'])->name('penyakit.destroy');
   
    // Gejala Pages By : Admin 
    Route::get('/Admin/gejala', [GejalaController::class, 'index'])->name('Admin.gejala');
    Route::get('/dashboard', [GejalaController::class, 'dashboard'])->name('dashboard');
    Route::get('/gejala/add', [GejalaController::class, 'create'])->name('gejala.create');
    Route::post('/gejala/add', [GejalaController::class, 'store'])->name('gejala.addItems');
    Route::get('/gejala/{kode_gejala}/edit', [GejalaController::class, 'edit'])->name('gejala.edit');
    Route::put('/gejala/{kode_gejala}', [GejalaController::class, 'update'])->name('gejala.update');
    Route::delete('/gejala/{kode_gejala}', [GejalaController::class, 'destroy'])->name('gejala.destroy');
    
    // Solusi Pages By : Admin
    Route::get('/Admin/solusi', [SolusiController::class, 'index'])->name('Admin.solusi');
    Route::get('/dashboard', [SolusiController::class, 'dashboard'])->name('dashboard');
    Route::get('/solusi/add', [SolusiController::class, 'create'])->name('solusi.create');
    Route::post('/solusi/add', [SolusiController::class, 'store'])->name('solusi.addItems');
    Route::get('/solusi/{kode_solusi}/edit', [SolusiController::class, 'edit'])->name('solusi.edit');
    Route::put('/solusi/{kode_solusi}', [SolusiController::class, 'update'])->name('solusi.update');
    Route::delete('/solusi/{kode_solusi}', [SolusiController::class, 'destroy'])->name('solusi.destroy');
    
    // AturanPenyakit Pages By : Admin
    Route::get('/Admin/aturanPenyakit', [AturanPenyakitController::class, 'index'])->name('Admin.aturanPenyakit');
    Route::get('/dashboard', [AturanPenyakitController::class, 'dashboard'])->name('dashboard');
    Route::get('/aturanPenyakit/add', [AturanPenyakitController::class, 'create'])->name('aturanPenyakit.create');
    Route::post('/aturanPenyakit/add', [AturanPenyakitController::class, 'store'])->name('aturanPenyakit.addItems');
    Route::get('/aturanPenyakit/{kode_relasi}/edit', [AturanPenyakitController::class, 'edit'])->name('aturanPenyakit.edit');
    Route::put('/aturanPenyakit/{kode_relasi}', [AturanPenyakitController::class, 'update'])->name('aturanPenyakit.update');
    Route::delete('/aturanPenyakit/{kode_relasi}', [AturanPenyakitController::class, 'destroy'])->name('aturanPenyakit.destroy');

    });


    // Pakar Pages
    Route::middleware(['auth', 'role:ahli pakar'])->group(function () {
    Route::view('/ahli_pakar/Dashboard', 'pages.PakarPages.dashboard')->name('pakar.dashboard');
    Route::view('/ahli_pakar/penyakit', 'pages.PakarPages.tabelPenyakit')->name('pakar.penyakit');
    Route::view('/ahli_pakar/Riwayat', 'pages.PakarPages.tabelRiwayat')->name('pakar.riwayat');
    Route::view('/ahli_pakar/RulesPenyakit', 'pages.UserPages.tabelAturan')->name('pakar.AturanPenyakit');
    
    // Penyakit Pages By :Pakar
    Route::get('/ahli_pakar/penyakit', [PenyakitController::class, 'indexPakar'])->name('Pakar.penyakit');
    Route::get('/dashboard', [PenyakitController::class, 'dashboard'])->name('dashboard');
    Route::get('/ahli_pakar/penyakit/add', [PenyakitController::class, 'createByPakar'])->name('penyakitPakar.create');
    Route::post('/ahli_pakar/penyakit/add', [PenyakitController::class, 'storeByPakar'])->name('penyakitPakar.addItems');
    Route::get('/ahli_pakar/penyakit/{kode_penyakit}/edit', [PenyakitController::class, 'editByPakar'])->name('penyakitPakar.edit');
    Route::put('/ahli_pakar/penyakit/{kode_penyakit}', [PenyakitController::class, 'updateByPakar'])->name('penyakitPakar.update');
    Route::delete('/ahli_pakar/penyakit/{kode_penyakit}', [PenyakitController::class, 'destroyByPakar'])->name('penyakitPakar.destroy');
    
    // Gejala Pages By : Pakar 
    Route::get('/ahli_pakar/gejala', [GejalaController::class, 'indexByPakar'])->name('Pakar.gejala');
    Route::get('/dashboard', [GejalaController::class, 'dashboard'])->name('dashboard');
    Route::get('/ahli_pakar/gejala/add', [GejalaController::class, 'createByPakar'])->name('gejalaPakar.create');
    Route::post('/ahli_pakar/gejala/add', [GejalaController::class, 'storeByPakar'])->name('gejalaPakar.addItems');
    Route::get('/ahli_pakar/gejala/{kode_gejala}/edit', [GejalaController::class, 'editByPakar'])->name('gejalaPakar.edit');
    Route::put('/ahli_pakar/gejala/{kode_gejala}', [GejalaController::class, 'updateByPakar'])->name('gejalaPakar.update');
    Route::delete('/ahli_pakar/gejala/{kode_gejala}', [GejalaController::class, 'destroyByPakar'])->name('gejalaPakar.destroy');
    
    // Solusi Pages By : Pakar
    Route::get('/ahli_pakar/solusi', [SolusiController::class, 'indexByPakar'])->name('Pakar.solusi');
    Route::get('/dashboard', [SolusiController::class, 'dashboard'])->name('dashboard');
    Route::get('/ahli_pakar/solusi/add', [SolusiController::class, 'createByPakar'])->name('solusiPakar.create');
    Route::post('/ahli_pakar/solusi/add', [SolusiController::class, 'storeByPakar'])->name('solusiPakar.addItems');
    Route::get('/ahli_pakar/solusi/{kode_solusi}/edit', [SolusiController::class, 'editByPakar'])->name('solusiPakar.edit');
    Route::put('/ahli_pakar/solusi/{kode_solusi}', [SolusiController::class, 'updateByPakar'])->name('solusiPakar.update');
    Route::delete('/ahli_pakar/solusi/{kode_solusi}', [SolusiController::class, 'destroyByPakar'])->name('solusiPakar.destroy');
    
    // AturanPenyakit Pages By : Pakar
    Route::get('/ahli_pakar/aturanPenyakit', [AturanPenyakitController::class, 'indexByPakar'])->name('Pakar.aturanPenyakit');
    Route::get('/dashboard', [AturanPenyakitController::class, 'dashboard'])->name('dashboard');
    Route::get('/ahli_pakar/aturanPenyakit/add', [AturanPenyakitController::class, 'createByPakar'])->name('aturanPenyakitPakar.create');
    Route::post('/ahli_pakar/aturanPenyakit/add', [AturanPenyakitController::class, 'storeByPakar'])->name('aturanPenyakitPakar.addItems');
    Route::get('/ahli_pakar/aturanPenyakit/{kode_relasi}/edit', [AturanPenyakitController::class, 'editByPakar'])->name('aturanPenyakitPakar.edit');
    Route::put('/ahli_pakar/aturanPenyakit/{kode_relasi}', [AturanPenyakitController::class, 'updateByPakar'])->name('aturanPenyakitPakar.update');
    Route::delete('/ahli_pakar/aturanPenyakit/{kode_relasi}', [AturanPenyakitController::class, 'destroyByPakar'])->name('aturanPenyakitPakar.destroy');
    });
});
