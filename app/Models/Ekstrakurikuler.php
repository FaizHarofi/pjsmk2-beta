<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Ekstrakurikuler extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'ekstrakurikulers';

    protected $fillable = [
        'nama', 'slug', 'deskripsi', 'gambar', 'icon', 'pembina', 'hari', 'jam', 'is_active', 'urutan',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nama')
            ->saveSlugsTo('slug');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }
}
