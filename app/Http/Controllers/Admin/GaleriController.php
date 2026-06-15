<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlbumGaleri;
use App\Models\Galeri;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $albums = AlbumGaleri::withCount('fotos')->latest()->paginate(15);
        return view('admin.galeris.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.galeris.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|max:4096',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('cover')) {
            $validated['cover'] = $this->uploadImage($request->file('cover'), 'galeris', 1920);
        }

        $album = AlbumGaleri::create($validated);

        return redirect()->route('admin.galeris.show', $album)->with('success', 'Album berhasil ditambahkan.');
    }

    public function show(AlbumGaleri $galeri)
    {
        $galeri->load('fotos');
        return view('admin.galeris.show', compact('galeri'));
    }

    public function edit(AlbumGaleri $galeri)
    {
        return view('admin.galeris.edit', compact('galeri'));
    }

    public function update(Request $request, AlbumGaleri $galeri)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|max:4096',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('cover')) {
            $this->deleteImage($galeri->cover);
            $validated['cover'] = $this->uploadImage($request->file('cover'), 'galeris', 1920);
        }

        $galeri->update($validated);

        return redirect()->route('admin.galeris.index')->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(AlbumGaleri $galeri)
    {
        foreach ($galeri->fotos as $foto) {
            $this->deleteImage($foto->file_path);
        }
        $this->deleteImage($galeri->cover);
        $galeri->delete();
        return redirect()->route('admin.galeris.index')->with('success', 'Album berhasil dihapus.');
    }

    public function uploadFoto(Request $request, AlbumGaleri $galeri)
    {
        $request->validate([
            'fotos.*' => 'image|max:4096',
        ]);

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $file) {
                $path = $this->uploadImage($file, 'galeris/' . $galeri->id, 1920);
                Galeri::create([
                    'album_galeri_id' => $galeri->id,
                    'file_path' => $path,
                    'file_type' => 'image',
                ]);
            }
        }

        return back()->with('success', 'Foto berhasil diupload.');
    }

    public function deleteFoto(Galeri $foto)
    {
        $this->deleteImage($foto->file_path);
        $foto->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
