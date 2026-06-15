<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\KontakPesan;
use App\Models\Video;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalArtikel' => Artikel::count(),
            'draftArtikel' => Artikel::where('is_published', false)->count(),
            'totalVideo' => Video::count(),
            'pesanBaru' => KontakPesan::where('is_read', false)->count(),
            'totalGuru' => Guru::count(),
            'totalJurusan' => Jurusan::count(),
            'recentArtikels' => Artikel::with('kategori')->latest()->take(5)->get(),
            'recentPesan' => KontakPesan::latest()->take(5)->get(),
        ]);
    }
}
