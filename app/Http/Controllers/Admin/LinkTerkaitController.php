<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LinkTerkait;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class LinkTerkaitController extends Controller
{
    use HasImageUpload;

    public function index()
    {
        $links = LinkTerkait::ordered()->paginate(15);
        return view('admin.link-terkaits.index', compact('links'));
    }

    public function create()
    {
        return view('admin.link-terkaits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'logo' => 'nullable|image|max:1024',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $this->uploadImage($request->file('logo'), 'links', 300, 300);
        }

        LinkTerkait::create($validated);

        return redirect()->route('admin.link-terkaits.index')->with('success', 'Link terkait berhasil ditambahkan.');
    }

    public function edit(LinkTerkait $linkTerkait)
    {
        return view('admin.link-terkaits.edit', compact('linkTerkait'));
    }

    public function update(Request $request, LinkTerkait $linkTerkait)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'logo' => 'nullable|image|max:1024',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('logo')) {
            $this->deleteImage($linkTerkait->logo);
            $validated['logo'] = $this->uploadImage($request->file('logo'), 'links', 300, 300);
        }

        $linkTerkait->update($validated);

        return redirect()->route('admin.link-terkaits.index')->with('success', 'Link terkait berhasil diperbarui.');
    }

    public function destroy(LinkTerkait $linkTerkait)
    {
        $this->deleteImage($linkTerkait->logo);
        $linkTerkait->delete();
        return redirect()->route('admin.link-terkaits.index')->with('success', 'Link terkait berhasil dihapus.');
    }
}
