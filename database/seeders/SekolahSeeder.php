<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    public function run(): void
    {
        Sekolah::create([
            'nama' => 'SMK Negeri 2 Pekanbaru',
            'nama_en' => 'SMK Negeri 2 Pekanbaru',
            'npsn' => '10400338',
            'alamat' => 'Jl. Kaharuddin Nasution, Pekanbaru, Riau',
            'alamat_en' => 'Jl. Kaharuddin Nasution, Pekanbaru, Riau',
            'telepon' => '(0761) 21633',
            'email' => 'info@smkn2pekanbaru.sch.id',
            'website' => 'https://smkn2pekanbaru.sch.id',
            'visi' => 'Menjadi sekolah unggul dalam bidang teknologi dan informasi yang berkarakter dan berdaya saing global.',
            'visi_en' => 'To become an excellent school in technology and information with character and global competitiveness.',
            'misi' => '<ul><li>Melaksanakan pembelajaran berbasis teknologi</li><li>Mengembangkan karakter siswa</li><li>Menjalin kerjasama dengan dunia usaha</li></ul>',
            'misi_en' => '<ul><li>Implement technology-based learning</li><li>Develop student character</li><li>Build partnerships with industry</li></ul>',
            'sejarah' => '<p>SMK Negeri 2 Pekanbaru didirikan pada tahun 1992 sebagai salah satu sekolah keunggulan di Provinsi Riau.</p>',
            'sejarah_en' => '<p>SMK Negeri 2 Pekanbaru was established in 1992 as one of the leading schools in Riau Province.</p>',
            'kata_sambutan' => '<p>Selamat datang di website resmi SMK Negeri 2 Pekanbaru...</p>',
            'nama_kepsek' => 'Drs. M. Yusuf, M.Pd',
            'facebook_url' => 'https://facebook.com/smkn2pekanbaru',
            'instagram_url' => 'https://instagram.com/smkn2pekanbaru',
            'youtube_url' => 'https://youtube.com/@smkn2pekanbaru',
        ]);
    }
}
