<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use Illuminate\Database\Seeder;

class EkstrakurikulerSeeder extends Seeder
{
    public function run(): void
    {
        $ekskuls = [
            ['nama' => 'Pramuka', 'hari' => 'Jumat', 'jam' => '14:00 - 16:00', 'urutan' => 1],
            ['nama' => 'Basket', 'hari' => 'Selasa', 'jam' => '15:00 - 17:00', 'urutan' => 2],
            ['nama' => 'Futsal', 'hari' => 'Rabu', 'jam' => '15:00 - 17:00', 'urutan' => 3],
            ['nama' => 'Rohis', 'hari' => 'Kamis', 'jam' => '14:00 - 16:00', 'urutan' => 4],
        ];

        foreach ($ekskuls as $e) {
            Ekstrakurikuler::create(array_merge($e, ['is_active' => true]));
        }
    }
}
