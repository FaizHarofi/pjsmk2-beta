<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Prestasi extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'prestasis';

    protected $fillable = [
        'judul', 'slug', 'deskripsi', 'gambar', 'nama_siswa', 'kelas',
        'jurusan_id', 'tingkat', 'tahun', 'is_published',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('judul')
            ->saveSlugsTo('slug');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('tahun', 'desc');
    }
}
