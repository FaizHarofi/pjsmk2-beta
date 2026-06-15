<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = ['album_galeri_id', 'judul', 'file_path', 'file_type', 'urutan'];

    public function album()
    {
        return $this->belongsTo(AlbumGaleri::class, 'album_galeri_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }
}
