<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $jurusans = Jurusan::ordered()->paginate(15);
        return view('admin.jurusans.index', compact('jurusans'));
    }

    public function create()
    {
        return view('admin.jurusans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:100',
            'warna' => 'nullable|string|max:7',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'jurusans', 800, 600);
        }
        Jurusan::create($validated);
        return redirect()->route('admin.jurusans.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusans.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:100',
            'warna' => 'nullable|string|max:7',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('gambar')) {
            $this->deleteImage($jurusan->gambar);
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'jurusans', 800, 600);
        }
        $jurusan->update($validated);
        return redirect()->route('admin.jurusans.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan)
    {
        $this->deleteImage($jurusan->gambar);
        $jurusan->delete();
        return redirect()->route('admin.jurusans.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}