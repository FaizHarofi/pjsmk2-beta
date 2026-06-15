<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    use HasImageUpload;

    public function edit()
    {
        $sekolah = Sekolah::firstOrNew([]);
        return view('admin.sekolah.edit', compact('sekolah'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_en' => 'nullable|string|max:255',
            'npsn' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'sejarah' => 'nullable|string',
            'kata_sambutan' => 'nullable|string',
            'nama_kepsek' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'tiktok_url' => 'nullable|url|max:500',
            'twitter_url' => 'nullable|url|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'logo' => 'nullable|image|max:1024',
            'favicon' => 'nullable|image|max:512',
            'hero_image' => 'nullable|image|max:4096',
            'foto_kepsek' => 'nullable|image|max:1024',
        ]);

        $sekolah = Sekolah::firstOrNew([]);

        $imageConfigs = [
            'logo'        => ['w' => 200,  'h' => 200, 'fit' => 'contain', 'quality' => 85],
            'favicon'     => ['w' => 64,   'h' => 64,  'fit' => 'cover',   'quality' => 90],
            'hero_image'  => ['w' => 1920, 'h' => 800, 'fit' => 'cover',   'quality' => 82],
            'foto_kepsek' => ['w' => 400,  'h' => 500, 'fit' => 'cover',   'quality' => 82],
        ];

        foreach ($imageConfigs as $field => $cfg) {
            if ($request->hasFile($field)) {
                $this->deleteImage($sekolah->$field);
                $validated[$field] = $this->uploadImage(
                    $request->file($field),
                    'sekolah',
                    $cfg['w'],
                    $cfg['h'],
                    $cfg['quality'],
                    $cfg['fit']
                );
            }
        }

        $sekolah->fill($validated);
        $sekolah->save();

        return redirect()->route('admin.sekolah.edit')->with('success', 'Pengaturan sekolah berhasil diperbarui.');
    }
}
