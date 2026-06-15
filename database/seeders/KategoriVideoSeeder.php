<?php

namespace Database\Seeders;

use App\Models\KategoriVideo;
use Illuminate\Database\Seeder;

class KategoriVideoSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Profil Sekolah'],
            ['nama' => 'Kegiatan'],
            ['nama' => 'Tutorial'],
        ];

        foreach ($kategoris as $k) {
            KategoriVideo::create(array_merge($k, ['is_active' => true]));
        }
    }
}
