<?php

namespace Database\Seeders;

use App\Models\KategoriArtikel;
use Illuminate\Database\Seeder;

class KategoriArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Berita', 'warna' => '#3B82F6'],
            ['nama' => 'Kegiatan', 'warna' => '#10B981'],
            ['nama' => 'Pengumuman', 'warna' => '#F59E0B'],
            ['nama' => 'Prestasi', 'warna' => '#EF4444'],
        ];

        foreach ($kategoris as $k) {
            KategoriArtikel::create(array_merge($k, ['is_active' => true]));
        }
    }
}
