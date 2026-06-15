<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'nip', 'foto', 'jabatan', 'mapel', 'jurusan_id', 'email', 'is_active', 'urutan',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
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
