<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $ekskuls = Ekstrakurikuler::ordered()->paginate(15);
        return view('admin.ekstrakurikulers.index', compact('ekskuls'));
    }

    public function create()
    {
        return view('admin.ekstrakurikulers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:100',
            'pembina' => 'nullable|string|max:255',
            'hari' => 'nullable|string|max:100',
            'jam' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'ekstrakurikuler', 800, 600);
        }

        Ekstrakurikuler::create($validated);

        return redirect()->route('admin.ekstrakurikulers.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    public function edit(Ekstrakurikuler $ekstrakurikuler)
    {
        return view('admin.ekstrakurikulers.edit', compact('ekstrakurikuler'));
    }

    public function update(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'icon' => 'nullable|string|max:100',
            'pembina' => 'nullable|string|max:255',
            'hari' => 'nullable|string|max:100',
            'jam' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('gambar')) {
            $this->deleteImage($ekstrakurikuler->gambar);
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'ekstrakurikuler', 800, 600);
        }

        $ekstrakurikuler->update($validated);

        return redirect()->route('admin.ekstrakurikulers.index')->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        $this->deleteImage($ekstrakurikuler->gambar);
        $ekstrakurikuler->delete();
        return redirect()->route('admin.ekstrakurikulers.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
