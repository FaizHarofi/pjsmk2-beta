<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $fasilitas = [
            ['nama' => 'Laboratorium Komputer', 'urutan' => 1],
            ['nama' => 'Perpustakaan', 'urutan' => 2],
            ['nama' => 'Lapangan Olahraga', 'urutan' => 3],
            ['nama' => 'Aula Serbaguna', 'urutan' => 4],
        ];

        foreach ($fasilitas as $f) {
            Fasilitas::create(array_merge($f, ['is_active' => true]));
        }
    }
}
