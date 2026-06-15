<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class KategoriArtikel extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['nama', 'slug', 'warna', 'is_active'];

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

    public function artikels()
    {
        return $this->hasMany(Artikel::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
