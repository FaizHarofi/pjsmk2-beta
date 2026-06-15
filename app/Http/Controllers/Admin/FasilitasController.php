<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $fasilitas = Fasilitas::ordered()->paginate(15);
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('admin.fasilitas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'fasilitas', 1200, 800);
        }

        Fasilitas::create($validated);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Fasilitas $fasilitas)
    {
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    public function update(Request $request, Fasilitas $fasilitas)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('gambar')) {
            $this->deleteImage($fasilitas->gambar);
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'fasilitas', 1200, 800);
        }

        $fasilitas->update($validated);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Fasilitas $fasilitas)
    {
        $this->deleteImage($fasilitas->gambar);
        $fasilitas->delete();
        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
