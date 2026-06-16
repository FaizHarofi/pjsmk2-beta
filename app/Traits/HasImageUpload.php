<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

trait HasImageUpload
{
    /**
     * Default multi-size variant set.
     * Flow: RESIZE first, then encode to WebP.
     */
    protected static array $imageVariants = [
        'original' => ['w' => 1920, 'h' => null, 'quality' => 85, 'fit' => 'scale'],
        'large'    => ['w' => 1200, 'h' => null, 'quality' => 82, 'fit' => 'scale'],
        'medium'   => ['w' => 800,  'h' => null, 'quality' => 80, 'fit' => 'scale'],
        'thumb'    => ['w' => 400,  'h' => 400,  'quality' => 78, 'fit' => 'cover'],
        'square'   => ['w' => 200,  'h' => 200,  'quality' => 75, 'fit' => 'cover'],
    ];

    /**
     * Upload image. RESIZE first → then convert to WebP.
     *
     * Backward compat: pass int $width & ?int $height for single-size mode.
     * New: pass array $variants for multi-size.
     *
     * @param  UploadedFile            $file
     * @param  string                  $folder
     * @param  int|array|null          $width   pixel width, or array of variant configs
     * @param  int|null                $height
     * @param  int                     $quality
     * @param  string                  $fit     'scale' | 'cover' | 'contain'
     * @param  string                  $mainVariant which variant path to return (multi mode)
     */
    public function uploadImage(
        UploadedFile $file,
        string $folder,
        int|array|null $width = 1920,
        ?int $height = null,
        int $quality = 85,
        string $fit = 'scale',
        string $mainVariant = 'large'
    ): string {
        $manager = new ImageManager(new Driver());
        $image = $manager->decode($file->getRealPath());

        if (is_array($width)) {
            return $this->processVariants($image, $folder, $width, $mainVariant);
        }

        $w = $width ?? 1920;
        $h = $height;

        if ($fit === 'cover' && $w && $h) {
            $image->cover($w, $h);
        } elseif ($fit === 'contain' && $w && $h) {
            $image->contain($w, $h, background: 'ffffff');
        } elseif ($w && $h) {
            $image->scaleDown(width: $w, height: $h);
        } elseif ($w) {
            $image->scaleDown(width: $w);
        } elseif ($h) {
            $image->scaleDown(height: $h);
        }

        $filename = $folder . '/' . Str::uuid() . '.webp';
        Storage::disk('public')->put($filename, (string) $image->encode(new WebpEncoder($quality)));

        return $filename;
    }

    /**
     * Upload and produce all configured variants. Returns the main variant path.
     */
    public function uploadImageVariants(
        UploadedFile $file,
        string $folder,
        ?array $variants = null,
        string $mainVariant = 'large'
    ): string {
        $manager = new ImageManager(new Driver());
        return $this->processVariants(
            $manager->decode($file->getRealPath()),
            $folder,
            $variants ?? self::$imageVariants,
            $mainVariant
        );
    }

    /**
     * Get all variant paths as array (after uploadImageVariants).
     * Useful for models that store JSON of all variants.
     */
    public function getAllVariants(string $mainPath): array
    {
        $pathInfo = pathinfo($mainPath);
        $dir = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $variants = [];
        foreach (Storage::disk('public')->directories($dir) as $variantDir) {
            $variant = basename($variantDir);
            $candidates = Storage::disk('public')->files("{$dir}/{$variant}");
            foreach ($candidates as $f) {
                if (str_contains(basename($f), $filename)) {
                    $variants[$variant] = $f;
                    break;
                }
            }
        }
        return $variants;
    }

    /**
     * Delete image — accepts single path, JSON, or array.
     */
    public function deleteImage(mixed $paths): void
    {
        if (!$paths) return;

        if (is_string($paths)) {
            $decoded = json_decode($paths, true);
            $paths = is_array($decoded) ? $decoded : [$paths];
        } elseif (!is_array($paths)) {
            return;
        }

        $disk = Storage::disk('public');
        foreach ($paths as $path) {
            if (!$path || !is_string($path)) continue;

            if ($disk->exists($path)) {
                $disk->delete($path);
                continue;
            }

            $folder = dirname($path);
            $filename = pathinfo($path, PATHINFO_FILENAME);
            foreach ($disk->files($folder) as $f) {
                if (str_contains(basename($f), $filename)) {
                    $disk->delete($f);
                }
            }
        }
    }

