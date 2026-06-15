<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AlbumGaleri;
use App\Models\Artikel;
use App\Models\Ekstrakurikuler;
use App\Models\Jurusan;
use App\Models\LinkTerkait;
use App\Models\Pengumuman;
use App\Models\Prestasi;
use App\Models\Sekolah;
use App\Models\Slider;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        return view('public.home', [
            'sliders' => Slider::active()->ordered()->get(),
            'sekolah' => Sekolah::first(),
            'jurusans' => Jurusan::active()->ordered()->get(),
            'artikels' => Artikel::published()->with('kategori')->latest()->take(6)->get(),
            'videos' => Video::published()->latest()->take(4)->get(),
            'prestasis' => Prestasi::published()->orderBy('tahun', 'desc')->take(6)->get(),
            'albums' => AlbumGaleri::published()->with('fotos')->latest()->take(4)->get(),
            'ekskuls' => Ekstrakurikuler::active()->ordered()->get(),
            'pengumumen' => Pengumuman::published()->urgent()->notExpired()->get(),
            'linkTerkaits' => LinkTerkait::active()->ordered()->get(),
        ]);
    }
}
