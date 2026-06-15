<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Artikel extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'kategori_artikel_id', 'user_id', 'judul', 'judul_en', 'slug',
        'ringkasan', 'ringkasan_en', 'konten', 'konten_en', 'gambar',
        'is_published', 'is_featured', 'published_at', 'views',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('judul')
            ->saveSlugsTo('slug');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriArtikel::class, 'kategori_artikel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'artikel_tag', 'artikel_id', 'tag_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('published_at', 'desc');
    }
}
