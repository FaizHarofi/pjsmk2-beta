<?php

namespace Database\Seeders;

use App\Models\Prestasi;
use Illuminate\Database\Seeder;

class PrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['judul' => 'Juara 1 LKS Tingkat Provinsi', 'nama_siswa' => 'Ahmad Rizki', 'tingkat' => 'provinsi', 'tahun' => 2024],
            ['judul' => 'Juara 2 Kompetisi Robotik Nasional', 'nama_siswa' => 'Siti Nurhaliza', 'tingkat' => 'nasional', 'tahun' => 2024],
            ['judul' => 'Juara 3 Lomba Web Design Kota', 'nama_siswa' => 'Budi Santoso', 'tingkat' => 'kota', 'tahun' => 2025],
        ];

        foreach ($data as $d) {
            Prestasi::create(array_merge($d, ['is_published' => true]));
        }
    }
}
