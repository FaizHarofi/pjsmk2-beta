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
        'artikels/konten'    => ['w' => 1200, 'h' => null, 'fit' => 'scale'],
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

        $manager = new ImageManager(new Driver());
        $image = $manager->decodeDataUri($dataUrl);

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
            'url'       => url('uploads/' . $filename),
            'size_kb'   => $sizeKb,
            'folder'    => $folder,
        ]);
    }

    public function delete(Request $request)
    {
        if ($request->has('paths') && is_array($request->input('paths'))) {
            return $this->bulkDelete($request);
        }

        $request->validate([
            'path' => 'required|string|max:500',
        ]);

        $path = $request->input('path');
        $disk = Storage::disk('public');

        if (!$disk->exists($path)) {
            return $this->jsonError('File tidak ditemukan.');
        }

        $protected = ['.', '..', '.gitignore'];
        $basename = basename($path);
        if (in_array($basename, $protected) || str_starts_with($basename, '.')) {
            return $this->jsonError('File ini tidak boleh dihapus.');
        }

        $referenced = $this->findReferences($path);

        if (!empty($referenced)) {
            return $this->jsonError('File sedang digunakan: ' . implode(', ', array_keys($referenced)), [
                'referenced' => $referenced,
            ], 422);
        }

        $disk->delete($path);

        return $this->jsonSuccess('File berhasil dihapus.', [
            'deleted' => true,
            'path' => $path,
        ]);
    }

    protected function bulkDelete(Request $request)
    {
        $paths = $request->input('paths', []);
        if (!is_array($paths) || empty($paths)) {
            return $this->jsonError('Tidak ada file dipilih.');
        }
        if (count($paths) > 100) {
            return $this->jsonError('Maksimal 100 file per hapus.');
        }

        $disk = Storage::disk('public');
        $deleted = [];
        $skipped = [];

        foreach ($paths as $path) {
            if (!is_string($path) || strlen($path) > 500) continue;
            $basename = basename($path);
            if (in_array($basename, ['.', '..', '.gitignore']) || str_starts_with($basename, '.')) {
                $skipped[$path] = 'protected';
                continue;
            }
            if (!$disk->exists($path)) {
                $skipped[$path] = 'not_found';
                continue;
            }
            $referenced = $this->findReferences($path);
            if (!empty($referenced)) {
                $skipped[$path] = 'in_use:' . implode(',', array_keys($referenced));
                continue;
            }
            $disk->delete($path);
            $deleted[] = $path;
        }

        return $this->jsonSuccess(count($deleted) . ' file dihapus, ' . count($skipped) . ' dilewati.', [
            'deleted' => $deleted,
            'skipped' => $skipped,
        ]);
    }

    protected function findReferences(string $path): array
    {
        $url = asset('storage/' . $path);
        $references = [];

        $models = [
            \App\Models\Artikel::class => 'gambar',
            \App\Models\Jurusan::class => 'gambar',
            \App\Models\KetuaJurusan::class => 'foto',
            \App\Models\Guru::class => 'foto',
            \App\Models\Prestasi::class => 'gambar',
            \App\Models\Pengumuman::class => 'gambar',
            \App\Models\Ekstrakurikuler::class => 'gambar',
            \App\Models\Fasilitas::class => 'gambar',
            \App\Models\Slider::class => 'gambar',
            \App\Models\LinkTerkait::class => 'logo',
            \App\Models\User::class => 'avatar',
            \App\Models\AlbumGaleri::class => 'cover',
            \App\Models\Galeri::class => 'file_path',
        ];

        foreach ($models as $model => $field) {
            $found = $model::where($field, $path)->limit(5)->get(['id']);
            if ($found->count() > 0) {
                $shortName = (new \ReflectionClass($model))->getShortName();
                $references[$shortName] = $found->pluck('id')->toArray();
            }
        }

        return $references;
    }

    public function list(Request $request)
    {
        $folder = $request->input('folder');
        $search = $request->input('search');
        $page = (int) $request->input('page', 1);
        $perPage = 24;
        $disk = Storage::disk('public');

        $allFolders = collect($disk->directories())->map(function ($d) {
            return str_replace('\\', '/', $d);
        })->reject(fn($d) => str_starts_with($d, '.') || str_contains($d, '/'))->sort()->values();

        $target = $folder ?: 'artikels';
        if (!$disk->exists($target)) {
            return response()->json([
                'status' => 'success',
                'data' => ['items' => [], 'folders' => $allFolders, 'current' => $target, 'total' => 0, 'has_more' => false],
            ]);
        }

        $allFiles = collect($disk->allFiles($target))
            ->reject(fn($f) => str_contains(basename($f), '.gitignore'));

        if ($search) {
            $allFiles = $allFiles->filter(fn($f) => str_contains(strtolower(basename($f)), strtolower($search)));
        }

        $total = $allFiles->count();
        $files = $allFiles->sortByDesc(fn($f) => $disk->lastModified($f))->values()->forPage($page, $perPage);

        $items = $files->map(function ($path) use ($disk) {
            $name = basename($path);
            $size = $disk->size($path);
            $mtime = $disk->lastModified($path);
            return [
                'name' => $name,
                'path' => $path,
                'url'  => url('uploads/' . $path),
                'size_kb' => round($size / 1024, 1),
                'modified' => date('Y-m-d H:i', $mtime),
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => [
                'items'      => $items,
                'folders'    => $allFolders,
                'current'    => $target,
                'total'      => $total,
                'page'       => $page,
                'per_page'   => $perPage,
                'has_more'   => $total > ($page * $perPage),
            ],
        ]);
    }
}
