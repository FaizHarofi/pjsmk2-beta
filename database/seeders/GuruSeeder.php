<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = [
            ['nama' => 'Drs. M. Yusuf, M.Pd', 'jabatan' => 'Kepala Sekolah', 'urutan' => 1],
            ['nama' => 'Dra. Siti Aminah', 'jabatan' => 'Wakasek Kurikulum', 'urutan' => 2],
            ['nama' => 'Ir. Budi Hartono', 'jabatan' => 'Ketua Jurusan TKJ', 'mapel' => 'Jaringan', 'urutan' => 3],
            ['nama' => 'Dra. Rina Wati', 'jabatan' => 'Guru Matematika', 'mapel' => 'Matematika', 'urutan' => 4],
            ['nama' => 'Agus Setiawan, S.Kom', 'jabatan' => 'Guru Produktif RPL', 'mapel' => 'Pemrograman', 'urutan' => 5],
        ];

        foreach ($gurus as $g) {
            Guru::create(array_merge($g, ['is_active' => true]));
        }
    }
}
