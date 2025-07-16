<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\KmsController;
use App\Http\Controllers\admin\AnakController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\admin\KmsV2Controller;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\OrangTuaController;
use App\Http\Controllers\admin\VitaminAController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ImunisasiController;
use App\Http\Controllers\admin\ObatCacingController;
use App\Http\Controllers\admin\general\FaqController;
use App\Http\Controllers\orangtua\ProfilAnakController;
use App\Http\Controllers\admin\general\ProfilController;
use App\Http\Controllers\admin\general\ContactInfoController;
use App\Http\Controllers\admin\general\JadwalImunisasiController;
use App\Http\Controllers\admin\LaporanController;
use App\Http\Controllers\orangtua\RiwayatController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home', [HomeController::class, 'submit'])->name('contact.submit');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.action');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route::get('/anak/{anak}/kms', [KmsController::class, 'show'])->name('kms.show');
// Route::post('/kms', [KmsController::class, 'store'])->name('kms.store');
// Route::put('/kms', [KmsController::class, 'update'])->name('kms.update');

// middeware('auth') is applied to all routes below
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profile.update');
    Route::put('/profil/change-password', [ProfilController::class, 'changePassword'])->name('profile.change-password');

    Route::middleware(['role:kader'])->group(function () {
        Route::get('/kms-digital', [KmsController::class, 'index'])->name('kms.index');
        Route::get('/kms-digital/v1/show/{encryptedId}', [KmsController::class, 'show'])->name('kms.show.v1');
        Route::post('/kms-digital/v1/store', [KmsController::class, 'store'])->name('kms.store.v1');
        Route::put('/kms-digital/v1/update/{encryptedId}', [KmsController::class, 'update'])->name('kms.update.v1');
        Route::get('/kms-digital/v1/preview/{encryptedId}', [KmsController::class, 'generatePDF'])->name('kms.pdf.v1');

        // KMS V2 Routes
        Route::get('/kms-digital/v2/show/{encryptedId}', [KmsV2Controller::class, 'show'])->name('kms.show.v2');
        Route::post('/kms-digital/v2/store', [KmsV2Controller::class, 'store'])->name('kms.store.v2');
        Route::put('/kms-digital/v2/update/{encryptedId}', [KmsV2Controller::class, 'update'])->name('kms.update.v2');
        Route::get('/kms-digital/v2/preview/{encryptedId}', [KmsV2Controller::class, 'generatePDF'])->name('kms.pdf.v2');

        // Imunisasi Routes
        Route::get('/imunisasi', [ImunisasiController::class, 'index'])->name('imunisasi.index');
        Route::get('/imunisasi/show', [ImunisasiController::class, 'show'])->name('imunisasi.show');
        Route::post('/imunisasi', [ImunisasiController::class, 'store'])->name('imunisasi.store');
        Route::get('/imunisasi/pdf/{anak}', [ImunisasiController::class, 'generatePDF'])->name('imunisasi.pdf');
        Route::post('/imunisasi/toggle', [ImunisasiController::class, 'toggleImunisasi']);
        Route::post('/imunisasi/batalkan-paraf', [ImunisasiController::class, 'batalkanParaf'])->name('imunisasi.batalkan-paraf');

        Route::get('/obat-cacing', [ObatCacingController::class, 'index'])->name('obat-cacing.index');
        Route::get('/vitamin-a', [VitaminAController::class, 'index'])->name('vitamin-a.index');
        Route::get('/vitamin-a/show', [VitaminAController::class, 'show'])->name('vitamin-a.show');
        Route::post('/toggle', [VitaminAController::class, 'toggle'])->name('vitamin-a.toggle');
        Route::post('/batalkan-paraf', [VitaminAController::class, 'batalkanParaf'])->name('vitamin-a.batalkan-paraf');
        Route::get('/vitamin-a/preview/{encryptedId}', [VitaminAController::class, 'exportPdfV2'])->name('vitamin-a.pdf');
    });

    Route::middleware(['role:kordinator'])->group(function () {
        Route::get('/orang-tua', [OrangTuaController::class, 'index'])->name('orang-tua.index');
        Route::post('/orang-tua', [OrangTuaController::class, 'store'])->name('orang-tua.store');
        Route::put('/orang-tua/{id}', [OrangTuaController::class, 'update'])->name('orang-tua.update');
        Route::delete('/orang-tua/{id}', [OrangTuaController::class, 'destroy'])->name('orang-tua.destroy');
        Route::get('/wilayah', [OrangTuaController::class, 'getWilayah']);

        Route::get('/anak', [AnakController::class, 'index'])->name('anak.index');
        Route::get('/anak/create', [AnakController::class, 'create'])->name('anak.create');
        Route::post('/anak', [AnakController::class, 'store'])->name('anak.store');
        Route::get('anak/{encryptedId}/edit', [AnakController::class, 'edit'])
            ->name('anak.edit');
        Route::put('anak/{encryptedId}', [AnakController::class, 'update'])
            ->name('anak.update');
        Route::delete('anak/{encryptedId}', [AnakController::class, 'destroy'])
            ->name('anak.destroy');

        Route::get('/jadwal-imunisasi', [JadwalImunisasiController::class, 'index'])->name('jadwal-imunisasi');
        Route::get('/jadwal-imunisasi/create', [JadwalImunisasiController::class, 'create'])->name('jadwal-imunisasi.create');
        Route::post('/jadwal-imunisasi', [JadwalImunisasiController::class, 'store'])->name('jadwal-imunisasi.store');
        Route::get('/jadwal-imunisasi/{encryptedId}', [JadwalImunisasiController::class, 'show'])->name('jadwal-imunisasi.show');
        Route::get('/jadwal-imunisasi/{encryptedId}/edit', [JadwalImunisasiController::class, 'edit'])->name('jadwal-imunisasi.edit');
        Route::put('/jadwal-imunisasi/{encryptedId}', [JadwalImunisasiController::class, 'update'])->name('jadwal-imunisasi.update');
        Route::delete('/jadwal-imunisasi/{encryptedId}', [JadwalImunisasiController::class, 'destroy'])->name('jadwal-imunisasi.destroy');

        Route::get('/faq', [FaqController::class, 'index'])->name('faq');
        Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');
        Route::put('/faq/{encryptedId}', [FaqController::class, 'update'])->name('faq.update');
        Route::delete('/faq/{encryptedId}', [FaqController::class, 'destroy'])->name('faq.destroy');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/export', [LaporanController::class, 'exportPdf'])->name('laporan.export');

        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::post('/users', [UsersController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware(['role:orang_tua'])->group(function () {

        Route::get('/my/profil-anak', [ProfilAnakController::class, 'index'])->name('my.profile-anak');
        Route::get('/riwayat-vitamin-a', [RiwayatController::class, 'riwayat_vitamin_a'])->name('riwayat.vitamin-a');
        Route::get('/riwayat-kms', [RiwayatController::class, 'riwayat_kms'])->name('riwayat.kms');
        Route::get('/riwayat-obat-cacing', [RiwayatController::class, 'riwayat_obat_cacing'])->name('riwayat.obat-cacing');


        Route::prefix('anak')->group(function () {
            Route::get('/{encryptedId}/kms1-pdf', [KmsController::class, 'generatePDF'])->name('anak.kms1-pdf');
            Route::get('/{encryptedId}/kms2-pdf', [KmsV2Controller::class, 'generatePDF'])->name('anak.kms2-pdf');
            Route::get('/{encryptedId}/vitamin-a-pdf', [VitaminAController::class, 'exportPdfV2'])->name('anak.vitamin-a-pdf');
            Route::get('/{encryptedId}/imunisasi-pdf', [ImunisasiController::class, 'generatePDF'])->name('anak.imunisasi-pdf');
        });
    });
});
