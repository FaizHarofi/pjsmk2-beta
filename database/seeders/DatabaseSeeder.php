<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SekolahSeeder::class,
            JurusanSeeder::class,
            KategoriArtikelSeeder::class,
            ArtikelSeeder::class,
            KategoriVideoSeeder::class,
            VideoSeeder::class,
            AlbumGaleriSeeder::class,
            PengumumanSeeder::class,
            PrestasiSeeder::class,
            GuruSeeder::class,
            EkstrakurikulerSeeder::class,
            FasilitasSeeder::class,
            SliderSeeder::class,
            LinkTerkaitSeeder::class,
        ]);
    }
}
