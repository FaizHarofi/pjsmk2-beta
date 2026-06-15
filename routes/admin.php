<?php

use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EkstrakurikulerController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KetuaJurusanController;
use App\Http\Controllers\Admin\KontakController;
use App\Http\Controllers\Admin\LinkTerkaitController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PrestasiController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('artikels', ArtikelController::class);
    Route::post('artikels/{artikel}/toggle-publish', [ArtikelController::class, 'togglePublish'])->name('artikels.toggle-publish');
    Route::post('artikels/{artikel}/toggle-featured', [ArtikelController::class, 'toggleFeatured'])->name('artikels.toggle-featured');
    Route::post('artikels/bulk-destroy', [ArtikelController::class, 'bulkDestroy'])->name('artikels.bulk-destroy');

    Route::resource('jurusans', JurusanController::class);

    Route::resource('ketua-jurusans', KetuaJurusanController::class);

    Route::resource('videos', VideoController::class);
    Route::post('videos/{video}/toggle-publish', [VideoController::class, 'togglePublish'])->name('videos.toggle-publish');

    Route::resource('galeris', GaleriController::class);
    Route::post('galeris/{galeri}/upload', [GaleriController::class, 'uploadFoto'])->name('galeris.upload');
    Route::delete('galeris/foto/{foto}', [GaleriController::class, 'deleteFoto'])->name('galeris.delete-foto');

    Route::resource('gurus', GuruController::class);

    Route::resource('prestasis', PrestasiController::class);

    Route::resource('pengumumen', PengumumanController::class);
    Route::post('pengumumen/{pengumuman}/toggle-urgent', [PengumumanController::class, 'toggleUrgent'])->name('pengumumen.toggle-urgent');

    Route::resource('ekstrakurikulers', EkstrakurikulerController::class);

    Route::resource('fasilitas', FasilitasController::class);

    Route::resource('sliders', SliderController::class);

    Route::get('sekolah/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
    Route::put('sekolah', [SekolahController::class, 'update'])->name('sekolah.update');

    Route::resource('link-terkaits', LinkTerkaitController::class);

    Route::get('kontak', [KontakController::class, 'index'])->name('kontak.index');
    Route::get('kontak/unread-count', [KontakController::class, 'unreadCount'])->name('kontak.unread-count');
    Route::get('kontak/{kontak}', [KontakController::class, 'show'])->name('kontak.show');
    Route::post('kontak/{kontak}/read', [KontakController::class, 'markRead'])->name('kontak.read');
    Route::delete('kontak/{kontak}', [KontakController::class, 'destroy'])->name('kontak.destroy');

    Route::post('upload/image', [UploadController::class, 'image'])->name('upload.image');

    Route::resource('users', UserController::class)->middleware('role:superadmin');
});
