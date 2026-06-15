<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'sekolah';

    protected $fillable = [
        'nama', 'nama_en', 'npsn', 'alamat', 'alamat_en', 'telepon', 'email', 'website',
        'logo', 'favicon', 'hero_image', 'visi', 'visi_en', 'misi', 'misi_en',
        'sejarah', 'sejarah_en', 'kata_sambutan', 'kata_sambutan_en',
        'foto_kepsek', 'nama_kepsek', 'facebook_url', 'instagram_url', 'youtube_url',
        'tiktok_url', 'twitter_url', 'latitude', 'longitude',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }
}
