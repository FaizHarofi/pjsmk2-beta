<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            Slider::create([
                'judul' => "Selamat Datang di SMKN 2 Pekanbaru",
                'sub_judul' => "Slider {$i}: Sekolah Unggul Berkarakter",
                'gambar' => 'sliders/placeholder.jpg',
                'tombol_text' => 'Selengkapnya',
                'is_active' => true,
                'urutan' => $i,
            ]);
        }
    }
}
