<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function show(Request $request, string $path)
    {
        $path = ltrim($path, '/');

        if ($path === '' || str_contains($path, '..')) {
            abort(404);
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($path)) {
            $default = public_path('assets/img/no-image.png');
            if (file_exists($default)) {
                return response()->file($default, [
                    'Cache-Control' => 'public, max-age=3600',
                ]);
            }
            abort(404);
        }

        if (!$this->isAuthorized($request)) {
            abort(403, 'Akses ditolak. Asset hanya bisa diakses dari halaman website.');
        }

        return $disk->response($path, null, [
            'Cache-Control' => 'private, max-age=300',
        ]);
    }

    protected function isAuthorized(Request $request): bool
    {
        if ($request->user()) {
            return true;
        }

        $referer = $request->header('referer');
        if (!$referer) {
            return false;
        }

        $refererHost = parse_url($referer, PHP_URL_HOST);
        if (!$refererHost) {
            return false;
        }

        $requestHost = $request->getHost();
        $appHost = parse_url(config('app.url'), PHP_URL_HOST);

        if ($refererHost === $requestHost) {
            return true;
        }

        if ($appHost && $refererHost === $appHost) {
            return true;
        }

        return false;
    }
}
