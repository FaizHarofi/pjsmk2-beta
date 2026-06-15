<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $gurus = Guru::with('jurusan')->ordered()->paginate(15);
        return view('admin.gurus.index', compact('gurus'));
    }

    public function create()
    {
        $jurusans = Jurusan::active()->get();
        return view('admin.gurus.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:30',
            'foto' => 'nullable|image|max:2048',
            'jabatan' => 'nullable|string|max:255',
            'mapel' => 'nullable|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->uploadImage($request->file('foto'), 'gurus', 400, 500);
        }

        Guru::create($validated);

        return redirect()->route('admin.gurus.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        $jurusans = Jurusan::active()->get();
        return view('admin.gurus.edit', compact('guru', 'jurusans'));
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:30',
            'foto' => 'nullable|image|max:2048',
            'jabatan' => 'nullable|string|max:255',
            'mapel' => 'nullable|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('foto')) {
            $this->deleteImage($guru->foto);
            $validated['foto'] = $this->uploadImage($request->file('foto'), 'gurus', 400, 500);
        }

        $guru->update($validated);

        return redirect()->route('admin.gurus.index')->with('success', 'Guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $this->deleteImage($guru->foto);
        $guru->delete();
        return redirect()->route('admin.gurus.index')->with('success', 'Guru berhasil dihapus.');
    }
}
