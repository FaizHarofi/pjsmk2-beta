<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        Pengumuman::create([
            'judul' => 'Penerimaan Peserta Didik Baru 2025',
            'konten' => '<p>Pendaftaran dibuka mulai Juni 2025...</p>',
            'is_published' => true,
            'is_urgent' => true,
            'published_at' => now(),
            'expired_at' => now()->addMonths(3),
        ]);

        Pengumuman::create([
            'judul' => 'Jadwal Ujian Akhir Semester',
            'konten' => '<p>Ujian akhir semester dimulai...</p>',
            'is_published' => true,
            'is_urgent' => false,
            'published_at' => now()->subDays(2),
        ]);
    }
}
