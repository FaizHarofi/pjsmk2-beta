<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AlbumGaleri;

class GaleriController extends Controller
{
    public function index()
    {
        $albums = AlbumGaleri::published()->withCount('fotos')->latest()->paginate(12);
        return view('public.galeris.index', compact('albums'));
    }

    public function show(AlbumGaleri $galeri)
    {
        abort_unless($galeri->is_published, 404);
        $galeri->load('fotos');
        return view('public.galeris.show', compact('galeri'));
    }
}
