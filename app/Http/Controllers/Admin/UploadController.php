<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Traits\AjaxResponse;
use App\Traits\HasImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class UploadController extends Controller
{
    use HasImageUpload, AjaxResponse;

    protected array $folderSizes = [
        'artikels'           => ['w' => 1200, 'h' => 630, 'fit' => 'scale'],
        'jurusans'           => ['w' => 800,  'h' => 600, 'fit' => 'scale'],
        'ketua-jurusans'     => ['w' => 400,  'h' => 500, 'fit' => 'scale'],
        'gurus'              => ['w' => 400,  'h' => 500, 'fit' => 'scale'],
        'galeris'            => ['w' => 1920, 'h' => null, 'fit' => 'scale'],
        'galeris/fotos'      => ['w' => 1920, 'h' => null, 'fit' => 'scale'],
        'prestasis'          => ['w' => 800,  'h' => 600, 'fit' => 'scale'],
        'pengumuman'         => ['w' => 1200, 'h' => 630, 'fit' => 'scale'],
        'ekstrakurikuler'    => ['w' => 800,  'h' => 600, 'fit' => 'scale'],
        'fasilitas'          => ['w' => 1200, 'h' => 800, 'fit' => 'scale'],
        'sliders'            => ['w' => 1920, 'h' => 800, 'fit' => 'scale'],
        'links'              => ['w' => 300,  'h' => 300, 'fit' => 'scale'],
        'users'              => ['w' => 200,  'h' => 200, 'fit' => 'cover'],
        'sekolah/logo'       => ['w' => 200,  'h' => 200, 'fit' => 'contain'],
        'sekolah/favicon'    => ['w' => 64,   'h' => 64,  'fit' => 'cover'],
        'sekolah/hero'       => ['w' => 1920, 'h' => 800, 'fit' => 'cover'],
        'sekolah/kepsek'     => ['w' => 400,  'h' => 500, 'fit' => 'cover'],
    ];

    public function image(Request $request)
    {
        $request->validate([
            'folder'      => 'required|string|max:100',
            'image_data'  => 'required|string',
            'album_id'    => 'nullable|exists:album_galeris,id',
        ]);

        $folder = $request->input('folder');
        $dataUrl = $request->input('image_data');

        if (!str_contains($dataUrl, ';base64,')) {
            return $this->jsonError('Format gambar tidak valid.');
        }

        [$meta, $base64] = explode(';base64,', $dataUrl, 2);
        $raw = base64_decode($base64);
        if (!$raw) {
            return $this->jsonError('Gagal decode gambar.');
        }

        $tmp = tempnam(sys_get_temp_dir(), 'up_');
        file_put_contents($tmp, $raw);

        $manager = new ImageManager(new Driver());
        $image = $manager->read($tmp);

        $cfg = $this->folderSizes[$folder] ?? ['w' => 1200, 'h' => null, 'fit' => 'scale'];

        $w = $cfg['w'] ?? 1200;
        $h = $cfg['h'] ?? null;
        $fit = $cfg['fit'] ?? 'scale';

        if ($fit === 'cover' && $w && $h) {
            $image->cover($w, $h);
        } elseif ($fit === 'contain' && $w && $h) {
            $image->contain($w, $h, background: 'ffffff');
        } elseif ($w && $h) {
            $image->scaleDown(width: $w, height: $h);
        } elseif ($w) {
            $image->scaleDown(width: $w);
        }

        $filename = $folder . '/' . Str::uuid() . '.webp';
        Storage::disk('public')->put($filename, (string) $image->encode(new WebpEncoder(82)));

        @unlink($tmp);

        $sizeKb = round(strlen(Storage::disk('public')->get($filename)) / 1024, 1);

        if ($folder === 'galeris/fotos' && $request->filled('album_id')) {
            Galeri::create([
                'album_galeri_id' => $request->album_id,
                'file_path'       => $filename,
                'file_type'       => 'image',
            ]);
        }

        return $this->jsonSuccess('Upload berhasil!', [
            'path'      => $filename,
            'url'       => asset('storage/' . $filename),
            'size_kb'   => $sizeKb,
            'folder'    => $folder,
        ]);
    }
}
