<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $pengumumen = Pengumuman::latest()->paginate(15);
        return view('admin.pengumumen.index', compact('pengumumen'));
    }

    public function create()
    {
        return view('admin.pengumumen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'is_urgent' => 'boolean',
            'expired_at' => 'nullable|date',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_urgent'] = $request->boolean('is_urgent');

        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'pengumuman', 1200, 630);
        }

        Pengumuman::create($validated);

        return redirect()->route('admin.pengumumen.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumumen.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'is_urgent' => 'boolean',
            'expired_at' => 'nullable|date',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_urgent'] = $request->boolean('is_urgent');

        if ($request->hasFile('gambar')) {
            $this->deleteImage($pengumuman->gambar);
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'pengumuman', 1200, 630);
        }

        $pengumuman->update($validated);

        return redirect()->route('admin.pengumumen.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $this->deleteImage($pengumuman->gambar);
        $pengumuman->delete();
        return redirect()->route('admin.pengumumen.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function toggleUrgent(Pengumuman $pengumuman)
    {
        $pengumuman->update(['is_urgent' => !$pengumuman->is_urgent]);
        return back()->with('success', 'Status urgent diperbarui.');
    }
}
