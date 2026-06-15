<?php

namespace Database\Seeders;

use App\Models\LinkTerkait;
use Illuminate\Database\Seeder;

class LinkTerkaitSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            ['nama' => 'Kemendikbud', 'url' => 'https://kemdikbud.go.id', 'urutan' => 1],
            ['nama' => 'Dinas Pendidikan Riau', 'url' => 'https://dikpora.riau.go.id', 'urutan' => 2],
            ['nama' => 'Vokasi', 'url' => 'https://vokasi.kemdikbud.go.id', 'urutan' => 3],
        ];

        foreach ($links as $l) {
            LinkTerkait::create(array_merge($l, ['is_active' => true]));
        }
    }
}
