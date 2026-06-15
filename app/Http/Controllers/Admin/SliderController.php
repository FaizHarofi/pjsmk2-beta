<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $sliders = Slider::ordered()->paginate(15);
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'sub_judul' => 'nullable|string|max:500',
            'gambar' => 'required|image|max:4096',
            'link' => 'nullable|url',
            'tombol_text' => 'nullable|string|max:50',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'sliders', 1920, 800);
        }

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'sub_judul' => 'nullable|string|max:500',
            'gambar' => 'nullable|image|max:4096',
            'link' => 'nullable|url',
            'tombol_text' => 'nullable|string|max:50',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('gambar')) {
            $this->deleteImage($slider->gambar);
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'sliders', 1920, 800);
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy(Slider $slider)
    {
        $this->deleteImage($slider->gambar);
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil dihapus.');
    }
}