    /**
     * Replace existing image: delete old variants, then upload new.
     */
    public function replaceImage(
        UploadedFile $file,
        string $folder,
        mixed $oldPaths = null,
        int|array|null $width = 1920,
        ?int $height = null,
        int $quality = 85,
        string $fit = 'scale',
        string $mainVariant = 'large'
    ): string {
        if ($oldPaths) {
            $this->deleteImage($oldPaths);
        }
        return $this->uploadImage($file, $folder, $width, $height, $quality, $fit, $mainVariant);
    }

    /**
     * Resize & convert an existing stored image (e.g. imported from external).
     */
    public function reprocessImage(string $existingPath, int $width = 1920, ?int $height = null, int $quality = 85, string $fit = 'scale'): string
    {
        $disk = Storage::disk('public');
        $manager = new ImageManager(new Driver());

        $fullPath = $disk->path($existingPath);
        if (!file_exists($fullPath)) return $existingPath;

        $image = $manager->decode($fullPath);

        if ($fit === 'cover' && $width && $height) {
            $image->cover($width, $height);
        } elseif ($fit === 'contain' && $width && $height) {
            $image->contain($width, $height, background: 'ffffff');
        } elseif ($width && $height) {
            $image->scaleDown(width: $width, height: $height);
        } elseif ($width) {
            $image->scaleDown(width: $width);
        }

        $newPath = preg_replace('/\.(jpe?g|png|gif|bmp)$/i', '.webp', $existingPath);
        $newPath = preg_replace('/(.+)\.webp$/', '$1.webp', $newPath);

        $disk->put($newPath, (string) $image->encode(new WebpEncoder($quality)));

        if ($newPath !== $existingPath) {
            $disk->delete($existingPath);
        }

        return $newPath;
    }

    public function imageUrl(?string $path): ?string
    {
        return $path ? asset('storage/' . $path) : null;
    }

    /**
     * Resolve image input: prefer cropped path from hidden field, else upload file.
     * Returns the path to store, or null.
     */
    protected function resolveImageInput(Request $request, string $field, ?string $currentPath = null, ?string $folder = null, int $width = 1200, ?int $height = null, int $quality = 85, string $fit = 'scale'): ?string
    {
        $croppedPath = $request->input($field);
        if ($croppedPath && $croppedPath !== $currentPath) {
            if ($currentPath) $this->deleteImage($currentPath);
            return $croppedPath;
        }
        if ($request->hasFile($field) && $folder) {
            if ($currentPath) $this->deleteImage($currentPath);
            return $this->uploadImage($request->file($field), $folder, $width, $height, $quality, $fit);
        }
        return null;
    }

    /**
     * Internal: process a single image into multiple variants.
     */
    protected function processVariants($image, string $folder, array $variants, string $mainVariant): string
    {
        $baseName = Str::uuid()->toString();
        $mainPath = null;
        $disk = Storage::disk('public');

        foreach ($variants as $variant => $cfg) {
            $img = clone $image;

            $w = $cfg['w'] ?? null;
            $h = $cfg['h'] ?? null;
            $quality = $cfg['quality'] ?? 80;
            $fit = $cfg['fit'] ?? 'scale';

            if ($fit === 'cover' && $w && $h) {
                $img->cover($w, $h);
            } elseif ($fit === 'contain' && $w && $h) {
                $img->contain($w, $h, background: 'ffffff');
            } elseif ($w && $h) {
                $img->scaleDown(width: $w, height: $h);
            } elseif ($w) {
                $img->scaleDown(width: $w);
            } elseif ($h) {
                $img->scaleDown(height: $h);
            }

            $path = "{$folder}/{$variant}/{$baseName}.webp";
            $disk->put($path, (string) $img->encode(new WebpEncoder($quality)));

            if ($variant === $mainVariant) {
                $mainPath = $path;
            }
        }

        return $mainPath ?? "{$folder}/{$mainVariant}/{$baseName}.webp";
    }
}
