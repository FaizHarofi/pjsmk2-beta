<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\KetuaJurusan;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class KetuaJurusanController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $ketuas = KetuaJurusan::with('jurusan')->paginate(15);
        return view('admin.ketua-jurusans.index', compact('ketuas'));
    }

    public function create()
    {
        $jurusans = Jurusan::active()->ordered()->get();
        return view('admin.ketua-jurusans.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:30',
            'foto' => 'nullable|image|max:2048',
            'jabatan' => 'nullable|string|max:255',
            'periode' => 'nullable|string|max:50',
            'sambutan' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->uploadImage($request->file('foto'), 'gurus', 400, 500);
        }

        KetuaJurusan::create($validated);

        return redirect()->route('admin.ketua-jurusans.index')->with('success', 'Ketua jurusan berhasil ditambahkan.');
    }

    public function edit(KetuaJurusan $ketuaJurusan)
    {
        $jurusans = Jurusan::active()->ordered()->get();
        return view('admin.ketua-jurusans.edit', compact('ketuaJurusan', 'jurusans'));
    }

    public function update(Request $request, KetuaJurusan $ketuaJurusan)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:30',
            'foto' => 'nullable|image|max:2048',
            'jabatan' => 'nullable|string|max:255',
            'periode' => 'nullable|string|max:50',
            'sambutan' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('foto')) {
            $this->deleteImage($ketuaJurusan->foto);
            $validated['foto'] = $this->uploadImage($request->file('foto'), 'gurus', 400, 500);
        }

        $ketuaJurusan->update($validated);

        return redirect()->route('admin.ketua-jurusans.index')->with('success', 'Ketua jurusan berhasil diperbarui.');
    }

    public function destroy(KetuaJurusan $ketuaJurusan)
    {
        $this->deleteImage($ketuaJurusan->foto);
        $ketuaJurusan->delete();

        return redirect()->route('admin.ketua-jurusans.index')->with('success', 'Ketua jurusan berhasil dihapus.');
    }
}
