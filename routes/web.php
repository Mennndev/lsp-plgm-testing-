<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Homecontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\TentangKamicontroller;
use App\Http\Controllers\VisiMisicontroller;
use App\Http\Controllers\KebijakanMutucontroller;
use App\Http\Controllers\StrukturOrganisasicontroller;
use App\Http\Controllers\Skemacontroller;
use App\Http\Controllers\admin\ProgramPelatihanController;
use App\Http\Controllers\admin\AdminBeritaController;
use App\Http\Controllers\Auth\PasswordResetController;


// Pendaftaran Routes
Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Tentang Kami Route
Route::get('/tentang-kami', [TentangKamicontroller::class, 'index'])->name('tentang-kami');

// Visi Misi Route
Route::get('/visi-misi', [VisiMisicontroller::class, 'index'])->name('visi-misi');

// Kebijakan Mutu Route
Route::get('/kebijakan-mutu', [KebijakanMutucontroller::class, 'index'])->name('kebijakan-mutu');

// Struktur Organisasi Route
Route::get('/struktur-organisasi', [StrukturOrganisasicontroller::class, 'index'])->name('struktur-organisasi');

//skema sertifikasi routes
Route::get('/skema-sertifikasi', [Skemacontroller::class, 'index'])->name('Skema.index');
Route::get('/skema/{program:slug}', [SkemaController::class, 'show'])
    ->name('Skema.show');

Route::get('/tempat-sertifikasi', function () {
    return view('tempat-sertifikasi');
});

// password reset routes
Route::get('/password/forgot', [PasswordResetController::class, 'request'])
    ->name('password.request');

Route::post('/password/forgot', [PasswordResetController::class, 'email'])
    ->name('password.email');

Route::get('/password/reset/{token}', [PasswordResetController::class, 'resetForm'])
    ->name('password.reset');

Route::post('/password/reset', [PasswordResetController::class, 'reset'])
    ->name('password.update');

// Home Route
Route::get('/', [Homecontroller::class, 'index'])->name('home');

// Artikel Routes
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::middleware(['auth'])->group(function () {

    // Dashboard utama user
    Route::get('/dashboard-user', [DashboardUserController::class, 'index'])
        ->name('dashboard.user');

    // FORM EDIT PROFIL USER
    Route::get('/dashboard-user/profile/edit', [ProfileController::class, 'edit'])
        ->name('ProfileUser.edit');

    // UPDATE PROFIL USER
    Route::patch('/dashboard-user/profile', [ProfileController::class, 'update'])
        ->name('ProfileUser.update');

    // UPDATE PASSWORD USER
    Route::patch('/dashboard-user/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('ProfileUser.password.update');

    // HAPUS AKUN
    Route::delete('/dashboard-user/profile', [ProfileController::class, 'destroy'])
        ->name('ProfileUser.destroy');

    //Route Khusus Tanda Tangan
    Route::patch('/dashboard-user/profile/signature', [ProfileController::class, 'updateSignature'])
        ->name('ProfileUser.signature.update');

});

//Admin Routes
Route::prefix('admin')
    ->middleware('auth')
    ->name('admin.')
    ->group(function () {
// Dashboard Admin Route
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // CRUD Program Pelatihan
        Route::resource('program-pelatihan', ProgramPelatihanController::class);
        // CRUD Asesi
        Route::resource('asesi', AsesiController::class);
        Route::resource('berita' , AdminBeritaController::class);
    });
