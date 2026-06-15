<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusans = [
            ['nama' => 'Teknik Komputer dan Jaringan', 'singkatan' => 'TKJ', 'warna' => '#3B82F6', 'icon' => 'network', 'urutan' => 1],
            ['nama' => 'Rekayasa Perangkat Lunak', 'singkatan' => 'RPL', 'warna' => '#10B981', 'icon' => 'code', 'urutan' => 2],
            ['nama' => 'Multimedia', 'singkatan' => 'MM', 'warna' => '#F59E0B', 'icon' => 'palette', 'urutan' => 3],
            ['nama' => 'Teknik Audio Video', 'singkatan' => 'TAV', 'warna' => '#EF4444', 'icon' => 'tv', 'urutan' => 4],
        ];

        foreach ($jurusans as $j) {
            Jurusan::create(array_merge($j, ['is_active' => true]));
        }
    }
}
