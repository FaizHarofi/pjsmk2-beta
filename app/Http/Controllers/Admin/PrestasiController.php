<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Prestasi;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $prestasis = Prestasi::with('jurusan')->latest()->paginate(15);
        return view('admin.prestasis.index', compact('prestasis'));
    }

    public function create()
    {
        $jurusans = Jurusan::active()->get();
        return view('admin.prestasis.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'nama_siswa' => 'nullable|string|max:255',
            'kelas' => 'nullable|string|max:50',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'tingkat' => 'required|in:sekolah,kota,provinsi,nasional,internasional',
            'tahun' => 'nullable|integer|min:2000|max:2100',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'prestasis', 800, 600);
        }

        Prestasi::create($validated);

        return redirect()->route('admin.prestasis.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function edit(Prestasi $prestasi)
    {
        $jurusans = Jurusan::active()->get();
        return view('admin.prestasis.edit', compact('prestasi', 'jurusans'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'nama_siswa' => 'nullable|string|max:255',
            'kelas' => 'nullable|string|max:50',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'tingkat' => 'required|in:sekolah,kota,provinsi,nasional,internasional',
            'tahun' => 'nullable|integer|min:2000|max:2100',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('gambar')) {
            $this->deleteImage($prestasi->gambar);
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'prestasis', 800, 600);
        }

        $prestasi->update($validated);

        return redirect()->route('admin.prestasis.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi)
    {
        $this->deleteImage($prestasi->gambar);
        $prestasi->delete();
        return redirect()->route('admin.prestasis.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
