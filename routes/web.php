<?php

use App\Http\Controllers\Public\ArtikelController as PublicArtikelController;
use App\Http\Controllers\Public\GaleriController as PublicGaleriController;
use App\Http\Controllers\Public\GuruController as PublicGuruController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\JurusanController as PublicJurusanController;
use App\Http\Controllers\Public\KontakController as PublicKontakController;
use App\Http\Controllers\Public\PengumumanController as PublicPengumumanController;
use App\Http\Controllers\Public\ProfilController;
use App\Http\Controllers\Public\VideoController as PublicVideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/sejarah', [ProfilController::class, 'sejarah'])->name('sejarah');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/fasilitas', [ProfilController::class, 'fasilitas'])->name('fasilitas');
});

Route::get('/jurusans', [PublicJurusanController::class, 'index'])->name('jurusans.index');
Route::get('/jurusans/{jurusan:slug}', [PublicJurusanController::class, 'show'])->name('jurusans.show');

Route::get('/artikels', [PublicArtikelController::class, 'index'])->name('artikels.index');
Route::get('/artikels/{artikel:slug}', [PublicArtikelController::class, 'show'])->name('artikels.show');

Route::get('/videos', [PublicVideoController::class, 'index'])->name('videos.index');

Route::get('/galeris', [PublicGaleriController::class, 'index'])->name('galeris.index');
Route::get('/galeris/{galeri:slug}', [PublicGaleriController::class, 'show'])->name('galeris.show');

Route::get('/gurus', [PublicGuruController::class, 'index'])->name('gurus.index');

Route::get('/pengumuman', [PublicPengumumanController::class, 'index'])->name('pengumuman.index');

Route::get('/kontak', [PublicKontakController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [PublicKontakController::class, 'store'])->name('kontak.store');
