<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Jurusan extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'nama', 'nama_en', 'slug', 'singkatan', 'deskripsi', 'deskripsi_en',
        'gambar', 'icon', 'warna', 'urutan', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nama')
            ->saveSlugsTo('slug');
    }

    public function ketuaJurusan()
    {
        return $this->hasOne(KetuaJurusan::class);
    }

    public function gurus()
    {
        return $this->hasMany(Guru::class);
    }

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('created_at', 'desc');
    }
}
