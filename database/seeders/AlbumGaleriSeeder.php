<?php

namespace Database\Seeders;

use App\Models\AlbumGaleri;
use Illuminate\Database\Seeder;

class AlbumGaleriSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 4; $i++) {
            AlbumGaleri::create([
                'judul' => "Album Foto {$i}",
                'deskripsi' => "Dokumentasi kegiatan sekolah album {$i}",
                'is_published' => true,
                'published_at' => now()->subDays($i * 5),
            ]);
        }
    }
}
