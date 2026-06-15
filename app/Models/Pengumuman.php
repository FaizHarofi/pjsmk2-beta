<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Pengumuman extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'pengumumen';

    protected $fillable = [
        'judul', 'slug', 'konten', 'gambar', 'is_published', 'is_urgent',
        'published_at', 'expired_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_urgent' => 'boolean',
            'published_at' => 'datetime',
            'expired_at' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('judul')
            ->saveSlugsTo('slug');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('published_at', 'desc');
    }
}
