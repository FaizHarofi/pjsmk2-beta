<?php

namespace Database\Seeders;

use App\Models\KategoriVideo;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $kategoris = KategoriVideo::all();

        for ($i = 1; $i <= 6; $i++) {
            $videoId = 'dQw4w9WgXcQ';
            Video::create([
                'kategori_video_id' => $kategoris->random()->id,
                'user_id' => $user->id,
                'judul' => "Video Contoh {$i}: Kegiatan SMKN 2",
                'deskripsi' => "Deskripsi video {$i}",
                'youtube_url' => "https://www.youtube.com/watch?v={$videoId}",
                'youtube_embed' => "https://www.youtube.com/embed/{$videoId}",
                'is_published' => true,
                'published_at' => now()->subDays($i),
                'views' => rand(100, 1000),
                'urutan' => $i,
            ]);
        }
    }
}
