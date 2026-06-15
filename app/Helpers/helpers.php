<?php

use App\Models\Sekolah;
use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('sekolah')) {
    function sekolah(): ?Sekolah
    {
        return Sekolah::first();
    }
}

if (!function_exists('format_tanggal')) {
    function format_tanggal($date): string
    {
        return Carbon::parse($date)->translatedFormat('d F Y');
    }
}

if (!function_exists('youtube_id')) {
    function youtube_id($url): ?string
    {
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches);
        return $matches[1] ?? null;
    }
}

if (!function_exists('youtube_thumbnail')) {
    function youtube_thumbnail($url): ?string
    {
        $id = youtube_id($url);
        return $id ? "https://img.youtube.com/vi/{$id}/maxresdefault.jpg" : null;
    }
}

if (!function_exists('youtube_embed')) {
    function youtube_embed($url): ?string
    {
        $id = youtube_id($url);
        return $id ? "https://www.youtube.com/embed/{$id}" : null;
    }
}

if (!function_exists('truncate_text')) {
    function truncate_text($text, int $limit = 100): string
    {
        return Str::limit(strip_tags($text), $limit);
    }
}
