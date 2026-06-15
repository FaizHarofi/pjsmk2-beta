<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $query = Artikel::published()->with('kategori', 'user');

        if ($request->filled('kategori')) {
            $query->where('kategori_artikel_id', $request->kategori);
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $artikels = $query->latest('published_at')->paginate(9);
        $kategoris = KategoriArtikel::active()->get();
        $populer = Artikel::published()->orderBy('views', 'desc')->take(5)->get();
        $tags = Tag::all();

        return view('public.artikels.index', compact('artikels', 'kategoris', 'populer', 'tags'));
    }

    public function show(Artikel $artikel)
    {
        abort_unless($artikel->is_published, 404);
        $artikel->increment('views');
        $artikel->load('kategori', 'user', 'tags');

        $related = Artikel::published()
            ->where('kategori_artikel_id', $artikel->kategori_artikel_id)
            ->where('id', '!=', $artikel->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $populer = Artikel::published()->orderBy('views', 'desc')->take(5)->get();
        $kategoris = KategoriArtikel::active()->get();

        return view('public.artikels.show', compact('artikel', 'related', 'populer', 'kategoris'));
    }
}
