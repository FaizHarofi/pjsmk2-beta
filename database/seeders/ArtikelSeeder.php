<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $kategoris = KategoriArtikel::all();

        for ($i = 1; $i <= 10; $i++) {
            Artikel::create([
                'kategori_artikel_id' => $kategoris->random()->id,
                'user_id' => $user->id,
                'judul' => "Artikel Contoh {$i}: Berita Terbaru SMKN 2 Pekanbaru",
                'ringkasan' => "Ringkasan artikel {$i} yang berisi informasi terkini tentang kegiatan sekolah.",
                'konten' => "<p>Konten artikel {$i}...</p><p>Paragraf kedua dengan informasi detail.</p>",
                'is_published' => true,
                'is_featured' => $i <= 2,
                'published_at' => now()->subDays($i),
                'views' => rand(50, 500),
            ]);
        }
    }
}
