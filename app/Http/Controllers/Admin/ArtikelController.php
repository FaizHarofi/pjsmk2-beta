<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use App\Models\Tag;
use App\Traits\AjaxResponse;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    use HasImageUpload, AjaxResponse;

    public function index(Request $request)
    {
        $query = Artikel::with(['kategori', 'user']);

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_artikel_id', $request->kategori);
        }
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        $artikels = $query->latest()->paginate(15);
        $kategoris = KategoriArtikel::all();

        return view('admin.artikels.index', compact('artikels', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriArtikel::all();
        return view('admin.artikels.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_artikel_id' => 'nullable|exists:kategori_artikels,id',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['is_published'] && !$request->input('published_at')) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'artikels', 1200, 630);
        }

        $artikel = Artikel::create($validated);

        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            foreach ($tagNames as $name) {
                $tag = Tag::firstOrCreate(['nama' => $name], ['slug' => \Illuminate\Support\Str::slug($name)]);
                $tagIds[] = $tag->id;
            }
            $artikel->tags()->sync($tagIds);
        }

        return redirect()->route('admin.artikels.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Artikel $artikel)
    {
        $kategoris = KategoriArtikel::all();
        return view('admin.artikels.edit', compact('artikel', 'kategoris'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_artikel_id' => 'nullable|exists:kategori_artikels,id',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['is_published'] && !$artikel->published_at) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('gambar')) {
            $this->deleteImage($artikel->gambar);
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'artikels', 1200, 630);
        }

        $artikel->update($validated);

        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            foreach ($tagNames as $name) {
                $tag = Tag::firstOrCreate(['nama' => $name], ['slug' => \Illuminate\Support\Str::slug($name)]);
                $tagIds[] = $tag->id;
            }
            $artikel->tags()->sync($tagIds);
        }

        return redirect()->route('admin.artikels.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Artikel $artikel)
    {
        $this->deleteImage($artikel->gambar);
        $artikel->delete();
        return redirect()->route('admin.artikels.index')->with('success', 'Artikel berhasil dihapus.');
    }

    public function togglePublish(Request $request, Artikel $artikel)
    {
        $artikel->update([
            'is_published' => !$artikel->is_published,
            'published_at' => !$artikel->is_published ? now() : $artikel->published_at,
        ]);

        if ($this->wantsJson($request)) {
            return $this->jsonSuccess('Status publish diperbarui.', [
                'is_published' => $artikel->is_published,
            ]);
        }
        return back()->with('success', 'Status artikel diperbarui.');
    }

    public function toggleFeatured(Request $request, Artikel $artikel)
    {
        $artikel->update(['is_featured' => !$artikel->is_featured]);

        if ($this->wantsJson($request)) {
            return $this->jsonSuccess('Status featured diperbarui.', [
                'is_featured' => $artikel->is_featured,
            ]);
        }
        return back()->with('success', 'Status featured diperbarui.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = (array) $request->input('ids', []);
        $artikels = Artikel::whereIn('id', $ids)->get();
        foreach ($artikels as $a) {
            $this->deleteImage($a->gambar);
            $a->delete();
        }
        return $this->jsonSuccess(count($artikels) . ' artikel dihapus.');
    }
}
